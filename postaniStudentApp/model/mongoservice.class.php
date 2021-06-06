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
        
        //echo $userId;
        //var_dump($lista);

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
                unset($lista[$index]);
                $lista = array_values($lista);
                
                
                break;
            case "INS":
                array_splice( $lista, $index, 0, $newElement);
                
                break;
        }
        

        //var_dump($lista);
        //var_dump($lista);

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => $userId],
            ['$set' => ['lista_fakulteta_nova' => $lista  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.studenti",$bulk); 
                

    }

    public function getStudentsList($student){
        //vraca listu objekata fakulteti s OIBovima koji pisu u ucenikovoj listi izbora
        //NE VRACA ISTIM REDOSLIJEDOM
        $db = DB2::getConnection(); 



        $command = new MongoDB\Driver\Command([
            'aggregate' => 'studenti',
            'pipeline' => [
                ['$match' => ['_id' => '60b9f9d265b6b6dbd1ea3a48']],
                ['$unwind' => ['path' => '$lista_fakulteta_nova','includeArrayIndex' => 'redniBroj']],

                ['$lookup' => ['from' => 'fakulteti','localField' => 'lista_fakulteta_nova','foreignField'=> 'oib', 'as'=> 'fakultetInfo']],
                ['$sort' => ['redniBroj'=> 1]],
                ['$group' => ['_id' => '60b9f9d265b6b6dbd1ea3a48', 'fieldN' => [ '$push' => '$fakultetInfo'  ]]]

            ],
            'cursor' => new stdClass,
        ]);

        $result=$db->executeCommand('project', $command)->toArray();

        if ($result==null) return null;

        return  $result[0]->fieldN;
        


/*[{$match: {
  _id:"60b9f9d265b6b6dbd1ea3a48"
}}, {$unwind: {
  path: "$lista_fakulteta_nova",
  includeArrayIndex: 'redniBroj'
}}, {$lookup: {
  from: 'fakulteti',
  localField: 'lista_fakulteta_nova',
  foreignField: 'oib',
  as: 'fakultetInfo'
}}, {$sort: {
  "redniBroj": 1
}}, {$group: {
  _id: "60b9f9d265b6b6dbd1ea3a48",
  fieldN: {
    $push: {faks:"$fakultetInfo"}
  }
}}] */


    }



}
?>