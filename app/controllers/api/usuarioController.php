<?php 
namespace app\controllers\api;
use app\classes\controllerAbstract;
use app\models\main\usuarioModel;
use app\classes\mensagem;
use Exception;

class usuarioController extends controllerAbstract{

    private $requestType;
    private $data;

    public function __construct($requestType,$data){
        $this->requestType = $requestType;
        $this->data = $data;
    }
    public function getList($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => usuarioModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(),"result" => false]);
            http_response_code(400);
        }
    }
    public function getByIds($parameters){
        try {
            if ($this->requestType === 'GET' && empty($_GET)){
                $usuarios = [];
                $errors = [];
                foreach ($parameters as $id){
                    $usuario = usuarioModel::get($id);
                    if ($usuario->cd_usuario)
                        $usuarios[] = $usuario;
                    else 
                        $errors[] = "usuario com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $usuarios, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $usuarios = [];
                $errors = [];
                foreach ($parameters as $id){
                    $usuario = usuarioModel::get($id);
                    if ($usuario->cd_usuario && usuarioModel::delete($usuario->cd_usuario)){
                        $usuarios[] = "usuario com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "usuario com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $usuarios, "errors" => $errors]);
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
                $columns = ["cd_cliente","nm_terminal","nm_sistema","nm_usuario","senha","obs","cd_usuario"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"],$registro["nm_terminal"],$registro["nm_sistema"],$registro["nm_usuario"],$registro["senha"],$registro["cd_usuario"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = usuarioModel::set(...$registro)){
                            $result[] = "usuario com Id ({$id}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "usuario não Informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                $columns = ["cd_cliente","nm_terminal","nm_sistema","nm_usuario","senha","obs"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"],$registro["nm_terminal"],$registro["nm_sistema"],$registro["nm_usuario"],$registro["senha"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = usuarioModel::set(...$registro)){
                            $result[] = "usuario com Id ({$id}) inserido com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "usuario não Informado corretamente";
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