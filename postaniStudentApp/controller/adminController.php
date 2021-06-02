<?php

require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '../../model/product.class.php'; 
require_once __DIR__ . '/../model/productservice.class.php';



class AdminController
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


        $ucenikName="FakultetName";
        $activeInd=0;
        
        require_once __DIR__ . '/../view/admin_index.php';    

	}
}


?>