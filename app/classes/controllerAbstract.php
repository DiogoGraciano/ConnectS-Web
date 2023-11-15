<?php
namespace app\classes;

abstract class controllerAbstract{

    public $url;

    public function __construct()
    {
        $this->url = "http://".$_SERVER['HTTP_HOST']."/";
    }

    public function setList($nome,$valor){
        $_SESSION[$nome] = $valor;
    }

    public function getList($nome){
        if (array_key_exists($nome,$_SESSION))
            return $_SESSION[$nome];
        else 
            return "";
    }
}

?>