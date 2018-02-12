<?php
/**
 * Created by PhpStorm.
 * User: Angy
 * Date: 9/02/2018
 * Time: 16:56
 */
class Controller{

    public function view($view, $data = []){
        //echo " view: " . $view ;
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die("La vista no existe");
        }
    }

}