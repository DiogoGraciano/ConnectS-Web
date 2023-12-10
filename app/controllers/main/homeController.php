<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\menu;
use app\classes\footer;
use app\classes\controllerAbstract;

class homeController extends controllerAbstract{

    public function index(){

        $head = new head();
        $head->show("Menu","");

        $menu = new menu();
        $menus = array($menu->getMenu($this->url."agendamento","Agendamento"),
                       $menu->getMenu($this->url."cliente","Cliente"),
                       $menu->getMenu($this->url."conexao","Conexão"),
                       $menu->getMenu($this->url."ramal","Ramal"),
                       $menu->getMenu($this->url."usuario","Usuario"),
                       $menu->getMenu($this->url."tabela","Exportar/Importar"),
                       $menu->getMenu($this->url."home/deslogar","Deslogar"),
                       $menu->getMenu($this->url."ajax/call/teste/teste","Ajax"));
        $menu->show("Menu",$menus);

        $footer = new footer;
        $footer->show();
    }
    public function deslogar(){
        session_destroy();
        header("location: ".$this->url."login");
    }
}