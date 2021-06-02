<?php

require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '../../model/product.class.php'; 
require_once __DIR__ . '/../model/productservice.class.php';



class AdminController
{
	function __construct() {
        $this->USERTYPE="admin";
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


        $ucenikName="Admin Name";
        $activeInd=0;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';   

	}
}


?>