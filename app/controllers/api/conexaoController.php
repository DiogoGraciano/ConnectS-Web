<?php 
namespace app\controllers\api;
use app\classes\controllerAbstract;
use app\models\main\conexaoModel;
use app\classes\mensagem;

class conexaoController extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct($requestType,$data){
        $this->requestType = $requestType;
        $this->data = $data;
    }
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => conexaoModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getByIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $conexoes = [];
                $errors = [];
                foreach ($parameters as $id){
                    $conexao = conexaoModel::get($id);
                    if ($conexao->cd_conexao)
                        $conexoes[] = $conexao;
                    else 
                        $errors[] = "Conexão com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $conexao, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $conexoes = [];
                $errors = [];
                foreach ($parameters as $id){
                    $conexao = conexaoModel::get($id);
                    if ($conexao->cd_conexao && conexaoModel::delete($conexao->cd_conexao)){
                        $conexoes[] = "Conexão com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "Conexão com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $conexoes, "errors" => $errors]);
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
                $columns = ["cd_cliente","id_conexao","nm_terminal","nm_programa","nr_caixa","nm_usuario","senha","obs","cd_conexao"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_conexao"],$registro["cd_cliente"],$registro["id_conexao"],$registro["nm_terminal"],$registro["nm_programa"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = conexaoModel::set(...$registro)){
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
                $columns = ["cd_cliente","id_conexao","nm_terminal","nm_programa","nr_caixa","nm_usuario","senha","obs"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"],$registro["id_conexao"],$registro["nm_terminal"],$registro["nm_programa"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = conexaoModel::set(...$registro)){
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