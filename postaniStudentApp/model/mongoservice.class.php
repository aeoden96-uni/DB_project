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
        
        return $this->queryOne( "novi_studenti", "_id", $id);

    }

    function returnUcenikWithUsername($username){
        
        return $this->queryOne( "novi_studenti", "username", $username);

    }

    function returnFaksWithUsername($username){
        
        return $this->queryOne( "fakulteti", "admin_username", $username);

    }

    function queryOne($kolekcija, $atribut, $vrijednost){
        $db = DB2::getConnection(); 

        

        //$id  = new \MongoDB\BSON\ObjectId($id); DODAJ OVO AKO ATLAS RADI SAM SVOJ ID
        $filter  = [ $atribut => $vrijednost];
        $options = [];


        //https://www.php.net/manual/en/class.mongodb-driver-query.php
        $query = new \MongoDB\Driver\Query($filter, $options);

        //https://www.php.net/manual/en/mongodb-driver-manager.executequery.php
        $result = $db->executeQuery("project.".$kolekcija,$query); //VRACA fakultete s istim ID OPET KAO LISTU objekata

        

        return $result->toArray()[0]; //Vraca samo prvi clan liste ,jer je cijela lista zapravo [ ucenik ]
            
    }

    function changeUcenikWithId($userId,$atribut, $vrijednost){
        $db = DB2::getConnection(); 
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => $userId],
            ['$set' => [$atribut => $vrijednost  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.novi_studenti",$bulk); 
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
        



        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => $userId],
            ['$set' => ['lista_fakulteta' => $lista  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.novi_studenti",$bulk); 
                

    }

    public function getStudentsList($student){
        //vraca listu objekata fakulteti s OIBovima koji pisu u ucenikovoj listi izbora
        //NE VRACA ISTIM REDOSLIJEDOM
        $db = DB2::getConnection(); 

        


        $command = new MongoDB\Driver\Command([
            'aggregate' => 'novi_studenti',
            'pipeline' => [
                ['$match' => ['_id' => $student->_id]],
                ['$unwind' => ['path' => '$lista_fakulteta','includeArrayIndex' => 'redniBroj']],

                ['$lookup' => ['from' => 'fakulteti','localField' => 'lista_fakulteta','foreignField'=> 'oib', 'as'=> 'fakultetInfo']],
                ['$sort' => ['redniBroj'=> 1]],
                ['$group' => ['_id' => $student->_id, 'fieldN' => [ '$push' => '$fakultetInfo'  ]]]

            ],
            'cursor' => new stdClass,
        ]);

        $result=$db->executeCommand('project', $command)->toArray();

        if ($result==null) return null;

        return  $result[0]->fieldN;
        




    }

    public function startAggreagtion(){
        echo "you initiated aggregation procedure.";


        $db = DB2::getConnection(); 



        $command = new MongoDB\Driver\Command([
            'aggregate' => 'fakultet',
            'pipeline' => [
                /**{$match: {  "oibf": "1f" }}, */
                ['$match' => ['oibf' => '1f']],

                /**{$lookup: { from: "student",
                    localField:  "oibf",  	
                    foreignField:"izbori", 
                    as: "lista" }}, 
             */
                ['$lookup' => ['from' => 'student','localField' => 'oibf','foreignField'=> 'izbori', 'as'=> 'lista']],   
                
                /**{$unwind: {
			path: "$lista"}},  */

                ['$unwind' => ['path' => '$lista']],

                ['$unwind' => ['path' => '$uvjeti']],

                
                ['$project' => ['_id' => '$lista.oib', 
                            'zbrojG' => [ '$sum' => [
                                [ '$multiply' =>  [['$toInt' => '$lista.ocjene.m'], ['$toInt' => '$uvjeti.m']] ],
                                [ '$multiply' =>  [['$toInt' => '$lista.ocjene.h'], ['$toInt' => '$uvjeti.h']] ],
                                ['$multiply' =>  [['$toInt' => '$lista.ocjene.e'],['$toInt' => '$uvjeti.e']] ]
                                ]  ],
                                
                            'zbrojN' =>  ['$cond' => [
                                           'if' => [ 
                                                '$and' => [
                                                    '$eq' => ['$lista.natjecanje.naziv', '$uvjeti.natjecanje'],
                                                    '$eq' => ['$lista.natjecanje.mjesto', '1']

                                                ]

                                            ],
                                            'then'=> 1000,

                                            'else' => [
                                                    '$cond' => [
                                                        'if' => [ '$eq' => ['$lista.natjecanje.naziv', '$uvjeti.natjecanje'] ],
                                                        'then'=>10,
                                                        'else'=>0  ]
                                            ]
                                       ]
                            
                            
                            ],
                            
                            'zbrojI'  =>  [

                                '$cond' =>  ['if' =>  [ '$eq' =>  ['$lista.ocjene.izborni', '$uvjeti.izborni']] ,
                                     'then' =>  [ '$multiply' =>  [['$toInt' => '$lista.ocjene.izb_oc'], 6]],
                                     'else' =>  0
                 
                                       ]
                                 ]	,   
                             'izbor' => ['$indexOfArray' =>  [ '$lista.izbori', '$oibf' ] ]



                            
                            
                            ]],
        ['$set' =>  [
            'zbroj' =>  [
                '$sum' =>  ['$zbrojG','$zbrojN','$zbrojI']
            ]
            
            ]], 
            
            ['$sort' =>  [
            'zbroj' =>  -1
            ]]

            ],
            'cursor' => new stdClass,
        ]);

        $result=$db->executeCommand('vjezba', $command)->toArray();


        var_dump($result);

    }

    public function resetAggreagtion(){
        echo "you initiated aggregation RESET procedure.";
    }

}


?>