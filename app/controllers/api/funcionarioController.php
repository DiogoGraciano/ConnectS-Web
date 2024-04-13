<?php 
namespace app\controllers\api;
use app\classes\controllerAbstract;
use app\models\main\funcionarioModel;
use app\classes\mensagem;
use Exception;

class funcionarioController extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct($requestType,$data){
        $this->requestType = $requestType;
        $this->data = $data;
    }
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => funcionarioModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getByIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $funcionarios = [];
                $errors = [];
                foreach ($parameters as $id){
                    $funcionario = funcionarioModel::get($id);
                    if ($funcionario->cd_funcionario)
                        $funcionarios[] = $funcionario;
                    else 
                        $errors[] = "funcionario com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $funcionarios, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $funcionarios = [];
                $errors = [];
                foreach ($parameters as $id){
                    $funcionario = funcionarioModel::get($id);
                    if ($funcionario->cd_funcionario && funcionarioModel::delete($funcionario->cd_funcionario)){
                        $funcionarios[] = "funcionario com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "funcionario com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $funcionarios, "errors" => $errors]);
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
                $columns = ["nr_ramal","nm_funcionario","nr_telefone","nr_ip","nm_usuario","senha","obs","cd_funcionario"];
                foreach ($this->data as $registro){
                    if (isset($registro["nr_ramal"],$registro["nm_funcionario"],$registro["cd_funcionario"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = funcionarioModel::set(...$registro)){
                            $result[] = "funcionario com Id ({$id}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "funcionario não Informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                $columns = ["nr_ramal","nm_funcionario","nr_telefone","nr_ip","nm_usuario","senha","obs"];
                foreach ($this->data as $registro){
                    if (isset($registro["nr_ramal"],$registro["nm_funcionario"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = funcionarioModel::set(...$registro)){
                            $result[] = "funcionario com Id ({$id}) inserido com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "funcionario não Informado corretamente";
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