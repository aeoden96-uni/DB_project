<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/product.class.php';
require_once __DIR__ . '/transaction.class.php';

class ProductService
{
	protected $myTable;

	function getTableFromSQL(){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT products.id,
                                        products.id_user,
                                        products.name,
                                        products.description,
                                        products.price,
                                        transactions.id_product,
                                        AVG(transactions.rating) as avg,
                                        COUNT(products.id) as sold
                                        FROM products
                                LEFT JOIN    transactions
                                ON transactions.id_product=products.id
                                GROUP BY transactions.id_product');
			$st->execute();


		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$this->myTable = [];	

		while( $row = $st->fetch() )
		{
			$this->myTable[]=new Product( $row["id"],$row["id_user"],$row["name"],$row["description"],$row["price"],$row["sold"],$row["avg"]);
		}

		return $this->myTable;
	}

    public function getTableFromUsername($userName){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT products.id,
                                        products.id_user,
                                        products.name,
                                        products.description,
                                        products.price,
                                        transactions.id_product,
                                        AVG(transactions.rating) as avg,
                                        COUNT(products.id) as sold
                                        FROM products
                                LEFT JOIN    transactions
                                ON transactions.id_product=products.id
                                LEFT JOIN  
								users ON
                                 (users.id=products.id_user AND users.username=:username)
                                GROUP BY transactions.id_product');
            $st->execute( array( 'username' => $userName) );

        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $this->myTable = [];

        while( $row = $st->fetch() )
        {
            $this->myTable[]=new Product( $row["id"],$row["id_user"],$row["name"],$row["description"],$row["price"],$row["sold"],$row["avg"]);

        }

        return $this->myTable;
    }

    public function getTableFromId($id){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT products.id,
                                        products.id_user,
                                        products.name,
                                        products.description,
                                        products.price,
                                        transactions.id_product,
                                        AVG(transactions.rating) as avg,
                                        COUNT(products.id) as sold
                                FROM    transactions,products,users
                                WHERE transactions.id_product=products.id AND products.id_user=users.id AND users.id=:id
                                GROUP BY transactions.id_product');
            $st->execute( array( 'id' => $id) );

        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $this->myTable = [];

        while( $row = $st->fetch() )
        {
            $this->myTable[]=new Product( $row["id"],$row["id_user"],$row["name"],$row["description"],$row["price"],$row["sold"],$row["avg"]);

        }

        return $this->myTable;
    }

    public function getProductFromId($id){
        return $this->queryOne("id",$id);

    }

    public function queryOne($rowName,$rowData){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT *
                                    FROM products 
                                    WHERE '. $rowName . '=:data');
            $st->execute( array( 'data' => $rowData) );

        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $row = $st->fetch();

        $p=new Product( $row["id"],$row["id_user"],$row["name"],$row["description"],$row["price"],NULL,NULL);

        return $p;
    }

    public function getTableFromProductName($name){
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT products.id,
                                        products.id_user,
                                        products.name,
                                        products.description,
                                        products.price,
                                        transactions.id_product,
                                        AVG(transactions.rating) as avg,
                                        COUNT(products.id) as sold
                                FROM    transactions,products
                                WHERE transactions.id_product=products.id AND products.name LIKE "%'.$name.'%" 
                                GROUP BY transactions.id_product');
			$st->execute();


		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$this->myTable = [];	

		while( $row = $st->fetch() )
		{
			$this->myTable[]=new Product( $row["id"],$row["id_user"],$row["name"],$row["description"],$row["price"],$row["sold"],$row["avg"]);
		}

		return $this->myTable;
    }


    public function getTransactionsFromProductId($id){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM transactions WHERE transactions.id_product=:id');
            $st->execute( array( 'id' => $id) );

        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $this->myTable = [];

        while( $row = $st->fetch() )
        {
            $this->myTable[]=new Transaction( $row["id"], $row["id_product"], $row["id_user"],$row["rating"],$row["comment"]);


        }

        return $this->myTable;
    }

    public function addComment($product_id,$rating,$comment){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'UPDATE transactions
                                SET  rating=:rating, comment =:comment 
                                WHERE id_product=:id_product');
            $st->execute( array( 'rating' => $rating ,'comment' => $comment ,'id_product' => $product_id  ) );

        }
        catch( PDOException $e ) { return  'PDO error ' . $e->getMessage(); }
    }

    public function addProduct($user_id,$product_name,$description,$price){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'INSERT INTO products (id_user, name, description, price)
                                VALUES (:id_user, :name, :description, :price)');
            $st->execute( array( 'id_user' => $user_id ,'name' => $product_name ,'description' => $description,'price' => $price   ) );

        }
        catch( PDOException $e ) { echo  'PDO error ' . $e->getMessage(); }
    }

    public function getTransactionsFromUsername($username){
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT T1.id,T1.id_product,T1.id_user,T1.rating,T1.comment 
                                FROM transactions T1,users 
                                WHERE users.id=T1.id_user 
                                  AND users.username=:username');
            $st->execute( array( 'username' => $username) );

        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $this->myTable = [];

        while( $row = $st->fetch() )
        {
            $this->myTable[]=new Transaction( $row["id"], $row["id_product"], $row["id_user"],$row["rating"],$row["comment"]);
        }

        return $this->myTable;
    }


};