<?php 
namespace app\controllers\main;
use app\classes\controllerAbstract;
use app\models\main\clienteModel;

class clienteController extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct($requestType,$data){
        $this->requestType = $requestType;
        $this->data = $data;
    }
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => clienteModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getByIds($parameters){
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
    public function set($parameters){
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