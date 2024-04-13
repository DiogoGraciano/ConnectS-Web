<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;
use app\classes\mensagem;

/**
 * Classe para gerar a página de login.
 * Esta classe estende a classe 'pagina' para herdar métodos relacionados ao template.
 */
class login extends pagina{

    /**
     * Exibe o template da página de login.
     */
    public function show(){
        // Obtém o template da página de login
        $this->getTemplate("../templates/login.html");

        // Define a URL base para o template
        $this->tpl->caminho = Functions::getUrlBase();

        // Define a ação do formulário de login no template
        $this->tpl->action_login = "login/action";

        // Obtém e exibe a mensagem de status (se houver)
        $mensagem = new mensagem;
        $this->tpl->mensagem = $mensagem->show(false);

        // Exibe o template
        $this->tpl->show();
    }
}
