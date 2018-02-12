<?php
/**
 * Created by PhpStorm.
 * User: Angy
 * Date: 9/02/2018
 * Time: 17:03
 */

class Database{

    static function connect(){
        try{
            $con = new PDO('mysql:host='.DB_HOST.';dbname='. DB_NAME, DB_USER, DB_PASS);
            $con->exec('SET CHARACTER SET utf8');
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return null;
    }

}