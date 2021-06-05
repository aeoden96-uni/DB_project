<?php

require_once __DIR__ . '/../model/mongoservice.class.php';




class FaksController
{
    function __construct() {
        $this->USERTYPE="faks";
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
       
        $activeInd=0;

        $ucenikName=$_SESSION["username"];
       
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';   

	}

    public function myInfo() {
		session_start();
        $this->checkPrivilege();

        $m= new MongoService();

        $list=$m->returnUcenikWithId("60b6d0a2b000b1fc8a909a6f");

        $ucenikName=$_SESSION["username"];
        $activeInd=1;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/myInfo.php'; 

	}



    public function results() {
		session_start();
        $this->checkPrivilege();
        

        $ucenikName=$_SESSION["username"];
        $activeInd=4;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/results.php';    

	}
}


?>