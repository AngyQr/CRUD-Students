<?php
/**
 * Created by PhpStorm.
 * User: Angy
 * Date: 9/02/2018
 * Time: 16:55
 */
class Core {

    protected $controllerNow = 'studentsController';
    protected $methodNow = 'index';
    protected $parametresNow = [];

    function __construct(){
        $url = $this->getUrl();

        if(file_exists('../app/controllers/' . ucwords($url[0]).'Controller.php')){
            $this->controllerNow = ucwords($url[0]) . 'Controller';
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controllerNow . '.php';
        $this->controllerNow = new $this->controllerNow ;

        if(isset($url[1])){
            if(method_exists($this->controllerNow, $url[1])){
                $this->methodNow = $url[1];
                unset($url[1]);
            }
        }

        $this->parametresNow = $url ?  array_values($url) : [];

        call_user_func_array([$this->controllerNow, $this->methodNow], $this->parametresNow);
    }

    function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

}