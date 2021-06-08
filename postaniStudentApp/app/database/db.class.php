<?php




class DB2
{

	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
	{
		if( DB2::$db === null ){
			try{
				//DB2::$db = new MongoDB\Driver\Manager("mongodb://localhost:27017");

				//MONGO ATLAS
				DB2::$db = new MongoDB\Driver\Manager("mongodb+srv://mongo_nbp:Lozinka1#@cluster0.03xeq.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
				
							
				
			}
			catch(MongoConnectionException $e){
				return $e;
			}


		}
		return DB2::$db;

	}
	   
}

?>
