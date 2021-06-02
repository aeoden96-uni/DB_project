<?php


require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '/../model/user.class.php';

class StartController
{

	private function checkPrivilege(){
		if (isset($_SESSION["account_type"])){
			if($_SESSION["account_type"]=="user"){
				header( 'Location: index.php?rt=main');
				exit();
			}
			elseif($_SESSION["account_type"]=="guest"){
				header( 'Location: index.php?rt=start/logout');
				exit();
			}
			
		}
	}

	public function index() {


		session_start();

		if(isset($_SESSION["error"])){
		    echo $_SESSION["error"];

		    unset($_SESSION["error"]);
        }

		$this->checkPrivilege();


		//ako je ulogiran, nema šta radit na login screenu
		if( isset( $_SESSION['user'] )) 
		{
			header( 'Location: index.php?rt=main');
			exit();
		}

        $title = 'Community Store - Welcome';

		require_once __DIR__ . '/../view/start_index.php';
		require_once __DIR__ . '/../view/_footer.php';
	}

	public function signup($err=NULL){
		

	    if ( $err != NULL){
	        echo $err;
        }
	    else{
			$title="Register";
            require_once __DIR__ . '/../view/start_signup.php';
        }

	}

	public function signupResult(){
	    session_start();
	    $us= new UserService();

		if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) || !isset( $_POST['email'] ) )
		{
			$title="Error";
		    $response ="Nisi unio sve potrebne podatke.";
			
		}

		if( !preg_match( '/^[A-Za-z]{3,10}$/', $_POST['username'] ) )
		{
			$title="Error";
            $response = 'Korisničko ime treba imati između 3 i 10 slova.';
           

		}
		else if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
		{
			$title="Error";
            $response ='Email nije ispravan.' ;
            
		}
		else {

            if ($us->checkUsername($_POST['username'])) {
				$title="Error";
                $response = 'Korisnik s tim imenom već postoji u bazi.';
                
            }

			else{
					$newUser=new User(
					null,
					$_POST['username'],
					$_POST['email'],
					$_POST['password'],
					0,
					0,
					0,
					0,
					0
				);

				$response=$us->setRegLink($newUser);
				$title="Registration sequence sent.";

			}

		}

		if($response != NULL){
			
			$response = "Your registration sequence is " .  $response;
			require_once __DIR__ . '/../view/start_regMessage.php';
		}

        
	}

    public function reciveRegSeq(){


	    if(isset($_POST["reqSeq"])){
            $niz=$_POST["reqSeq"];
            session_start();
            $us= new UserService();

            $response= $us->checkRegSeq($niz);

        }
		else{
			$response= "ERROR::reciveRegSeq()::ACCESS";
		}
		header("Refresh:3; url=index.php?rt=start");
		$title="Registration successful.";
		require_once __DIR__ . '/../view/start_regMessage.php';
		exit();




    }


	public function login() {
		session_start();


		$title = '';

		$us= new UserService();

		

		if($us->checkUserLogin()){
			header("Refresh:2; url=index.php?rt=main");
			$succesVar="successful. :)";
            $_SESSION["account_type"] = "user";
		}
		else{
			$succesVar="unsuccessful. :(";
			session_destroy();
			header("Refresh:2; url=index.php?rt=start");
		}

		require_once __DIR__ . '/../view/start_login.php';
		require_once __DIR__ . '/../view/_footer.php';
		
	}

	public function guestLogin() {
		session_start();
		$title = '';


		$_SESSION["account_type"] = "guest"; 

		header("Refresh:2; url=index.php?rt=guest");
		$succesVar="successful. (GUEST)";


		require_once __DIR__ . '/../view/start_login.php';
		require_once __DIR__ . '/../view/_footer.php';
		
	}

	public function logout() {
		session_start();
        session_unset();
		session_destroy();

		header("Refresh:1; url=index.php?rt=start");

		require_once __DIR__ . '/../view/start_logout.php';
		require_once __DIR__ . '/../view/_footer.php';
		
	}

/******************************************************************** */



	public function loginCheckFaks(){
		session_start();

		//$check=$us->checkUserLogin();
		$check=true;


		if($check){
			header("Refresh:2; url=index.php?rt=faks");
			$succesVar="successful. :)";
            $_SESSION["account_type"] = "ucenik";
		}
		else{
			$succesVar="unsuccessful. :(";
			session_destroy();
			header("Refresh:2; url=index.php?rt=start");
		}

		require_once __DIR__ . '/../view/start_login.php';
	}

	public function loginCheckAdmin(){
		session_start();

		//$check=$us->checkUserLogin();
		$check=true;


		if($check){
			header("Refresh:2; url=index.php?rt=admin");
			$succesVar="successful. :)";
            $_SESSION["account_type"] = "ucenik";
		}
		else{
			$succesVar="unsuccessful. :(";
			session_destroy();
			header("Refresh:2; url=index.php?rt=start");
		}

		require_once __DIR__ . '/../view/start_login.php';
	}

	public function loginCheckUcenik(){
		/**
		 * KREIRA TEMP STRANICU login successfull ako SET=true
		 * REDIRECT NA ucenik DASHBOARD
		 * 
		 * REDIRECT NA registerUcenik ako SET=true
		 */
		session_start();

		//$check=$us->checkUserLogin();
		$check=true;


		if($check){
			header("Refresh:2; url=index.php?rt=ucenik");
			$succesVar="successful. :)";
            $_SESSION["account_type"] = "ucenik";
		}
		else{
			$succesVar="unsuccessful. :(";
			session_destroy();
			header("Refresh:2; url=index.php?rt=start");
		}

		require_once __DIR__ . '/../view/start_login.php';
	}
	

}; 

?>