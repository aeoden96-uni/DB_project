<?php

require_once __DIR__ . '/../model/globalservice.class.php';
require_once __DIR__ . '/../model/mongoservice.class.php';



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


        $g= new GlobalService();
    
        $lockDate= $g->getLockDate();
        $lockDateString=$lockDate->toDateTime()->format('d.m.Y');

        $resultDate= $g->getResultsDate();
        $resultDateString=$resultDate->toDateTime()->format('d.m.Y');

        $resultBool= $g->getResultsBool();
        $lockBool= $g->getLockBool();
        $agregBool=$g->getAgregBool();

        
        $ime=$_SESSION["username"];
        $naziv=$ime;

        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';   

	}

    function lockSwitch(){
        session_start();
        $this->checkPrivilege();
        $g= new GlobalService();
        $g->switchLockBool(!$g->getLockBool());
        header( 'Location: index.php?rt=admin');
		exit();
   
    }

    function resultsSwitch(){
        session_start();
        $this->checkPrivilege();
        $g= new GlobalService();

        $g->switchResultsBool(!$g->getResultsBool());

        header( 'Location: index.php?rt=admin');
		exit();
   
    }

    
	public function start() {
		session_start();
        $this->checkPrivilege();
        
        $ucenikName=$_SESSION["username"];
        $USERTYPE=$this->USERTYPE;
        $g= new GlobalService();
        $m= new MongoService();

        //$m->startAggreagtion();

        $g->switchAgregBool(true);

        header( 'Location: index.php?rt=admin');
		exit();  

	}
	public function reset() {
		session_start();
        $this->checkPrivilege();
        
        $ucenikName=$_SESSION["username"];
        $USERTYPE=$this->USERTYPE;
        $g= new GlobalService();
        $m= new MongoService();

        //$m->resetAggreagtion();

        $g->switchAgregBool(false);

        header( 'Location: index.php?rt=admin');
		exit();

	}


}


?>