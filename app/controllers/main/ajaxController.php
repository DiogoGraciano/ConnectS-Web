<?php
namespace app\controllers\main;
use app\db\db;
use app\classes\mensagem;
use app\classes\controllerAbstract;

class ajaxController extends controllerAbstract{

    public function call($parameters){
        $method = $parameters[0];
        unset($parameters[0]);
        $parameter = "";
        if (array_key_exists(1,$parameters))
            $parameter = $parameters;
        if (method_exists($this,$method)){
            $this->$method($parameter);
        }
    }

    public function teste($teste){
        var_dump(json_decode($teste[1]));
    }
}

?>