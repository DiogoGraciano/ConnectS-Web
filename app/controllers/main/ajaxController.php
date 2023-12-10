<?php
namespace app\controllers\main;

use app\classes\functions;
use app\classes\controllerAbstract;

header('Content-Type: application/json; charset=utf-8');

class ajaxController extends controllerAbstract{

    public function index(){
        $method = functions::getValue("method");
        $parameters = functions::getValue("parameters");
        if ($method){
            if (method_exists($this,$method)){
                $this->$method($parameters);
            }
        }
    }

    public function teste($teste){
        $retorno = ["sucesso" => False,
                    "retorno" => $teste];
        echo json_encode($retorno);
    }
}

?>