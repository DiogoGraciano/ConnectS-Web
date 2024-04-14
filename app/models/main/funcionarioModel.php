<?php
namespace app\models\main;

use app\db\funcionario;
use app\classes\mensagem;
use app\classes\functions;

/**
 * Classe funcionarioModel
 * 
 * Esta classe fornece métodos para interagir com os dados dos funcionários.
 * Ela utiliza a classe funcionario para realizar operações de consulta no banco de dados.
 * 
 * @package app\models\main
 */
class funcionarioModel{

    /**
     * Obtém um funcionário pelo código.
     * 
     * @param string $cd O código do funcionário a ser buscado.
     * @return object Retorna os dados do funcionário ou null se não encontrado.
     */
    public static function get($cd=""){
        return (new funcionario)->get($cd);
    }

    /**
     * Obtém todos os funcionários com base nos filtros fornecidos.
     * 
     * @param string $nm_funcionario O nome do funcionário para filtrar.
     * @param string $nr_ramal O número do ramal para filtrar.
     * @param string $nr_telefone O número do telefone para filtrar.
     * @param string|int $nr_ip O número do IP para filtrar.
     * @param string $nm_usuario O nome do usuário para filtrar.
     * @return array Retorna um array de funcionários filtrados.
     */
    public static function getAll(string $nm_funcionario="",string|int $nr_ramal="",string $nr_telefone="",string $nr_ip="",string $nm_usuario=""){
        $funcionario = new funcionario;

        if($nm_funcionario){
            $funcionario->addFilter("nm_funcionario","LIKE","%".$nm_funcionario."%");
        }

        if($nr_ramal){
            $funcionario->addFilter("nr_ramal","=",$nr_ramal);
        }

        if($nr_telefone){
            $funcionario->addFilter("nm_sistema","LIKE","%".$nr_telefone."%");
        }

        if($nr_ip){
            $funcionario->addFilter("nr_ip","LIKE","%".$nr_ip."%");
        }

        if($nm_usuario){
            $funcionario->addFilter("nm_usuario","LIKE","%".$nm_usuario."%");
        }
        
        return $funcionario->selectAll();
    }

    /**
     * Insere ou atualiza um registro na tabela 'funcionario'.
     *
     * @param string|int $nr_ramal Número do ramal.
     * @param string $nm_funcionario Nome do funcionário.
     * @param string $nr_telefone Número do telefone.
     * @param string $nr_ip Número do IP.
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha do funcionário.
     * @param string $obs Observações.
     * @param string|int $cd_funcionario (Opcional) Código do funcionário para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set(string|int $nr_ramal,string $nm_funcionario,string $nr_telefone,string $nr_ip,string $nm_usuario,string $senha,string $obs,string|int $cd_funcionario = ""){

        $funcionario = new funcionario;

        if ($funcionario->get($nm_funcionario,"nm_funcionario")->cd_funcionario && !$cd_funcionario){
            mensagem::setErro("Funcionario já existe");
            return false;
        };

        if (!$nr_telefone = functions::formatarTelefone($nr_telefone)){
            mensagem::setErro("Numero invalido");
            return false; 
        }

        if (!$nr_ip = functions::formatarIP($nr_ip)){
            mensagem::setErro("Numero de IP invalido");
            return false; 
        }

        if ($nr_telefone && $funcionario->get($nr_telefone,"nr_telefone")->nr_telefone && !$cd_funcionario){
            mensagem::setErro("Telefone já cadastrado");
            return false;
        };

        if($cd_funcionario && $nr_ramal && $nm_funcionario){
   
            $values = $funcionario->getObject();
    
            $values->cd_funcionario = $cd_funcionario;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone = $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs = trim($obs);
    
            if ($values)
                $retorno = $funcionario->store($values);
    
            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $funcionario->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return false;
            }
    
        }
        elseif(!$cd_funcionario && $nr_ramal && $nm_funcionario){
            $values = $funcionario->getObject();

            $values->cd_funcionario = $cd_funcionario;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone = $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs = trim($obs);

            if ($values)
                $retorno = $funcionario->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Adicionado com Sucesso");
                return $funcionario->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }
        }
        else{
            mensagem::setErro("Erro ao excultar ação tente novamente");
            return False;
        }
    }

    /**
     * Deleta um registro da tabela 'funcionario' com base no código.
     *
     * @param string|int $cd Código do registro a ser deletado.
     * @return bool Retorna true se o registro foi deletado com sucesso, caso contrário, retorna false.
    */
    public static function delete(string|int $cd){
        return (new funcionario)->delete($cd);
    }

}