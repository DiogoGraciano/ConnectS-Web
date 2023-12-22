<?php 
namespace app\models\main;
use app\db\db;
use app\classes\mensagem;
use app\classes\modelAbstract;

class ramalModel{

    public static function get($cd = ""){
        return modelAbstract::get("tb_ramal",$cd);
    }

    public static function set($nr_ramal,$nm_funcionario,$nr_telefone,$nr_ip,$nm_usuario,$senha,$obs,$cd_ramal = ""){

        $db = new db("tb_ramal");

        if($cd_ramal && $nr_ramal){
   
            $values = $db->getObject();
    
            $values->cd_ramal = $cd_ramal;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone= $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;
    
            if ($values)
                $retorno = $db->store($values);
    
            if ($retorno == true){
                mensagem::setSucesso(array("Atualizado com Sucesso"));
                return True;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
                return false;
            }
    
            }
        elseif(!$cd_ramal && $nr_ramal){
            $values = $db->getObject();

            $values->cd_ramal = $cd_ramal;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone= $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Adicionado com Sucesso"));
                return True;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
                return False;
            }
        }
        else{
            mensagem::setErro(array("Erro ao excultar ação tente novamente"));
            return False;
        }
    }

    public static function delete($cd){
        modelAbstract::delete("tb_ramal",$cd);
    }

}