<?php
require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';

class UserService
{

 

    private function queryBool($rowName,$rowData){

        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM users WHERE '. $rowName .'=:rowData' );
            $st->execute( array( 'rowData' => $rowData ) );
        }
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

        if( $st->rowCount() !== 0 )
        {
            return true;
        }
        return false;
    }


    public function checkUsername($username){
        return $this->queryBool("username",$username);
    }

    public function checkId($id){
        return $this->queryBool("id",$id);
    }



    public function queryOne($rowName,$rowData){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT *
                                    FROM users 
                                    WHERE '. $rowName . '=:data');
            $st->execute( array( 'data' => $rowData) );

        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $row = $st->fetch();

        $p=new User($row["id"],$row["username"],$row["email"],null,$row["score"],null,null,null,null );

        return $p;
    }

    public function getUserFromId($id)
    {
        return $this->queryOne("id",$id);
    }

    public function getUserFromUsername($username)
    {
        return $this->queryOne("username",$username);
    }





    public function setRegLink(User $newUser)
    {

        $reg_seq = '';
        for( $i = 0; $i < 20; ++$i )
            $reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo

        try
        {


            $db = DB::getConnection();
            $st = $db->prepare( 'INSERT INTO users(username, password, email, registration_sequence, has_registered) VALUES ' .
                '(:username, :password, :email, :registration_sequence, 0)' );



            $st->execute( array(
                'username' => $newUser->name,
                'password' => password_hash( $newUser->hashPass, PASSWORD_DEFAULT ),
                'email' => $newUser->email,
                'registration_sequence'  => $reg_seq )
            );
        }
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }


        // Sad mu još pošalji mail
        $to       = $newUser->email;
        $subject  = 'Registracijski mail';
        $message  = 'Poštovani ' . $_POST['username'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
        $message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/register.php?niz=' . $reg_seq . "\n";
        $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        //$isOK = mail($to, $subject, $message, $headers);
        $isOK=false;

        if( !$isOK ){
            $_SESSION["reg_seq"]=$reg_seq ;
            //exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.) ' . $reg_seq);
            return $reg_seq;

        }

        return NULL;

    }

    public function checkRegSeq($niz)
    {
        if( !isset( $niz ) || !preg_match( '/^[a-z]{20}$/', $niz ) )
            return  'Nešto ne valja s nizom.';

        // Nađi korisnika s tim nizom u bazi
        $db = DB::getConnection();

        try
        {

            $st = $db->prepare( 'SELECT * FROM users WHERE 	registration_sequence=:registration_sequence' );
            $st->execute( array( 'registration_sequence' => $niz ) );

        }
        catch( PDOException $e ) { return 'Greška u bazi: ' . $e->getMessage(); }

        $row = $st->fetch();

        if( $st->rowCount() !== 1 )
            return 'Taj registracijski niz ima ' . $st->rowCount() . 'korisnika, a treba biti točno 1 takav.';
        else
        {
            // Sad znamo da je točno jedan takav. Postavi mu has_registered na 1.
            try
            {

                $st = $db->prepare( 'UPDATE users SET has_registered=1 WHERE registration_sequence=:registration_sequence' );
                $st->execute( array( 'registration_sequence' => $niz ) );

            }
            catch( PDOException $e ) { return 'Greška u bazi: ' . $e->getMessage() ; }

            // Sve je uspjelo, zahvali mu na registraciji.
            return "Uspješno stvoren račun.";
        }


    }

    public function checkUserLogin()
    {
        // Analizira $_POST iz forme za login

        if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) )
        {


            $_SESSION["error"]="Trebate unijeti korisničko ime i lozinku.";
            header( 'Location: index.php?rt=start');
            exit();
        }

        if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['username'] ) )
        {

            $_SESSION["error"]='Korisničko ime treba imati između 3 i 10 slova.';
            header( 'Location: index.php?rt=start');
            exit();
        }

        // Dakle dobro je korisničko ime.
        // Provjeri taj korisnik postoji u bazi; dohvati njegove ostale podatke.
        $db = DB::getConnection();

        try
        {
            $st = $db->prepare( 'SELECT username, password, has_registered FROM users WHERE username=:username' );
            $st->execute( array( 'username' => $_POST['username'] ) );
        }
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

        $row = $st->fetch();

        if( $row === false )
        {
            $_SESSION["error"]='Korisnik s tim imenom ne postoji.';
            header( 'Location: index.php?rt=start');
            exit();

        }
        else if( $row['has_registered'] === '0' )
        {

            $_SESSION["error"]='Korisnik s tim imenom se nije još registrirao. Provjerite e-mail.';
            header( 'Location: index.php?rt=start');
            exit();
        }
        else if( !password_verify( $_POST['password'], $row['password'] ) )
        {

            $_SESSION["error"]='Lozinka nije ispravna.';
            header( 'Location: index.php?rt=start');
            exit();
        }
        else
        {
            // Sad je valjda sve OK. Ulogiraj ga.
            $_SESSION['username'] = $_POST['username'];

            return true;
        }
    }





}
?>