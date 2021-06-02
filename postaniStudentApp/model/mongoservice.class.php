<?php
require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';

class MongoService
{

    function simple(){

        $db = DB2::getConnection(); 

        $query=new MongoDB\Driver\Query([]);

        return $db->executeQuery("mydb.users",$query); //VRACA SVE REZ iz mydb.users kolekcije

    }

    function simpleOne(){

        $db = DB2::getConnection(); 

        $query=new MongoDB\Driver\Query([]);

        return $db->executeQuery("mydb.users",$query); //VRACA SVE REZ iz mydb.users kolekcije

    }

    function simple2(){

        $db = DB2::getConnection(); 

        $filter  = [
            '$or' => [
                ['age' => ['$lte' => 19]],
                ['age' => ['$gte' => 50]]
            ]
        ];

        //https://www.php.net/manual/en/class.mongodb-driver-query.php
        $query = new MongoDB\Driver\Query($filter);

        //https://www.php.net/manual/en/mongodb-driver-manager.executequery.php
        return $db->executeQuery("mydb.users", $query);  //VRACA USERE s 'age' < 19 ili > 50

    }

    
}
?>