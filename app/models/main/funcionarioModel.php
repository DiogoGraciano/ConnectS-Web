<?php 
namespace app\models\main;
use app\db\funcionario;
use app\classes\mensagem;
use app\classes\functions;

class funcionarioModel{

    public static function get($cd=""){
        return (new funcionario)->get($cd);
    }

    public static function getAll($nm_funcionario,$nr_ramal,$nr_telefone,$nr_ip,$nm_usuario){
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

    public static function set($nr_ramal,$nm_funcionario,$nr_telefone,$nr_ip,$nm_usuario,$senha,$obs,$cd_funcionario = ""){

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

    public static function delete($cd){
        return (new funcionario)->delete($cd);
    }

}