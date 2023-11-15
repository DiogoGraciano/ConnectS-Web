<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\login;
use app\classes\mensagem;
use app\classes\controllerAbstract;
use app\classes\footer;

class loginController extends controllerAbstract{


    public function index(){

        $head = new head();
        $head->show("Login","");

        $login = new login();
        $login->show();

        $footer = new footer;
        $footer->show();
    }

    public function action(){

        $senha = '';
        $nm_usuario = '';
        $nm_usuario = (string)filter_input(INPUT_POST, 'nm_usuario');
        $senha = (string)filter_input(INPUT_POST, 'senha');
        $db = new db("tb_login");
        $colunas = array("nm_usuario","senha");
        $valores = array($nm_usuario,$senha);
        $login = $db->selectByValues($colunas,$valores,true);

        if ($login){
            $_SESSION["user"] = $login[0]->cd_login;
            $_SESSION["nome"] = $login[0]->nm_usuario;
            header("Location: ".$this->url."home");
            exit;
        }else {
            mensagem::setErro(array("Usuario ou Senha invalido"));
            mensagem::addErro(array($db->getError()));
            header("Location: ".$this->url."login");
        }
    }
    
}