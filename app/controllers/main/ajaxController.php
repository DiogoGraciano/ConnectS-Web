<?php
namespace app\controllers\main;

use app\classes\functions;
use app\classes\controllerAbstract;
use app\classes\integracaoWs;

header('Content-Type: application/json; charset=utf-8');

class ajaxController extends controllerAbstract{

    /**
     * Método principal que recebe a requisição e chama o método correspondente.
     */
    public function index(){
        $method = $this->getValue("method");
        $parameters = $this->getValue("parameters");
        if ($method){
            if (method_exists($this,$method)){
                $this->$method($parameters);
            }
        }
    }

    /**
     * Método de teste para verificar a funcionalidade do AJAX.
     *
     * @param mixed $teste Parâmetro de teste.
     */
    public function teste($teste){
        $retorno = ["sucesso" => True,
                    "retorno" => $teste];
        echo json_encode($retorno);
    }

    /**
     * Obtém informações da empresa com base no CNPJ.
     *
     * @param string $cnpj CNPJ da empresa.
     */
    public function getEmpresa(string $cnpj){
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

    /**
     * Obtém informações do endereço com base no CEP.
     *
     * @param string $cep CEP do endereço.
     */
    public function getEndereco(string $cep){
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
