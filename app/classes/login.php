<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;
use app\classes\mensagem;

class login extends pagina{

    public function show(){
        $this->getTemplate("../templates/login.html");
        $this->tpl->caminho = Functions::getUrlBase();
        $this->tpl->action_login = "login/action";
        $mensagem = new mensagem;
        $this->tpl->mensagem = $mensagem->show(false);
        $this->tpl->show();
    }
}