<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\menu;
use app\classes\footer;
use app\classes\controllerAbstract;
use app\models\main\loginModel;

class homeController extends controllerAbstract{

    public function index(){

        $head = new head();
        $head->show("Menu","");

        $menu = new menu();
        $menu->addMenu($this->url."agenda","Agendamento")
            ->addMenu($this->url."cliente","Cliente")
            ->addMenu($this->url."conexao","Conexão")
            ->addMenu($this->url."funcionario","Funcionario")
            ->addMenu($this->url."usuario","Usuario")
            ->addMenu($this->url."cadastro","Usuarios Sistema")
            ->addMenu($this->url."cadastroApi","Usuarios API")
            ->addMenu($this->url."tabela","Exportar/Importar")
            ->addMenu($this->url."home/deslogar","Deslogar");
                       
        $menu->show("Menu");

        $footer = new footer;
        $footer->show();
    }
    public function deslogar(){
        loginModel::deslogar();
        $this->go("login");
    }
}