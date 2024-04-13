<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;

/**
 * Classe responsável por gerar o cabeçalho (head) das páginas HTML.
 * Esta classe herda de `pagina`, que fornece funcionalidades básicas para a criação de páginas HTML.
 */
class head extends pagina{

    /**
     * Gera e exibe o cabeçalho da página HTML com base nos parâmetros fornecidos.
     *
     * @param string $title Título da página.
     * @param string $type Tipo de página (opcional). Pode ser "grafico", "consulta" ou "agenda".
     * @param string $titulo Título adicional (opcional) a ser exibido na página.
     */
    public function show(string $title = "",string $type = "",string $titulo = ""){

        $this->getTemplate("head_template.html");
        $this->tpl->caminho = Functions::getUrlBase();
        $this->tpl->title = $title;
        
        if($titulo){
            $this->tpl->titulo = $titulo;
            $this->tpl->block("BLOCK_TITULO");
        }

        if ($type == "grafico"){
            $this->tpl->block("BLOCK_GRAFICO");   
        }
        elseif ($type == "consulta"){
            $this->tpl->block("BLOCK_CONSULTA");   
        }
        elseif ($type == "agenda"){
            $this->tpl->block("BLOCK_AGENDA");   
        }
        
        $this->tpl->show();
    }

}

?>
