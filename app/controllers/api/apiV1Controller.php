<?php 
namespace app\controllers\api;
use app\classes\controllerAbstract;
use app\models\main\loginApiModel;

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

        if (!loginApiModel::login($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])){
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

    public function funcionario($parameters){
        if (array_key_exists(0,$parameters) && method_exists($class = new funcionarioController($this->requestType,$this->data),$method = $parameters[0])){
            unset($parameters[0]);
            $class->$method($parameters);
        }
        else{
            echo json_encode(['error' => "Metodo não encontrado","result" => false]); 
            http_response_code(400);
        }
    }

    public function conexao($parameters){
        if (array_key_exists(0,$parameters) && method_exists($class = new conexaoController($this->requestType,$this->data),$method = $parameters[0])){
            unset($parameters[0]);
            $class->$method($parameters);
        }
        else{
            echo json_encode(['error' => "Metodo não encontrado","result" => false]); 
            http_response_code(400);
        }
    }

    public function usuario($parameters){
        if (array_key_exists(0,$parameters) && method_exists($class = new usuarioController($this->requestType,$this->data),$method = $parameters[0])){
            unset($parameters[0]);
            $class->$method($parameters);
        }
        else{
            echo json_encode(['error' => "Metodo não encontrado","result" => false]); 
            http_response_code(400);
        }
    }

    public function agenda($parameters){
        if (array_key_exists(0,$parameters) && method_exists($class = new agendaController($this->requestType,$this->data),$method = $parameters[0])){
            unset($parameters[0]);
            $class->$method($parameters);
        }
        else{
            echo json_encode(['error' => "Metodo não encontrado","result" => false]); 
            http_response_code(400);
        }
    }
}