<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;

class menu extends pagina{

    private $menus = [];

    public function show($titulo){

        $this->getTemplate("../templates/menu.html");
        $this->tpl->titulo = $titulo;
        $mensagem = new mensagem;
        $this->tpl->mensagem = $mensagem->show(false);
        
        foreach ($this->menus as $menu){
            $this->tpl->url_menu = $menu->url_menu;
            $this->tpl->titulo_menu = $menu->titulo_menu; 
            $this->tpl->block("BLOCK_MENU");
        }
        
        $this->tpl->show();
    }
    public function addMenu($url_menu,$titulo_menu){
        $this->menus[] = json_decode('{"url_menu":"'.$url_menu.'","titulo_menu":"'.$titulo_menu.'"}');
        return $this;
    }
}
