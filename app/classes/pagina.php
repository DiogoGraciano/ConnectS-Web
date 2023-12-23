<?php
namespace app\classes;
use app\classes\template;
use app\classes\functions;
use app\db\Db;

class pagina{

    public $tpl;

    public function getTemplate($caminho,$accurate=false){

        $this->tpl = new template(Functions::getRaiz()."/app/view/templates/".$caminho,$accurate); 

        if ($this->tpl)
            return $this->tpl;
        else 
            return false;     
    }

    public function button($button_nome,$nm_input,$type_input="submit",$class_input="btn btn-dark pt-2 btn-block",$button_action="",$extra_input=""){

        $tpl= $this->getTemplate("elements_template.html");

        $tpl->type_input = $type_input;
        $tpl->nm_input = $nm_input;
        $tpl->class_input = $class_input;
        $tpl->button_action = $button_action;
        $tpl->extra_input = $extra_input;
        $tpl->button_nome = $button_nome;

        $tpl->block("BLOCK_BUTTON");   

        return $tpl->parse();

    }

    public function checkbox($nm_input,$nm_label,$required=false,$checked=false,$readonly=false,$value="on",$type_input="checkbox",$class_input="form-check-input",$extra_input=""){

        $tpl= $this->getTemplate("elements_template.html");

        $tpl->type_input = $type_input;
        $tpl->nm_input = $nm_input;
        $tpl->nm_label = $nm_label;
        $tpl->class_input = $class_input;
        if ($required)
            $extra_input = $extra_input.' required';
        if ($checked) 
            $extra_input = $extra_input.' checked';
        if ($readonly) 
            $extra_input = $extra_input.' onclick="return false;"';
        if ($value) 
            $extra_input = $extra_input.' value="'.$value.'"';

        $tpl->extra_input = $extra_input;

        $tpl->block("BLOCK_CHECKBOX");  
        
        return $tpl->parse();
    }
    
    public function input($nm_input,$nm_label,$vl_input="",$required=false,$readonly=false,$placeholder="",$type_input="text",$class_input="form-control",$extra_input=""){

        $tpl= $this->getTemplate("elements_template.html");

        $tpl->type_input = $type_input;
        $tpl->placeholder = $placeholder;
        $tpl->nm_label = $nm_label;
        $tpl->nm_input = $nm_input;
        $tpl->class_input = $class_input;
        $tpl->vl_input = $vl_input;
        if ($required == true)
            $extra_input = $extra_input." required";
        if ($readonly == true)
            $extra_input = $extra_input." readonly";
        
        $tpl->extra_input = $extra_input;

        $tpl->block("BLOCK_INPUT");   

        return $tpl->parse();
    }

    public function textarea($nm_input,$nm_label,$vl_input,$required=false,$readonly=false,$placeholder="",$rows_input="10",$cols_input="10",$class_input="form-control",$extra_input=""){

        $tpl= $this->getTemplate("elements_template.html");

        $tpl->nm_label = $nm_label;
        $tpl->placeholder = $placeholder;
        $tpl->nm_input = $nm_input;
        $tpl->class_input = $class_input;
        $tpl->vl_input = $vl_input;
        if ($required == true)
            $extra_input = $extra_input." required";
        if ($readonly == true)
            $extra_input = $extra_input." readonly";
        $tpl->extra_input = $extra_input;
        $tpl->rows_input = $rows_input;
        $tpl->cols_input = $cols_input;

        $tpl->block("BLOCK_TEXTAREA"); 
        
        return $tpl->parse();
    }

    public function select($nm_label,$nm_input,array $options,$vl_option="",$required=false,$class_input="form-select",$extra_input=""){

        $tpl= $this->getTemplate("elements_template.html");

        $tpl->nm_label = $nm_label;
        $tpl->nm_input = $nm_input;
        $tpl->class_input = $class_input;
        if ($required == true)
            $tpl->extra_input = $extra_input." required";

        foreach ($options as $option){
            $tpl->vl_option = $option->vl_option;
            if ($vl_option == $option->vl_option)
                $tpl->extra_option = "selected";
            $tpl->nm_option = $option->nm_option;
            $tpl->block("BLOCK_OPTION_SELECT");
            $tpl->extra_option = "";
        }
        
        $tpl->block("BLOCK_SELECT"); 
        
        return $tpl->parse();
    }

    public function datalist($nm_label,$nm_input,array $options,$vl_option="",$required=false,$class_input="form-control",$extra_input=""){

        $tpl= $this->getTemplate("elements_template.html");

        $tpl->nm_label = $nm_label;
        $tpl->nm_input = $nm_input;
        $tpl->class_input = $class_input;
        $tpl->vl_input = $vl_option;
        if ($required == true)
            $tpl->extra_input = $extra_input." required";

        foreach ($options as $option){
            $tpl->vl_option = $option->vl_option;
            $tpl->nm_option = $option->nm_option;
            $tpl->extra_option = $option->extra_option;
            $tpl->block("BLOCK_OPTION_DATALIST");
        }
        
        $tpl->block("BLOCK_DATALIST");  

        return $tpl->parse();
    }
    public function getOptions($tb,$coluna_vl,$coluna_nm){
        $db = new db($tb);
        $dados = $db->selectColumns(array($coluna_vl,$coluna_nm));

        $options = [];
        foreach ($dados as $dado){
            $options[] = $this->getObjectOption($dado->$coluna_vl,$dado->$coluna_nm);
        }

        return $options;
    }

    public function getObjectOption($vl_option,$nm_option,$extra_option=""){
        return json_decode('{"vl_option":"'.$vl_option.'","nm_option":"'.$nm_option.'","extra_option":"'.$extra_option.'"}');
    }


}


