<?php
require_once __DIR__ . '/../app/database/db.class.php';

class GlobalService
{
    function queryOne($atribut){
        $db = DB2::getConnection(); 

        

        
        $filter  = [ "_id" => new MongoDB\BSON\ObjectId("60be3778f6ff748531643dbe")];
        $options = [];


        $query = new \MongoDB\Driver\Query($filter, $options);

        $result = $db->executeQuery("project.global",$query); 

        switch($atribut){
            case "lock_date":
                return $result->toArray()[0]->PLANIRANI_DATUM_ZAKLJUCAVANJA;
            case "lock_bool":
                return $result->toArray()[0]->UPISI_ZAKLJUCANI;
            case "result_date":
                return $result->toArray()[0]->PLANIRANI_DATUM_OBJAVE_REZULTATA;      
            case "result_bool":
                return $result->toArray()[0]->REZULTATI_GOTOVI;   
            case "agreg_bool":
                return $result->toArray()[0]->AGREGACIJA_GOTOVA;                   
        }
        return null;       
    }

    function getLockDate(){
        return $this->queryOne("lock_date");
    } 
    function getLockBool(){
        return $this->queryOne("lock_bool");
    } 
    function getResultsDate(){
        return $this->queryOne("result_date");
    } 
    function getResultsBool(){
        return $this->queryOne("result_bool");
    } 
    function getAgregBool(){
        return $this->queryOne("agreg_bool");
    } 
    function switchResultsBool($value){
        return $this->change("REZULTATI_GOTOVI",$value);
    }
    function switchLockBool($value){
        return $this->change("UPISI_ZAKLJUCANI",$value);
    } 
    function switchAgregBool($value){
        return $this->change("AGREGACIJA_GOTOVA",$value);
    } 

    function change($atribut,$value){
        $db = DB2::getConnection(); 
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => new MongoDB\BSON\ObjectId("60be3778f6ff748531643dbe")],
            ['$set' => [$atribut => $value  ]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $db->executeBulkWrite("project.global",$bulk); 
    }

}