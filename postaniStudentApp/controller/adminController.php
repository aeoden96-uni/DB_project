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

        $ucenikName=$_SESSION["username"];
        $activeInd=0;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';   

	}

    
	public function start() {
		session_start();
        $this->checkPrivilege();
        
        $ucenikName=$_SESSION["username"];
        $USERTYPE=$this->USERTYPE;

        echo "you initiated aggregation procedure.";
        //require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';   

	}
	public function reset() {
		session_start();
        $this->checkPrivilege();
        
        $ucenikName=$_SESSION["username"];
        $USERTYPE=$this->USERTYPE;

        echo "you initiated aggregation RESET procedure.";
        //require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';   

	}


}


?>