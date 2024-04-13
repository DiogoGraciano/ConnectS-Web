<?php 
namespace app\controllers\api;

use app\classes\controllerAbstract;
use app\models\main\agendaModel;
use app\classes\mensagem;
use Exception;

class agendaController extends controllerAbstract{

    /**
     * Tipo de requisição HTTP (GET, POST, PUT, DELETE).
     * 
     * @var string
     */
    private $requestType;

    /**
     * Dados enviados na requisição.
     * 
     * @var mixed
     */
    private $data;

    /**
     * Construtor da classe.
     *
     * @param string $requestType Tipo de requisição HTTP.
     * @param mixed $data Dados enviados na requisição.
     */
    public function __construct($requestType, $data){
        $this->requestType = $requestType;
        $this->data = $data;
    }

    /**
     * Obtém a lista de agendas.
     *
     * @param array $parameters Parâmetros da requisição.
     */
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => agendaModel::getAll()]);
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }

    /**
     * Obtém agendas por IDs ou deleta agendas por IDs.
     *
     * @param array $parameters Parâmetros da requisição.
     */
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
                echo json_encode(['error' => "Modo da requisição inválido ou Json enviado inválido","result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }

    /**
     * Define ou atualiza agendas.
     */
    public function set(){
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
                        $errors[] = "agenda não informado corretamente";
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
                        $errors[] = "agenda não informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }else{
                echo json_encode(['error' => "Modo da requisição inválido ou Json enviado inválido","result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
        }
    }
}
