<?php 
namespace app\controllers\main;

use app\classes\head;
use app\classes\login;
use app\classes\controllerAbstract;
use app\classes\footer;
use app\models\main\loginModel;

class loginController extends controllerAbstract{

    /**
     * Método principal para exibir a página de login.
     * Mostra o formulário de login para que o usuário possa inserir suas credenciais.
     */
    public function index(){

        $head = new head();
        $head->show("Login","");

        $login = new login();
        $login->show();

        $footer = new footer;
        $footer->show();
    }

    /**
     * Método para processar a ação de login.
     * Verifica as credenciais do usuário e redireciona para a página inicial se o login for bem-sucedido.
     * Caso contrário, redireciona de volta para a página de login.
     */
    public function action(){

        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');
        $login = loginModel::login($nm_usuario,$senha);
    
        if ($login){
            $this->go("home");
        }else {
            $this->go("login");
        }
    }
}
