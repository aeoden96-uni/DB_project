<?php

require_once __DIR__ . '/../model/globalservice.class.php';

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


        $ime=$_SESSION["user_name"];
        $naziv=$ime;
        $activeInd=0;
        $student=$m->returnUcenikWithId($_SESSION["user_id"]);
        $new_list=$m->getStudentsList($student);

        ////////////////GLOBAL SETTINGS
        $g= new GlobalService();
    
        $lockDate= $g->getLockDate();
        $lockDateString=$lockDate->toDateTime()->format('d.m.Y');

        $resultDate= $g->getResultsDate();
        $resultDateString=$resultDate->toDateTime()->format('d.m.Y');

        $resultBool= $g->getResultsBool();
        $lockBool= $g->getLockBool();
        
        ////////////////GLOBAL SETTINGS


        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/index.php';    

	}

    
	public function myInfo() {
		session_start();
        $this->checkPrivilege();

        $m= new MongoService();

        //GLOBAL
        $g= new GlobalService();
        $lockBool= $g->getLockBool();
        $resultBool= $g->getResultsBool();
        ////////

        $user=$m->returnUcenikWithUsername($_SESSION["username"]);

        $natjecanja=$user->drzavna_natjecanja;

        $ocjene=$user->ocjene;

        
        

        $ime=$_SESSION["user_name"];
        $naziv=$ime;
        $activeInd=1;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/myInfo.php'; 

	}



    public function myListPushUp($index){
        session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        $lista= $student->lista_fakulteta;


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

        $lista= $student->lista_fakulteta;

        $m->pushNewListToStudentWithId($_SESSION["user_id"],$lista,$index,"DOWN");

        header( 'Location: index.php?rt=ucenik/myList');
		exit();
    }

    public function myListInsert($faksOib){
        session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        $lista= $student->lista_fakulteta;

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

        $lista= $student->lista_fakulteta;

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
        
        
        //GLOBAL
        $g= new GlobalService();
        $resultBool= $g->getResultsBool();
        $lockBool= $g->getLockBool();
        /////////////////////////


        $ime=$_SESSION["user_name"];
        $naziv=$ime;
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
        $listaFaksevaUcenika=$user->lista_fakulteta;


        //GLOBAL
        $g= new GlobalService();
        $lockBool= $g->getLockBool();
        $resultBool= $g->getResultsBool();
        ////////
        $ime=$_SESSION["user_name"];
        $naziv=$ime;
        $activeInd=3;
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/browser.php';    

	}

    public function results() {
		session_start();
        $this->checkPrivilege();
        $m= new MongoService();
        $student=$m->returnUcenikWithId($_SESSION["user_id"]);


		$g= new GlobalService();
        
		
		
        if(!$g->getResultsBool()){
            header( 'Location: index.php?rt=ucenik');
		    exit();
        }
        if($student->upisao == null){
            $upisao= false;

        }
        else{
            $upisao= true;
            $faks=$m->returnFaksWithOIB( $student->upisao);
        }

        
        
       

        //GLOBAL
        $g= new GlobalService();
        $resultBool = $g->getResultsBool();
        ////////
        $ime=$_SESSION["user_name"];
        $naziv=$ime;
        $activeInd=4;

        
        
        $USERTYPE=$this->USERTYPE;
        require_once __DIR__ . '/../view/'.$USERTYPE.'/results.php';    

	}

    public function otherSettings() {
		session_start();
        $this->checkPrivilege();
        $m= new MongoService();

        //GLOBAL
        $g= new GlobalService();
        $lockBool= $g->getLockBool();
        $resultBool= $g->getResultsBool();
        ////////

        $ime=$_SESSION["user_name"];
        $naziv=$ime;
        $activeInd=5;
        
        $USERTYPE=$this->USERTYPE;

        $student=$m->returnUcenikWithId($_SESSION["user_id"]);

        require_once __DIR__ . '/../view/'.$USERTYPE.'/otherSettings.php';   

	}

    public function otherSettingsCheck() {
		session_start();
        $this->checkPrivilege();
        $m= new MongoService();
        $ime=$_SESSION["user_name"];
        $naziv=$ime;
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



};
?>