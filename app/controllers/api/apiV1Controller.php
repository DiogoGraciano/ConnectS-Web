<?php 
namespace app\controllers\api;

use app\classes\functions;
use app\classes\controllerAbstract;
use app\classes\mensagem;
use app\models\main\clienteModel;

header('Content-Type: application/json; charset=utf-8');

class apiV1Controller extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct(){
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])){
            echo json_encode(['error' => "Token não informado ou invalido","result" => false]);
            http_response_code(400);
            die;
        }

        if (!$this->validateUserApi($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])){
            echo json_encode(['error' => "Token invalido","result" => false]);
            http_response_code(400);
            die;
        }

        $this->requestType = $_SERVER['REQUEST_METHOD'];
        if ($this->requestType === "PUT" || $this->requestType === "POST")
            $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function cliente($parameters){
        if (array_key_exists(0,$parameters) && method_exists($class = new clienteController($this->requestType,$this->data),$method = $parameters[0])){
            unset($parameters[0]);
            $class->$method($parameters);
        }
        else{
            echo json_encode(['error' => "Metodo não encontrado","result" => false]); 
            http_response_code(400);
        }
    }

    public function ramal($parameters){
        if (array_key_exists(0,$parameters) && method_exists($class = new ramalController($this->requestType,$this->data),$method = $parameters[0])){
            unset($parameters[0]);
            $class->$method($parameters);
        }
        else{
            echo json_encode(['error' => "Metodo não encontrado","result" => false]); 
            http_response_code(400);
        }
    }
}