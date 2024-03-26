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
        $menu->getMenu($this->url."agenda","Agendamento")
            ->getMenu($this->url."cliente","Cliente")
            ->getMenu($this->url."conexao","Conexão")
            ->getMenu($this->url."ramal","Ramal")
            ->getMenu($this->url."usuario","Usuario")
            ->getMenu($this->url."tabela","Exportar/Importar")
            ->getMenu($this->url."home/deslogar","Deslogar");
                       
        $menu->show("Menu");

        $footer = new footer;
        $footer->show();
    }
    public function deslogar(){
        loginModel::deslogar();
        $this->go("login");
    }
}