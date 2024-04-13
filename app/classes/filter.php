<?php

namespace app\classes;
use app\classes\pagina;

class filter extends pagina{

    private $tplform;
    
    public function __construct($action)
    {
        $this->tplform = $this->getTemplate("filter_template.html");
        $this->tplform->action = $action;
    }

    public function addLinha(){
        $this->tplform->block("BLOCK_LINHA_FILTER");
        
        return $this;
    }

    public function addFilter($tamanho, $input){
        $this->tplform->tamanho = $tamanho;
        $this->tplform->filter = $input;
        $this->tplform->block("BLOCK_INPUT");
        $this->tplform->block("BLOCK_FILTER");

        return $this;
    }

    public function addbutton($button){
        $this->tplform->button = $button;
        $this->tplform->block("BLOCK_BUTTON");

        return $this;
    }

    public function show(){
        $this->addLinha();
        $this->tplform->show();
    }
}
