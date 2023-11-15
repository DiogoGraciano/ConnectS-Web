<?php
namespace app\classes;

class functions{
    public static function getRaiz(){
        return $_SERVER['DOCUMENT_ROOT'];
    }
    public static function getUrlBase(){
        return "http://".$_SERVER['HTTP_HOST']."/";
    }
}

?>