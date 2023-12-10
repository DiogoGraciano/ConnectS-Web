<?php
namespace app\classes;

class functions{
    public static function getRaiz(){
        return $_SERVER['DOCUMENT_ROOT'];
    }
    public static function getUrlBase(){
        return "http://".$_SERVER['HTTP_HOST']."/";
    }
    public static function getValue($var){
        if (isset($_POST[$var]))
            return $_POST[$var];
        elseif(isset($_GET[$var]))
            return $_GET[$var];
        elseif(!isset($_SESSION[$var]))
            return $_SESSION[$var];
        else 
            return "";
    }
}

?>