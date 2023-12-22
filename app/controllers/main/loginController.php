<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\login;
use app\classes\controllerAbstract;
use app\classes\footer;
use app\models\main\loginModel;

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

        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');
        $login =loginModel::login($nm_usuario,$senha);
    
        if ($login){
            $this->go("home");
        }else {
            $this->go("login");
        }
    }
    
}