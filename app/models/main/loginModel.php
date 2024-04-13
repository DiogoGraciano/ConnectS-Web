<?php 
namespace app\models\main;
use app\db\login;
use app\classes\mensagem;
use stdClass;

class loginModel{

    public static function login($nm_usuario,$senha){
        $login = new login;
        $login = $login->get($nm_usuario,"nm_usuario");

        if ($login && password_verify($senha,$login->senha)){
                $_SESSION["user"] = $login->cd_login;
                $_SESSION["nome"] = $login->nm_usuario;
                return True;
        }

        mensagem::setErro("Usuario ou Senha invalido");
        return False;
    }

    public static function get($cd){
        return (new login)->get($cd); 
    }

    public static function getAll(){
        return (new login)->selectColumns("cd_login","nm_usuario"); 
    }

    public static function set($nm_usuario,$senha,$cd_login = ""){

        $login = new login;

        if(!$nm_usuario){
            mensagem::setErro("Nome do Usuario é obrigatorio");
            return false;
        }

        if ($login->get($nm_usuario,"nm_usuario")->cd_login){
            mensagem::setErro("Nome do Usuario já utilizado");
            return false;
        }

        if($cd_login && $nm_usuario){

            $values = $login->getObject();

            $values->cd_login = $cd_login;
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
        elseif(!$cd_login && $nm_usuario && $senha){

            if(!$senha){
                mensagem::setErro("Senha é obrigatorio");
                return false;
            }

            $values = $login->getObject();

            $values->cd_login = $cd_login;
            $values->nm_usuario= $nm_usuario;
            $values->senha = password_hash($senha,PASSWORD_DEFAULT);;
            
            if ($values)
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
        return (new login)->delete($cd);
    }

    public static function deslogar(){
        session_destroy();
    }

}