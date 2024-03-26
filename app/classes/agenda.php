<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\mensagem;

class agenda extends pagina{

    private $buttons = [];
    
    public function show($action,$eventos,$slot_duration = 30)
    {
        $this->tpl = $this->getTemplate("agenda_template.html");
        $mensagem = new mensagem;
        $this->tpl->mensagem = $mensagem->show(false);
        $this->tpl->action = $action;
        
        if ($slot_duration >= 60)
            $this->tpl->slot_duration = "01:00";
        else 
            $this->tpl->slot_duration = "00:".$slot_duration;

        $this->tpl->events = $eventos;

        $date = new \DateTimeImmutable();
        $this->tpl->initial_date = $date->format(\DateTimeInterface::ISO8601);

        foreach ($this->buttons as $button){
            $this->tpl->button = $button;
            $this->tpl->block("BLOCK_BUTTON");
        }
        $this->tpl->block("BLOCK_CALENDARIO");
        $this->tpl->show();
    }

    public function addButton($button){
        $this->buttons[] = $button;
    }
}
