<?php
namespace app\controllers\main;

use app\classes\functions;
use app\classes\controllerAbstract;
use app\classes\integracaoWs;

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
        $retorno = ["sucesso" => True,
                    "retorno" => $teste];
        echo json_encode($retorno);
    }

    public function getEmpresa($cnpj){
        $integracao = new integracaoWs;
        $retorno = $integracao->getEmpresa($cnpj);

        if ($retorno && is_object($retorno)){
            $retorno = ["sucesso" => True,
            "retorno" => $retorno];
        }
        else{
            $retorno = ["sucesso" => False,
            "retorno" => $retorno];
        }

        echo json_encode($retorno);
    }
    public function getEndereco($cep){
        $integracao = new integracaoWs;
        $retorno = $integracao->getEndereco($cep);

        if ($retorno && is_object($retorno)){
            $retorno = ["sucesso" => True,
            "retorno" => $retorno];
        }
        else{
            $retorno = ["sucesso" => False,
            "retorno" => $retorno];
        }

        echo json_encode($retorno);
    }
}

?>