<?php 
namespace app\models\main;
use app\db\login;
use app\classes\mensagem;

class loginModel{

    public static function login($nm_usuario,$senha){
        $login = new login;
        $login = $login->get($nm_usuario,"nm_usuario");

        if ($login){
            if (password_verify($senha,$login->senha)){
                $_SESSION["user"] = $login->cd_login;
                $_SESSION["nome"] = $login->nm_usuario;
                return True;
            }
        }
        mensagem::setErro("Usuario ou Senha invalido");
        return False;
        
    }
    public static function deslogar(){
        session_destroy();
    }

}