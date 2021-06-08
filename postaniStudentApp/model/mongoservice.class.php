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
    function returnFaksWithOIB($oib){

      return $this->queryOne( "fakulteti", "oib", $oib);
    }
    function returnUcenikWithId($id){
        
        return $this->queryOne( "studenti", "_id", $id);

    }
    function returnUcenikWithUsername($username){
        
        return $this->queryOne( "studenti", "username", $username);

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
    function queryAll($kolekcija){
        $db = DB2::getConnection(); 

        $query=new MongoDB\Driver\Query([]);

        return $db->executeQuery("project.".$kolekcija,$query)->toArray(); //VRACA SVE fakultete KAO LISTU objekata
    }
    public function getStudentsList($student){
      //vraca listu objekata fakulteti s OIBovima koji pisu u ucenikovoj listi izbora
      //NE VRACA ISTIM REDOSLIJEDOM
      $db = DB2::getConnection(); 

      


      $command = new MongoDB\Driver\Command([
          'aggregate' => 'studenti',
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
    public function getEnrolledStudentsForOIB($oib){
      $db = DB2::getConnection(); 

      


      $command = new MongoDB\Driver\Command([
          'aggregate' => 'lista',
          'pipeline' => [
            [ '$match' => [ '_id'=> $oib] ],
            ['$lookup' =>  [
            'from' =>  'studenti',
            'localField' =>  'upisni_list',
            'foreignField' =>  'username',
            'as' =>  'enrolled_students'
          ]], ['$project' =>  [
          
              'enrolled_students' => 1
          ]]],
          'cursor' => new stdClass,
      ]);

      $result=$db->executeCommand('project', $command)->toArray();

      if ($result==null) return null;

      return  $result[0]->enrolled_students;
    }
    function changeUcenikWithId($userId,$atribut, $vrijednost){
        $db = DB2::getConnection(); 
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => $userId],
            ['$set' => [$atribut => $vrijednost  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.studenti",$bulk); 
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

        $result = $db->executeBulkWrite("project.studenti",$bulk); 
                

    }
    public function startAggreagtion(){
      echo "You initiated aggregation procedure.";

      $this->stvoriTablicuLista();

      $faksevi=$this->queryAll("lista");
      $faksevi=$this->urediFakseve($faksevi);

      $studenti=$this->queryAll("studenti");
      $studenti=$this->urediStudente($studenti);

      $this->run($faksevi,$studenti);
      $this->saveResultsAllFaks();
      

    }
    public function stvoriTablicuLista(){
      $db = DB2::getConnection(); 

          


      $command = new MongoDB\Driver\Command([
          'aggregate' => 'fakulteti',

          'pipeline' => 

            [
              
              
            ['$lookup' =>  [
              'from' =>  'studenti',
              'localField' =>  'oib',
              'foreignField' =>  'lista_fakulteta',
              'as' =>  'lista'
            ]], 
            
            
            ['$unwind' =>  [
              'path' =>  '$lista'
            ]], 
            
            ['$unwind' =>  [
              'path' =>  '$uvjeti'
            ]], 
            
            
            ['$project' =>  [
              'oib' =>  '$lista.username',
              'fakultet' =>  '$oib',
              'zbrojG' =>  [
                '$sum' =>  [
                  [
                    '$multiply' =>  [
                      [
                        '$toDouble' =>  '$lista.ocjene.matematika'
                      ],
                      [
                        '$toDouble' =>  '$uvjeti.matematika'
                      ]
                    ]
                  ],
                  [
                    '$multiply' =>  [
                      [
                        '$toDouble' =>  '$lista.ocjene.hrvatski'
                      ],
                      [
                        '$toDouble' =>  '$uvjeti.hrvatski'
                      ]
                    ]
                  ],
                  [
                    '$multiply' =>  [
                      [
                        '$toDouble' =>  '$lista.ocjene.engleski'
                      ],
                      [
                        '$toDouble' =>  '$uvjeti.engleski'
                      ]
                    ]
                  ],
                  [
                    '$multiply' =>  [
                      [
                        '$toDouble' =>  '$lista.ocjene.prosjek'
                      ],
                      [
                        '$toDouble' =>  2
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
                          '$lista.drzavna_natjecanja.naziv',
                          '$uvjeti.natjecanje'
                        ]
                      ],
                      [
                        '$eq' =>  [
                          '$lista.drzavna_natjecanja.mjesto',
                          1
                        ]
                      ]
                    ]
                  ],
                  'then' =>  1000,
                  'else' =>  [
                    '$cond' =>  [
                      'if' =>  [
                        '$eq' =>  [
                          '$lista.drzavna_natjecanja.naziv',
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
                      '$lista.ocjene.izborni.naziv',
                      '$uvjeti.izborni'
                    ]
                  ],
                  'then' =>  [
                    '$multiply' =>  [
                      [
                        '$toDouble' =>  '$lista.ocjene.izborni.ocjena'
                      ],
                      6
                    ]
                  ],
                  'else' =>  0
                ]
              ],
              'izbor' =>  [
                '$indexOfArray' =>  [
                  '$lista.lista_fakulteta',
                  '$oib'
                ]
              ],
              'upisao' =>  '0',
              '_id' =>  0,
              'kvota' =>  1
            ]], 
            
            
            ['$set' =>  [
              'zbroj' =>  [
                '$sum' =>  [
                  '$zbrojG',
                  '$zbrojN',
                  '$zbrojI'
                ]
              ]
            ]], 
            
            
            ['$sort' =>  [
              'fakultet' =>  -1
            ]], 
            
            
            ['$sort' =>  [
              'zbroj' =>  -1
            ]], 
            
            
            ['$group' =>  [
              '_id' =>  '$fakultet',
              'kvota' =>  ['$first' =>  '$kvota'],
            
                'lista_bodova' =>  [
                '$push' =>  '$zbroj'
              ],
              'oibovi' =>  [
                '$push' =>  '$oib'
              ],
              'izbor' =>  [
                '$push' =>  '$izbor'
              ]
            ]], 
            
            ['$out' =>  'lista']
            
            ],
            'cursor' => new stdClass,
        
        
          
      ]);

      $result=$db->executeCommand('project', $command);

      if ($result==null) return null;

      return true;

    }
    public function urediFakseve($faksevi){
      foreach($faksevi as $f){
        $f->upisni_list=array();
        $f->bodovna_lista=$f->oibovi;
        unset($f->oibovi);
        unset($f->lista_bodova);
        $f->id= $f->_id;
        $f->ime= $f->_id;
        unset($f->_id);
        unset($f->izbor);
        $f->q= (int)$f->kvota;


      }
      return $faksevi;

    }
    public function urediStudente($studenti){
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
      return $studenti;
    }
    public function saveResultsAllFaks(){

      $db = DB2::getConnection(); 

      foreach($this->rezFaks as $faks){

        foreach($faks->upisni_list as $oib_studenta){
          $bulk2 = new MongoDB\Driver\BulkWrite;
          $bulk2->update(
            ['username' => $oib_studenta],
            ['$set' => ['upisao' =>  $faks->id ]],
            ['multi' => false, 'upsert' => false]
          );

          $result2 = $db->executeBulkWrite("project.studenti",$bulk2);

        }



        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => $faks->id],
            ['$set' => ['upisni_list' => $faks->upisni_list  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.lista",$bulk);

      }

    }
    public function run($faksevi,$studenti){
        echo "you initiated aggregation START procedure.";



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

        $this->rezFaks=$faksevi;
        $this->rezStud=$studenti;
    }
    public function resetAggreagtion(){
      $db = DB2::getConnection(); 
      echo "You initiated reset. DON'T CLOSE BROWSER.";

      $this->resetirajStudente();

      $db->executeCommand('project', 
      new \MongoDB\Driver\Command(["drop" => "lista"])
      );


    }
    public function resetirajStudente(){
      $db = DB2::getConnection(); 
      $studenti= $this->queryAll("studenti");

      foreach($studenti as $s){
        $bulk = new MongoDB\Driver\BulkWrite;
          $bulk->update(
            ['username' => $s->username ],
            ['$set' => ['upisao' =>  null ]],
            ['multi' => false, 'upsert' => false]
          );
  
          $result = $db->executeBulkWrite("project.studenti",$bulk);
      }

    }

    

}


?>