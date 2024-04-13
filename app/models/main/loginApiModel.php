<?php 
namespace app\models\main;
use app\db\loginApi;
use app\classes\mensagem;
use stdClass;

class loginApiModel{

    public static function login($nm_usuario,$senha){
        $login = new loginApi;
        $login = $login->get($nm_usuario,"nm_usuario");

        if ($login && password_verify($senha,$login->senha)){
                return True;
        }

        return False;
    }

    public static function get($cd){
        return (new loginApi)->get($cd); 
    }

    public static function getAll(){
        return (new loginApi)->selectColumns("cd_login_api","nm_usuario"); 
    }

    public static function set($nm_usuario,$senha,$cd_login_api = ""){

        $login = new loginApi;

        if(!$nm_usuario){
            mensagem::setErro("Nome do Usuario é obrigatorio");
            return false;
        }

        if ($login->get($nm_usuario,"nm_usuario")->cd_login_api){
            mensagem::setErro("Nome do Usuario já utilizado");
            return false;
        }

        if($cd_login_api && $nm_usuario){

            $values = new stdClass;

            $values->cd_login_api = $cd_login_api;
            $values->nm_usuario= $nm_usuario;
            if($senha){
                $values->senha = password_hash($senha,PASSWORD_DEFAULT);
            }

            $retorno = $login->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $login->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd_login_api && $nm_usuario && $senha){

            if(!$senha){
                mensagem::setErro("Senha é obrigatorio");
                return false;
            }

            $values = new stdClass;
            $values->nm_usuario= $nm_usuario;
            $values->senha = password_hash($senha,PASSWORD_DEFAULT);
            
            $retorno = $login->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $login->getLastId();
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
        return (new loginApi)->delete($cd);
    }

}