<?php 
namespace app\controllers\api;
use app\classes\controllerAbstract;
use app\models\main\agendaModel;
use app\classes\mensagem;
use Exception;

class agendaController extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct($requestType,$data){
        $this->requestType = $requestType;
        $this->data = $data;
    }
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => agendaModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getByIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $agendas = [];
                $errors = [];
                foreach ($parameters as $id){
                    $agenda = agendaModel::get($id);
                    if ($agenda->cd_agenda)
                        $agendas[] = $agenda;
                    else 
                        $errors[] = "agenda com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $agendas, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $agendas = [];
                $errors = [];
                foreach ($parameters as $id){
                    $agenda = agendaModel::get($id);
                    if ($agenda->cd_agenda && agendaModel::delete($agenda->cd_agenda)){
                        $agendas[] = "agenda com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "agenda com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $agendas, "errors" => $errors]);
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
                $columns = ["cd_cliente","cd_funcionario","titulo","dt_inicio","dt_fim","cor","obs","status","cd_agenda"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"],$registro["cd_funcionario"],$registro["titulo"],$registro["dt_inicio"],$registro["dt_fim"],$registro["cd_agenda"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($agenda = agendaModel::set(...$registro)){
                            $result[] = "agenda com Id ({$agenda}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "agenda não Informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                $columns = ["cd_cliente","cd_funcionario","titulo","dt_inicio","dt_fim","cor","obs","status"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"],$registro["cd_funcionario"],$registro["titulo"],$registro["dt_inicio"],$registro["dt_fim"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($agenda = agendaModel::set(...$registro)){
                            $result[] = "agenda com Id ({$agenda}) inserido com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "agenda não Informado corretamente";
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