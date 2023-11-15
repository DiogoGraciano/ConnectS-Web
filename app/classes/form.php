<?php

namespace app\classes;
use app\classes\pagina;
use app\classes\mensagem;
use app\db\db;

class form extends pagina{

    private $tplform;
    
    public function __construct($titulo,$action)
    {
        $this->tplform = $this->getTemplate("form_template.html");
        $this->tplform->titulo = $titulo;
        $mensagem = new mensagem;
        $this->tplform->mensagem = $mensagem->show(false);
        $this->tplform->action = $action;
        $this->tplform->block("BLOCK_START");
    }

    public function setinputs($input){
        $tpl= $this->getTemplate("inputs_template.html");
        $tpl->block_um_input = $input;
        $tpl->block("BLOCK_INPUT");
        $this->tplform->input = $tpl->parse();
        $this->tplform->block("BLOCK_INPUT");
    }

    public function setCustomInputs(array $inputs_custom){
        $tpl= $this->getTemplate("inputs_template.html");
        foreach ($inputs_custom as $custom){ 
            foreach ($custom as $cus){
                $tpl->tamanho = $cus->tamanho;
                $tpl->block_um_input = base64_decode($cus->input);
                $tpl->block("BLOCK_DIV");
            }
            $tpl->block("BLOCK_CUSTOM");
        }
        $this->tplform->input = $tpl->parse();
        $this->tplform->block("BLOCK_INPUT");
    }

    public function getCustomInput($tamanho,$input){
        return json_decode('{
            "tamanho":"'.$tamanho.'",
            "input":"'.base64_encode($input).'"
         }');
    }

    public function setDoisInputs($input,$input2){
        $tpl=$this->getTemplate("inputs_template.html");
        $tpl->block_dois_input = $input;
        $tpl->block_dois_input_dois = $input2;
        $tpl->block("BLOCK_INPUT_DOIS");
        $this->tplform->input = $tpl->parse();
        $this->tplform->block("BLOCK_INPUT");
    }

    public function setHidden($nome,$valor){
        $this->tplform->nome = $nome;
        $this->tplform->cd_value = $valor;
        $this->tplform->block("BLOCK_INPUT_HIDDEN");
    }

    public function setTresInputs($input,$input2,$input3){
        $tpl= $this->getTemplate("inputs_template.html");
        $tpl->block_tres_input = $input;
        $tpl->block_tres_input_dois = $input2;
        $tpl->block_tres_input_tres = $input3;
        $tpl->block("BLOCK_INPUT_TRES");
        $this->tplform->input = $tpl->parse();
        $this->tplform->block("BLOCK_INPUT");
    }

    public function setButton($button){
        $this->tplform->button = $button;
        $this->tplform->block("BLOCK_BUTTONS");
    }

    public function setButtonNoForm($button){
        $this->tplform->button_no = $button;
        $this->tplform->block("BLOCK_BUTTONS_NO_FORM");
    }

    public function show(){
        $this->tplform->block("BLOCK_END");
        $this->tplform->show();
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
