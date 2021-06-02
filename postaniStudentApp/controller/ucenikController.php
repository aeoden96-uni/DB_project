<?php

require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '../../model/product.class.php'; 
require_once __DIR__ . '/../model/productservice.class.php';
require_once __DIR__ . '/../model/mongoservice.class.php';




class UcenikController
{
	private function checkPrivilege(){
		if (!isset($_SESSION["account_type"]) || $_SESSION["account_type"]=="guest"){
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
        
        require_once __DIR__ . '/../view/ucenik_index.php';    

	}

    
	public function myInfo() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();



        $ucenikName="Mateo";
        $activeInd=1;
        
        require_once __DIR__ . '/../view/ucenik_myInfo.php';    

	}

    public function myList() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       


        $ucenikName="Mateo";
        $activeInd=2;
        
        require_once __DIR__ . '/../view/ucenik_myList.php';    

	}

    public function browser() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       
        $m= new MongoService();

        $result=$m->simple2();

        if(!$result){
            $result="FFFF";
        }

        $ucenikName="Mateo";
        $activeInd=3;
        
        require_once __DIR__ . '/../view/ucenik_browser.php';    

	}

    public function results() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       


        $ucenikName="Mateo";
        $activeInd=4;
        
        require_once __DIR__ . '/../view/ucenik_results.php';    

	}

    public function otherSettings() {
		session_start();
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
       


        $ucenikName="Mateo";
        $activeInd=5;
        
        require_once __DIR__ . '/../view/ucenik_otherSettings.php';    

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