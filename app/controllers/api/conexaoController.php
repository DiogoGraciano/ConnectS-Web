<?php 
namespace app\controllers\api;

use app\classes\controllerAbstract;
use app\models\main\conexaoModel;
use app\classes\mensagem;
use Exception;

class conexaoController extends controllerAbstract{

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
     * Obtém a lista de conexões.
     */
    public function getList(){
        try {
            if ($this->requestType === 'GET' && empty($_GET))
                echo json_encode(["result" => conexaoModel::getAll()]);

        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(), "result" => false]);
            http_response_code(400);
        }
    }

    /**
     * Obtém conexões por IDs ou deleta conexões por IDs.
     *
     * @param array $parameters Parâmetros da requisição.
     */
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
                echo json_encode(["result" => $conexoes, "errors" => $errors]);
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
                echo json_encode(['error' => "Modo da requisição inválido ou JSON enviado inválido", "result" => false]); 
                http_response_code(400);
            }
        } catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage(), "result" => false]);
            http_response_code(400);
        }
    }

    /**
     * Insere ou atualiza conexões.
     */
    public function set(){
        try {
            $errors = [];
            $result = []; 
            if ($this->requestType === 'PUT' && $this->data){
                $columns = ["cd_cliente", "id_conexao", "nm_terminal", "nm_programa", "nr_caixa", "nm_usuario", "senha", "obs", "cd_conexao"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_conexao"], $registro["cd_cliente"], $registro["id_conexao"], $registro["nm_terminal"], $registro["nm_programa"])){
                        $registro = $this->setParameters($columns, $registro);
                        if ($id = conexaoModel::set(...$registro)){
                            $result[] = "Conexão com Id ({$id}) atualizado com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "Conexão não informado corretamente";
                }
                echo json_encode(["result" => $result, "errors" => $errors]);
            }
            elseif($this->requestType === 'POST' && $this->data){
                $columns = ["cd_cliente", "id_conexao", "nm_terminal", "nm_programa", "nr_caixa", "nm_usuario", "senha", "obs"];
                foreach ($this->data as $registro){
                    if (isset($registro["cd_cliente"], $registro["id_conexao"], $registro["nm_terminal"], $registro["nm_programa"])){
                        $registro = $this->setParameters($columns, $registro);
                        if ($id = conexaoModel::set(...$registro)){
                            $result[] = "Conexão com Id ({$id}) inserido com sucesso";
                        }
                        else{
                            $errors[] = mensagem::getErro();
                        }
                    }
                    else
                        $errors[] = "Conexão não informado corretamente";
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
