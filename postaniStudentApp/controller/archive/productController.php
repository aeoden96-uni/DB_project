<?php

require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '../../model/product.class.php';
require_once __DIR__ . '../../model/transaction.class.php';
require_once __DIR__ . '/../model/productservice.class.php';



class ProductController
{
    private function checkPrivilege()
    {
        if (!isset($_SESSION["account_type"]) || $_SESSION["account_type"] == "guest") {
            header('Location: index.php?rt=start/logout');
            exit();
        }
    }

    public function index($id=null) {
        session_start();
        $userName= $_SESSION["username"];
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();
        
        $activeInd=4;


        if($id != null){
            $myProductList = $ps->getTransactionsFromProductId($id);

            $myProduct=$ps->getProductFromId($id);



            $title = 'Store - Product page: ' . $myProduct->name;

            require_once __DIR__ . '/../view/product_comments.php';
        }
        else{

            $title = 'Store - Search';
            require_once __DIR__ . '/../view/main_search.php';

        }
        require_once __DIR__ . '/../view/_footer.php';
    }

    public function searchResult() { 
        session_start();
        $activeInd=4;
        $userName= $_SESSION["username"];
        $this->checkPrivilege();
        $ps=new ProductService();
        $us=new UserService();

        $result=NULL;
        switch($_POST["searchType"]){
            case "user_id":
                $result=$us->checkId($_POST["searchTerm"]);
                if($result){
                    header( 'Location: index.php?rt=main/' . $_POST["searchTerm"] );
                    exit();
                }
                break;

            case "user_nm":
                $result=$us->checkUsername($_POST["searchTerm"]);
                if($result){
                    header( 'Location: index.php?rt=main/' . $us->getUserFromUsername($_POST["searchTerm"])->user_id );
                    exit();
                }
                else{
                    header( 'Location: index.php?rt=main');
                    exit();
                }
                break;

            case "prod_id":
                header( 'Location: index.php?rt=product/' . $_POST["searchTerm"] );
                exit();
                

            case "prod_nm":
                $result=$ps->getTableFromProductName($_POST["searchTerm"]);

                break;
        }

        $userName= $_SESSION["username"];
        $title = $userName . "'s available products";
        $myProductList =  $result;

        

		require_once __DIR__ . '/../view/main_index.php';
		require_once __DIR__ . '/../view/_footer.php';


    }

}
?>
