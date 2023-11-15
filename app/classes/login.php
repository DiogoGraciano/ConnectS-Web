<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;
use app\classes\mensagem;

class login extends pagina{

    public function show($action_login="login/action",$action_esqueci="",){

        $this->getTemplate("../templates/login.html");
        $this->tpl->caminho = Functions::getUrlBase();
        $this->tpl->action_login = $action_login;
        $mensagem = new mensagem;
        $this->tpl->mensagem = $mensagem->show(false);
        if ($action_esqueci){
            $this->tpl->action_esqueci = $action_esqueci;
            $this->tpl->block("BLOCK_ESQUECI");   
        }
        
        $this->tpl->show();
    }
}