<?php 
namespace app\controllers\api;

use app\classes\controllerAbstract;
use app\models\main\usuarioModel;
use app\classes\mensagem;
use Exception;

class usuarioController extends controllerAbstract{

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
     * Obtém a lista de usuários.
     *
     */
    public function getList(){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => usuarioModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(), "result" => false]);
            http_response_code(400);
        }
    }

    /**
     * Obtém usuários por IDs ou deleta usuários por IDs.
     *
     */
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
                        $errors[] = "Usuário com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $usuarios, "errors" => $errors]);
            }
            elseif ($this->requestType === 'DELETE'){
                $usuarios = [];
                $errors = [];
                foreach ($parameters as $id){
                    $usuario = usuarioModel::get($id);
                    if ($usuario->cd_usuario && usuarioModel::delete($usuario->cd_usuario)){
                        $usuarios[] = "Usuário com Id ({$id}) deletado com sucesso";
                    }else 
                        $errors[] = "Usuário com Id ({$id}) não encontrado";
                }
                echo json_encode(["result" => $usuarios, "errors" => $errors]);
            }else{
                echo json_encode(['error' => "Modo da requisição inválido ou JSON enviado inválido", "result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(), "result" => false]);
            http_response_code(400);
        }
    }

    /**
     * Insere ou atualiza usuários.
     *
     */
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
                            $result[] = "Usuário com Id ({$id}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "Usuário não informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                $columns = ["cd_cliente","nm_terminal","nm_sistema","nm_usuario","senha","obs"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"],$registro["nm_terminal"],$registro["nm_sistema"],$registro["nm_usuario"],$registro["senha"])){
                        $registro = $this->setParameters($columns,$registro);
                        if ($id = usuarioModel::set(...$registro)){
                            $result[] = "Usuário com Id ({$id}) inserido com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "Usuário não informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }else{
                echo json_encode(['error' => "Modo da requisição inválido ou JSON enviado inválido", "result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(), "result" => false]);
        }
    }
}
