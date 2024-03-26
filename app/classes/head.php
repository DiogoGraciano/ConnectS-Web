<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\functions;

class head extends pagina{

    public function show($title="",$type="",$titulo=""){

        $this->getTemplate("head_template.html");
        $this->tpl->caminho = Functions::getUrlBase();
        $this->tpl->title = $title;
        
        if($titulo){
            $this->tpl->titulo = $titulo;
            $this->tpl->block("BLOCK_TITULO");
        }

        if ($type=="grafico"){
            $this->tpl->block("BLOCK_GRAFICO");   
        }
        elseif ($type=="consulta"){
            $this->tpl->block("BLOCK_CONSULTA");   
        }
        elseif ($type=="agenda"){
            $this->tpl->block("BLOCK_AGENDA");   
        }
        
        $this->tpl->show();
    }

}

?>