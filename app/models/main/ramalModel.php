<?php 
namespace app\models\main;
use app\db\ramal;
use app\classes\mensagem;
use app\classes\functions;

class ramalModel{

    public static function get($cd = ""){
        return (new ramal)->get($cd);
    }

    public static function getAll(){
        return (new ramal)->getAll();
    }

    public static function set($nr_ramal,$nm_funcionario,$nr_telefone,$nr_ip,$nm_usuario,$senha,$obs,$cd_ramal = ""){

        $ramal = new ramal;

        if ($ramal->get($nm_funcionario,"nm_funcionario")->cd_ramal && !$cd_ramal){
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

        if ($nr_telefone && $ramal->get($nr_telefone,"nr_telefone")->nr_telefone && !$cd_ramal){
            mensagem::setErro("Telefone já cadastrado");
            return false;
        };

        if($cd_ramal && $nr_ramal && $nm_funcionario){
   
            $values = $ramal->getObject();
    
            $values->cd_ramal = $cd_ramal;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone = $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs = trim($obs);
    
            if ($values)
                $retorno = $ramal->store($values);
    
            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $ramal->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return false;
            }
    
        }
        elseif(!$cd_ramal && $nr_ramal && $nm_funcionario){
            $values = $ramal->getObject();

            $values->cd_ramal = $cd_ramal;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone = $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs = trim($obs);

            if ($values)
                $retorno = $ramal->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Adicionado com Sucesso");
                return $ramal->getLastId();
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
        return (new ramal)->delete($cd);
    }

}