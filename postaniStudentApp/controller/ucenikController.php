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
        $ps=new ProductService();
        $us=new UserService();
        $activeInd=0;


        $ucenikName="Mateo";
        $activeInd=0;

        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';    

	}

    
	public function myInfo() {
		session_start();
        $this->checkPrivilege();

        $m= new MongoService();

        $list=$m->returnUcenikWithId("60b6d0a2b000b1fc8a909a6f");


        $ucenikName="Mateo";
        $activeInd=1;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/myInfo.php'; 

	}

    public function myList() {  //LISTA UCENIK -> FAKULTETI
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       
        $m= new MongoService();

        $list=$m->returnUcenikWithId("60b6d0a2b000b1fc8a909a6f");

        $ucenikName="Mateo";
        $activeInd=2;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/myList.php';    

	}

    public function browser() { //LISTA FAKULTETA
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       
        $m= new MongoService();

        $list=$m->returnAllFaks("60b6c0a9347c4f9454712c79");

        //$result=$m->returnAllFaks();
        
        

        $ucenikName="Mateo";
        $activeInd=3;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/browser.php';    

	}

    public function results() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       


        $ucenikName="Mateo";
        $activeInd=4;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/results.php';    

	}

    public function otherSettings() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       


        $ucenikName="Mateo";
        $activeInd=5;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/otherSettings.php';   

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