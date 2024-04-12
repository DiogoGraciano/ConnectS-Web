<?php 
namespace app\controllers\api;
use app\classes\controllerAbstract;
use app\models\main\ramalModel;

class ramalController extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct($requestType,$data){
        $this->requestType = $requestType;
        $this->data = $data;
    }
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => ramalModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getByIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $ramals = [];
                $errors = [];
                foreach ($parameters as $id){
                    $ramal = ramalModel::get($id);
                    if ($ramal->cd_ramal)
                        $ramals[] = $ramal;
                    else 
                        $errors[] = "Ramal com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $ramals, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $ramals = [];
                $errors = [];
                foreach ($parameters as $id){
                    $ramal = ramalModel::get($id);
                    if ($ramal->cd_ramal && ramalModel::delete($ramal->cd_ramal)){
                        $ramals[] = "Ramal com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "Ramal com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $ramals, "errors" => $errors]);
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
            $columns = ["nr_ramal","nm_funcionario","nr_telefone","nr_ip","nm_usuario","senha","obs","cd_ramal"];
            if ($this->requestType === 'PUT' && $this->data){
               foreach ($this->data as $registro){
                    if (isset($registro["nr_ramal"],$registro["nm_funcionario"],$registro["cd_ramal"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = RamalModel::set(...$registro)){
                            $result[] = "Ramal com Id ({$id}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "Ramal não Informado corretamente";
               }
               echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                foreach ($this->data as $registro){
                    if (isset($registro["nr_ramal"],$registro["nm_funcionario"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = RamalModel::set(...$registro)){
                            $result[] = "Ramal com Id ({$id}) inserido com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "Ramal não Informado corretamente";
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