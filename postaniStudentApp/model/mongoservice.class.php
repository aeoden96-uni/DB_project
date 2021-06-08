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

    function returnAdminWithUsername($username){
        
        return $this->queryOne( "admini", "admin_username", $username);

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

    public function agg2(){
        echo "you initiated aggregation procedure.";


        $db = DB2::getConnection(); 



        $command = new MongoDB\Driver\Command([
            'aggregate' => 'fakultet',
            'pipeline' => [
            
            
            ['$lookup' =>  [

            'from' =>  'student',
           'localField' =>  'oibf',
           'foreignField' =>  'izbori',
           'as' =>  'lista'
         ]], ['$unwind' =>  [
           'path' =>  '$lista'
         ]], ['$unwind' =>  [
         'path' =>  '$uvjeti'
         ]], ['$project' =>  [
         
             'oib' =>  '$lista.oib',
           'fakultet' =>  '$oibf',
           'zbrojG' =>  [
             '$sum' =>  [
               [
                 '$multiply' =>  [
                   [
                     '$toInt' =>  '$lista.ocjene.m'
                   ],
                   [
                     '$toInt' =>  '$uvjeti.m'
                   ]
                 ]
               ],
               [
                 '$multiply' =>  [
                   [
                     '$toInt' =>  '$lista.ocjene.h'
                   ],
                   [
                     '$toInt' =>  '$uvjeti.h'
                   ]
                 ]
               ],
               [
                 '$multiply' =>  [
                   [
                     '$toInt' =>  '$lista.ocjene.e'
                   ],
                   [
                     '$toInt' =>  '$uvjeti.e'
                   ]
                 ]
               ]
             ]
           ],
           'zbrojN' =>  [
             '$cond' =>  [
               'if' =>  [
                 '$and' =>  [
                   [
                     '$eq' =>  [
                       '$lista.natjecanje.naziv',
                       '$uvjeti.natjecanje'
                     ]
                   ],
                   [
                     '$eq' =>  [
                       '$lista.natjecanje.mjesto',
                       '1'
                     ]
                   ]
                 ]
               ],
               'then' =>  1000,
               'else' =>  [
                 '$cond' =>  [
                   'if' =>  [
                     '$eq' =>  [
                       '$lista.natjecanje.naziv',
                       '$uvjeti.natjecanje'
                     ]
                   ],
                   'then' =>  10,
                   'else' =>  0
                 ]
               ]
             ]
           ],
           'zbrojI' =>  [
             '$cond' =>  [
               'if' =>  [
                 '$eq' =>  [
                   '$lista.ocjene.izborni',
                   '$uvjeti.izborni'
                 ]
               ],
               'then' =>  [
                 '$multiply' =>  [
                   [
                     '$toInt' =>  '$lista.ocjene.izb_oc'
                   ],
                   6
                 ]
               ],
               'else' =>  0
             ]
           ],
           'izbor' =>  [
             '$indexOfArray' =>  [
               '$lista.izbori',
               '$oibf'
             ]
           ],
           'upisao' =>  "0",
           '_id' =>  0
         ]], ['$set' =>  [
           'zbroj' =>  [
             '$sum' =>  [
               '$zbrojG',
               '$zbrojN',
               '$zbrojI'
             ]
         ]
         ]], ['$sort' =>  [
           'zbroj' =>  -1
         ]]],
         'cursor' => new stdClass
         
         ]);

        $result=$db->executeCommand('vjezba', $command)->toArray();


        var_dump($result);

    }

    public function dataS(){
      $studenti= array();

        $student = new stdClass();
        $student->ime="A";
        $student->lista= array("F1","F2","F3");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="B";
        $student->lista= array("F3","F2","F1");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="C";
        $student->lista= array("F1","F2","F3");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="D";
        $student->lista= array("F2","F3","F1");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="E";
        $student->lista= array("F3","F2","F1");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="F";
        $student->lista= array("F2","F3","F1");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="G";
        $student->lista= array("F3","F2","F1");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="H";
        $student->lista= array("F2","F1","F3");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="I";
        $student->lista= array("F1","F3","F2");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="J";
        $student->lista= array("F2","F3","F1");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        $student = new stdClass();
        $student->ime="K";
        $student->lista= array("F1","F2","F3");
        $student->accepted= array(0,0,0);
        $studenti[]=$student;

        return $studenti;
    }

    public function dataF(){
        $faksevi= array();

        $faks = new stdClass();
        $faks->ime="F1";
        $faks->id="F1";
        $faks->bodovna_lista= array("A", "C", "B","K","E","J","I", "D","F","G","H");
        $faks->upisni_list=array();
        $faks->q=3;
        $faksevi[]= $faks;

        $faks = new stdClass();
        $faks->ime="F2";
        $faks->id="F2";
        $faks->bodovna_lista= array("D", "A", "B","K","C","I", "E","F","J","G","H");
        $faks->upisni_list=array();
        $faks->q=3;
        $faksevi[]= $faks;

        $faks = new stdClass();
        $faks->ime="F3";
        $faks->id="F3";
        $faks->bodovna_lista= array("F", "C", "A","B", "D","H","G","E","I","J","K");
        $faks->upisni_list=array();

        $faks->q=3;

        $faksevi[]= $faks;

        return $faksevi;
    }

    public function run($faksevi,$studenti){
        echo "you initiated aggregation RESET procedure.";



        $c=1;
        while($c && count($studenti)>0){

            $studenti=array_values($studenti);
            $faksevi=array_values($faksevi);

            foreach($faksevi as $f){
                $f->bodovna_lista=array_values($f->bodovna_lista);
            }
            //init indexa gotov
                      


            foreach($faksevi as $faks){
                foreach($studenti as $s){
                    
                    $index=array_search($s->ime, $faks->bodovna_lista);

                    //if($s->ime=='H'){echo "<br>H index=". $index. " faks=" . $faks->ime. " Q=" . $faks->q. "<br>";}

                    if( $index < $faks->q){
                        $indexodUcenika=array_search($faks->id, $s->lista);
                    
                        $s->accepted[$indexodUcenika]=1;
                    }
                }
            }

            //var_dump($faksevi);
            //var_dump($studenti);
            



            foreach($studenti as $key => $student){

                $upisao=array_search(1, $student->accepted);
                if($upisao>=0 && false !==$upisao){           //AKO JE taj  accepted na faks s indexom 'upisao' 
                                                              //upisao == INDEX oiba faksa u ucenikovom popisu

                    
                    
                    foreach($faksevi as $key4 => $faks){
                        //var_dump($student->lista);
                        //var_dump($student->accepted);
                        
                        if ($faks->id == $student->lista[$upisao]){
                            $id_faksa=$key4;
                            break;

                        }
                    }

                    
                    $faksevi[$id_faksa]->upisni_list[]=$student->ime;
                    $faksevi[$id_faksa]->q--;

                    foreach($faksevi as $f){ //delete all ocurances of this student
                        if (($key2 = array_search($student->ime, $f->bodovna_lista)) !== false) {
                            unset($f->bodovna_lista[$key2]);
                        }
                    }

                    unset($studenti[$key]);
                }
            }

            var_dump("NAKON ". (2-$c+1). " ITERACIJE" );
            //var_dump($studenti);
            //var_dump($faksevi);

            $all_zero=true;  
            foreach($faksevi as $f){
              
              if($f->q > 0)
                $all_zero=false;
              

            }
            if($all_zero) break;


 
            $c--;
        }
        var_dump($studenti);
        var_dump($faksevi);
    
    }

    public function resetAggreagtion(){

      //var_dump($this->dataF()[0]);
      //$this->run($this->dataF(),$this->dataS());

      $faksevi=$this->queryAll("lista");

      foreach($faksevi as $f){
        $f->upisni_list=array();
        $f->bodovna_lista=$f->oibovi;
        unset($f->oibovi);
        unset($f->lista_bodova);
        $f->id= $f->_id;
        $f->ime= $f->_id;
        unset($f->_id);
        unset($f->izbor);
        $f->q= 30;


      }

      $studenti=$this->queryAll("studenti");

      foreach($studenti as $key => $s){

        if(count($s->lista_fakulteta)==0 ){
          unset($studenti[$key]);
          continue;
        }



          unset($s->datum_rodenja);
          unset($s->prezime);
          unset($s->ocjene);
          unset($s->email);
          unset($s->ime);
          unset($s->_id);
          unset($s->email);
          unset($s->password);
          unset($s->drzavna_natjecanja);
          
          if(!isset($s->lista_fakulteta)){
            print_r("<br>");
            print_r($s->username . "<br>");
          }
          $s->accepted= array_fill(0,count($s->lista_fakulteta),0);
          $s->lista=$s->lista_fakulteta;
          unset($s->lista_fakulteta);

          $s->ime=$s->username;
          unset($s->username);

          

      }

      //var_dump($faksevi[0]);
      //var_dump($studenti[0]);
      $this->run($faksevi,$studenti);
    }





}


?>