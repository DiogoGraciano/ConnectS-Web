<?php 
namespace app\controllers\main;

use app\classes\functions;
use app\classes\controllerAbstract;
use app\models\main\clienteModel;


header('Content-Type: application/json; charset=utf-8');

class apiV1Controller extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct(){
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        if ($this->requestType === "PUT" || $this->requestType === "POST")
            $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function getClientesList(){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => clienteModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
        }
    }
    public function ClientesbyIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $clientes = [];
                $errors = [];
                foreach ($parameters as $id){
                    if ($cliente = clienteModel::get($id))
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
                    if ($cliente = clienteModel::delete($id))
                        $clientes[] = "Cliente com Id ({$id}) deletado com sucesso";
                    else 
                        $errors[] = "Cliente com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $clientes, "errors" => $errors]);
            }else 
                echo json_encode(['error' => "Modo da requisão invalido ou Json enviado invalido","result" => false]); 
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
        }
    }
    public function setClientes(){
        try {
            $errors = [];
            $result = []; 
            if ($this->requestType === 'PUT' && $this->data){
               foreach ($this->data as $cliente){
                    if (clienteModel::set($cliente->nome,$cliente->nr_loja,$cliente->cd_cliente)){
                        $result[] = "Cliente com Id ({$cliente->cd_cliente}) atualizado com sucesso";
                    }
                    else{
                        $errors[] = "Cliente com Id ({$cliente->cd_cliente}) não atualizado";
                    }
               }
               echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                foreach ($this->data as $cliente){
                    if (clienteModel::set($cliente->nome,$cliente->nr_loja)){
                        $result[] = "Cliente com Id ({$cliente->cd_cliente}) atualizado com sucesso";
                    }
                    else{
                        $errors[] = "Cliente com Id ({$cliente->cd_cliente}) não atualizado";
                    }
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }else 
                echo json_encode(['error' => "Modo da requisão invalido ou Json enviado invalido","result" => false]); 
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
        }
    }

    private function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    private function getBearerToken() {
        $headers = getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}