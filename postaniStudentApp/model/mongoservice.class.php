<?php
require_once __DIR__ . '/../app/database/db.class.php';

class MongoService
{
    
    function returnAllFaks(){

        return  $this->queryAll("fakulteti");

    }

    function returnFaksWithId($id){

        return $this->queryOne( "fakulteti", "_id", $id);
    }

    function returnUcenikWithId($id){
        
        return $this->queryOne( "studenti", "_id", $id);

    }

    function returnUcenikWithUsername($username){
        
        return $this->queryOne( "studenti", "username", $username);

    }

    function queryOne($kolekcija, $atribut, $vrijednost){
        $db = DB2::getConnection(); 

        if ($atribut== "username")
            $vrijednost= (int)$vrijednost;

        //$id  = new \MongoDB\BSON\ObjectId($id); DODAJ OVO AKO ATLAS RADI SAM SVOJ ID
        $filter  = [ $atribut => $vrijednost];
        $options = [];


        //https://www.php.net/manual/en/class.mongodb-driver-query.php
        $query = new \MongoDB\Driver\Query($filter, $options);

        //https://www.php.net/manual/en/mongodb-driver-manager.executequery.php
        $result = $db->executeQuery("project.".$kolekcija,$query); //VRACA fakultete s istim ID OPET KAO LISTU objekata

        return $result->toArray()[0]; //Vraca samo prvi clan liste ,jer je cijela lista zapravo [ ucenik ]
            
    }

    function queryAll($kolekcija){
        $db = DB2::getConnection(); 

        $query=new MongoDB\Driver\Query([]);

        return $db->executeQuery("project.".$kolekcija,$query)->toArray(); //VRACA SVE fakultete KAO LISTU objekata
    }

    function pushNewListToStudentWithId($userId,$lista,$index,$action="UP",$newElement=null){
        $db = DB2::getConnection(); 
        echo $userId;

        switch($action){
            case "UP":
                $temp = $lista[$index-1];
                $lista[$index-1] = $lista[$index];
                $lista[$index] = (string)$temp;

                break;
            case "DOWN":
                $temp = $lista[$index+1];
                $lista[$index+1] = $lista[$index];
                $lista[$index] = (string)$temp;

                break;

            case "DEL":
                $lista=array_diff($lista, array((string)$lista[$index]));
                
                break;
            case "INS":
                array_splice( $lista, $index, 0, $newElement);
                
                break;
        }

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => $userId],
            ['$set' => ['lista_fakulteta_nova' => $lista  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.studenti",$bulk); 
                



    }


    
}
?>