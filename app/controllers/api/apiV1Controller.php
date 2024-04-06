<?php 
namespace app\controllers\main;

use app\classes\functions;
use app\classes\controllerAbstract;
use app\models\main\clienteModel;
use app\db\LoginApi;


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

        if (!$this->validateUser($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])){
            echo json_encode(['error' => "Token invalido","result" => false]);
            http_response_code(400);
            die;
        }

        $this->requestType = $_SERVER['REQUEST_METHOD'];
        if ($this->requestType === "PUT" || $this->requestType === "POST")
            $this->data = json_decode(file_get_contents('php://input'), true);
    }

    private function validateUser($usuario,$senha){
        return (new LoginApi)->selectByValues(["usuario","senha"],[$usuario,$senha]);
    }

    public function getClientesList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => clienteModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getClientesbyIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $clientes = [];
                $errors = [];
                foreach ($parameters as $id){
                    $cliente = clienteModel::get($id);
                    if ($cliente->cd_cliente)
                        $clientes[] = $cliente;
                    else 
                        $errors[] = "Cliente com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $clientes, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $clientes = [];
                $errors = [];
                foreach ($parameters as $id){
                    $cliente = clienteModel::get($id);
                    if ($cliente->cd_cliente && clienteModel::delete($cliente->cd_cliente)){
                        $clientes[] = "Cliente com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "Cliente com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $clientes, "errors" => $errors]);
            }else{
                echo json_encode(['error' => "Modo da requisão invalido ou Json enviado invalido","result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function setClientes($parameters){
        try {
            $errors = [];
            $result = []; 
            if ($this->requestType === 'PUT' && $this->data){
               foreach ($this->data as $cliente){
                    if (isset($cliente["nm_cliente"],$cliente["nr_loja"],$cliente["cd_cliente"])){
                        if ($cliente = clienteModel::set($cliente["nm_cliente"],$cliente["nr_loja"],$cliente["cd_cliente"])){
                            $result[] = "Cliente com Id ({$cliente}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = "Cliente não atualizado";
                        }
                    }
                    else
                        $errors[] = "Cliente não Informado corretamente";
               }
               echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                foreach ($this->data as $cliente){
                    if (isset($cliente["nm_cliente"],$cliente["nr_loja"])){
                        if ($cliente = clienteModel::set($cliente["nm_cliente"],$cliente["nr_loja"])){
                            $result[] = "Cliente com Id ({$cliente}) inserido com sucesso";
                        }
                        else{
                            $errors[] = "Cliente não inserido, verifique se o nome do cliente ja está cadastrado";
                        }
                    }
                    else
                        $errors[] = "Cliente não Informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }else{
                echo json_encode(['error' => "Modo da requisão invalido ou Json enviado invalido","result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
        }
    }
}