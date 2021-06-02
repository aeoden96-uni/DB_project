<?php

require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '/../model/productservice.class.php';
require_once __DIR__ . '../../model/product.class.php'; 


class GuestController
{
    private function checkPrivilege(){
		if (!isset($_SESSION["account_type"]) || $_SESSION["account_type"]=="user"){
			header( 'Location: index.php?rt=start/logout');
			exit();
		}
	}

	public function index() 
	{
		session_start();

        $this->checkPrivilege();

		$ps=new ProductService();

		$title = 'Community Store - Welcome';
		$activeInd=0;
		$userName= "UNDEFINED";
		$title="SHOP"; 
		$myProductList = [];
		$myProductList = $ps->getTableFromSQL();

		//ZAMIJENITI S MAIN_INDEX KASNIJE
		
		require_once __DIR__ . '/../view/guest_index.php';
		require_once __DIR__ . '/../view/_footer.php';
	}

	public function sellerPage() 
	{
		session_start();

        $this->checkPrivilege();

		$ps=new ProductService();

		$title = 'Community Store - Welcome';
		$activeInd=0;
		$userName= "UNDEFINED";
		$title="SHOP"; 
		$myProductList = [];
		$myProductList = $ps->getTableFromSQL();

		//ZAMIJENITI S MAIN_INDEX KASNIJE
		
		require_once __DIR__ . '/../view/guest_index.php';
		require_once __DIR__ . '/../view/_footer.php';
	}

	
}; 

?>