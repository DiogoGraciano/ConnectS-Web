<?php 
namespace app\models\main;
use app\db\db;
use app\classes\mensagem;

class loginModel{

    public static function login($nm_usuario,$senha){
        $db = new db("tb_login");
        $colunas = array("nm_usuario");
        $valores = array($nm_usuario);
        $login = $db->selectByValues($colunas,$valores,true);

        if ($login){
            if (password_verify($senha,$login[0]->senha)){
                $_SESSION["user"] = $login[0]->cd_login;
                $_SESSION["nome"] = $login[0]->nm_usuario;
                return True;
            }
        }
        mensagem::setErro(array("Usuario ou Senha invalido"));
        mensagem::addErro(array($db->getError()));
        return False;
        
    }
    public static function deslogar(){
        session_destroy();
    }

}