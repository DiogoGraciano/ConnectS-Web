<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;

/**
 * Classe para gerenciar e exibir menus.
 * Esta classe estende a classe 'pagina' para herdar métodos relacionados ao template.
 */
class menu extends pagina{

    /**
     * Array para armazenar os itens do menu.
     *
     * @var array
     */
    private $menus = [];

    /**
     * Exibe o menu na página.
     *
     * @param string $titulo   Título do menu.
     */
    public function show(string $titulo){

        // Obtém o template do menu
        $this->getTemplate("../templates/menu.html");

        // Define o título do menu
        $this->tpl->titulo = $titulo;

        // Obtém e exibe mensagens
        $mensagem = new mensagem;
        $this->tpl->mensagem = $mensagem->show(false);
        
        // Loop através dos itens do menu e os exibe
        foreach ($this->menus as $menu){
            $this->tpl->url_menu = $menu->url_menu;
            $this->tpl->titulo_menu = $menu->titulo_menu; 
            $this->tpl->block("BLOCK_MENU");
        }
        
        // Exibe o template completo do menu
        $this->tpl->show();
    }

    /**
     * Adiciona um novo item ao menu.
     *
     * @param string $url_menu       URL do item do menu.
     * @param string $titulo_menu    Título do item do menu.
     * @return menu                  Retorna a instância do objeto menu para permitir chamadas encadeadas.
     */
    public function addMenu(string $url_menu,string $titulo_menu){
        $this->menus[] = json_decode('{"url_menu":"'.$url_menu.'","titulo_menu":"'.$titulo_menu.'"}');
        return $this;
    }
}
