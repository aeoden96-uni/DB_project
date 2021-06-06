<?php

require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '../../model/product.class.php'; 
require_once __DIR__ . '/../model/productservice.class.php';
require_once __DIR__ . '/../model/mongoservice.class.php';




class UcenikController
{
    function __construct() {
        $this->USERTYPE="ucenik";
    }

	private function checkPrivilege(){
		if (!isset($_SESSION["account_type"])){
			header( 'Location: index.php?rt=start/logout');
			exit();
		}
        if ( $_SESSION["account_type"] != $this->USERTYPE){
            header( 'Location: index.php?rt=start/logout');
			exit();
        }
	}


	public function index() {
		session_start();
        $this->checkPrivilege();
        $m= new MongoService();
        $activeInd=0;


        $ucenikName=$_SESSION["user_name"];
        $activeInd=0;
        $student=$m->returnUcenikWithId($_SESSION["user_id"]);
        $new_list=$m->getStudentsList($student);

        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';    

	}

    
	public function myInfo() {
		session_start();
        $this->checkPrivilege();

        $m= new MongoService();

        $user=$m->returnUcenikWithUsername($_SESSION["username"]);

        $natjecanja=$user->drzavna_natjecanja[0];

        $ocjene=$user->ocjene[0];
        

        $ucenikName=$_SESSION["user_name"];
        $activeInd=1;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/myInfo.php'; 

	}



    public function myListPushUp($index){
        session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        $lista= $student->lista_fakulteta_nova;


        $m->pushNewListToStudentWithId($_SESSION["user_id"],$lista,$index,"UP");

        //echo "<script>console.log(".$lista.");</script>";
        header( 'Location: index.php?rt=ucenik/myList');
		exit();
    }
    public function myListPushDown($index){
        session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        $lista= $student->lista_fakulteta_nova;

        $m->pushNewListToStudentWithId($_SESSION["user_id"],$lista,$index,"DOWN");

        header( 'Location: index.php?rt=ucenik/myList');
		exit();
    }

    public function myListInsert($faksOib){
        session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        $lista= $student->lista_fakulteta_nova;

        echo ($faksOib);
        echo gettype($faksOib);

        $m->pushNewListToStudentWithId($_SESSION["user_id"],$lista,-1,"INS",(string)$faksOib);

        header( 'Location: index.php?rt=ucenik/browser');
		exit();
    }

    public function myListDelete($index){
        session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        $lista= $student->lista_fakulteta_nova;

        $m->pushNewListToStudentWithId($_SESSION["user_id"],$lista,$index,"DEL");

        header( 'Location: index.php?rt=ucenik/myList');
		exit();
    }


    public function myList() {  //LISTA UCENIK -> FAKULTETI
		session_start();
        $this->checkPrivilege();
       
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);
        
        $new_list=$m->getStudentsList($student);

        $ucenikName=$_SESSION["user_name"];
        $activeInd=2;

        $USERTYPE=$this->USERTYPE;

        require_once __DIR__ . '/../view/'.$USERTYPE.'/myList.php';    

	}

    public function browser() { //LISTA FAKULTETA
		session_start();
        $this->checkPrivilege();
        
        $m= new MongoService();

        $list=$m->returnAllFaks();

        $user=$m->returnUcenikWithUsername($_SESSION["username"]);
        $listaFaksevaUcenika=$user->lista_fakulteta_nova;


        $ucenikName=$_SESSION["user_name"];
        $activeInd=3;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/browser.php';    

	}

    public function results() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       


        $ucenikName=$_SESSION["user_name"];
        $activeInd=4;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/results.php';    

	}

    public function otherSettings() {
		session_start();
        $this->checkPrivilege();
        $m= new MongoService();
        $ucenikName=$_SESSION["user_name"];
        $activeInd=5;
        
        $USERTYPE=$this->USERTYPE;

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        require_once __DIR__ . '/../view/'.$USERTYPE.'/otherSettings.php';   

	}

    public function otherSettingsCheck() {
		session_start();
        $this->checkPrivilege();
        $m= new MongoService();
        $ucenikName=$_SESSION["user_name"];
        $activeInd=5;
        
        $USERTYPE=$this->USERTYPE;

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);


        if($_POST["username"] != null)
            $m->changeUcenikWithId($_SESSION["user_id"],"username",$_POST["username"]);
        
        if($_POST["email"] != null)
            $m->changeUcenikWithId($_SESSION["user_id"],"email",$_POST["email"]);
        
        if($_POST["password"] != null)
            $m->changeUcenikWithId($_SESSION["user_id"],"password",$_POST["password"]);


        header( 'Location: index.php?rt=ucenik/otherSettings');
        exit(); 

	}


	public function add() { 
		session_start();
        $userName= $_SESSION["username"];
		$this->checkPrivilege();
        $title = 'Store - Add new product';
		$activeInd=6;

		require_once __DIR__ . '/../view/main_add.php';
		require_once __DIR__ . '/../view/_footer.php';
	}

	public function addComment(){
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
        $title = 'Store - Add new comment';

		$ps->addComment($_POST["product_id"],$_POST["rating"],$_POST["comment"]);

		header( 'Location: index.php?rt=main/history' );
    	exit();

	}

	public function addResult() { 
		session_start();

		$this->checkPrivilege();
		$ps=new ProductService();
		$us=new UserService();
        $userName= $_SESSION["username"];

		$user=$us->getUserFromUsername($userName);

		$ps->addProduct($user->user_id,$_POST["productName"],$_POST["description"],$_POST["price"]);

		header( 'Location: index.php?rt=main' );
    	exit();
	}

	public function history() {
		session_start();
        $userName= $_SESSION["username"];
		$this->checkPrivilege();
		$ps=new ProductService();
		$us=new UserService();
        $title = 'Store - '. $userName. "'s history";
		$activeInd=3;

		$myProductList = $ps->getTransactionsFromUsername($userName);
		$user = $us->getUserFromUsername($userName);

		require_once __DIR__ . '/../view/main_history.php';
		require_once __DIR__ . '/../view/_footer.php';
	}

    public function main() {
        session_start();
        $userName= $_SESSION["username"];
        $this->checkPrivilege();
        $ps=new ProductService();
        $title = 'Store - Main page';
        $activeInd=2;

        $myProductList = $ps->getTableFromSQL();

        require_once __DIR__ . '/../view/main_index.php';
        require_once __DIR__ . '/../view/_footer.php';
    }


};
?>