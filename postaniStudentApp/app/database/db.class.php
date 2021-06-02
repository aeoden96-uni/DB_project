<?php

// Datoteku treba preimenovati u db.class.php

class DB
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
	{
		if( DB::$db === null )
	    {
	    	try
	    	{
	    		// Unesi ispravni HOSTNAME, DATABASE, USERNAME i PASSWORD
		    	DB::$db = new PDO( "mysql: host=localhost; dbname=dz2; charset=utf8", 'root' );
				
		    	DB::$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		    catch( PDOException $e ) { exit( 'PDO Error: ' . $e->getMessage() ); }
	    }
		return DB::$db;
	}
}

class DB2
{

	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
	{
		if( DB2::$db === null ){
			try{
				DB2::$db = new MongoDB\Driver\Manager("mongodb://localhost:27017");

				//MONGO ATLAS
				/*$manager= new MongoDB\Driver\Manager("mongodb+srv://temp_user:test123@cluster0.zbco3.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
				}*/
				
			}
			catch(MongoConnectionException $e){
				return $e;
			}


		}
		return DB2::$db;

	}
	   
}

?>
