<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\form;
use app\classes\consulta;
use app\classes\mensagem;
use app\classes\footer;
use app\classes\controllerAbstract;

class clienteController extends controllerAbstract{

    public function index(){

        $head = new head();
        $head -> show("Cliente","consulta");

        $consulta = new consulta();
        $buttons = array($consulta->getButton($this->url."home","Voltar"));
        $columns = array($consulta->getColumns("10","ID","cd_cliente"),$consulta->getColumns("67","Nome","nm_cliente"),$consulta->getColumns("10","Loja","nr_loja"),$consulta->getColumns("13","Ações",""));
        $consulta->show("CONSULTA CLIENTES",$this->url."cliente/manutencao",$this->url."cliente/action",$buttons,$columns,"tb_cliente");
    
        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $db = new db("tb_cliente");

        $cd="";

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Cliente");

        if ($cd)
            $dado = $db->selectOne($cd);
        else
            $dado = $db->getObject();

        $form = new form("Manutenção Cliente",$this->url."cliente/action/".$cd);

        $form->setHidden("cd",$cd);
        $form->setDoisInputs($form->input("nome","Nome:",$dado->nm_cliente,true),
                            $form->input("nrloja","Loja:",$dado->nr_loja,true,false,"","number","form-control",'min="1"')
        );
        $form->setButton($form->button("Salvar","btn_submit"));
        $form->setButton($form->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."cliente'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        $db = new db("tb_cliente");

        $cddelete="";

        if ($parameters)
            $cddelete = $parameters[0];

        $cd = filter_input(INPUT_POST, 'cd');
        $nome = filter_input(INPUT_POST, 'nome');
        $nrloja = filter_input(INPUT_POST, 'nrloja');

        if($cd && $nome && $nrloja){
 
            $values = $db->getObject();

            $values->cd_cliente = $cd;
            $values->nm_cliente= $nome;
            $values->nr_loja = $nrloja;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Criado com Sucesso"));
                header("Location: ".$this->url."cliente/");
                exit;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
            }

        }
        elseif(!$cd && $nome && $nrloja){
            $values = $db->getObject();

            $values->nm_cliente= $nome;
            $values->nr_loja = $nrloja;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Atualizado com Sucesso"));
                header("Location: ".$this->url."cliente/");
                exit;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
            }
        }
        elseif($cddelete && !$nome && !$nrloja){

            $retorno = $db->delete($cddelete);

            if ($retorno == true){
                mensagem::setSucesso(array("Excluido com Sucesso"));
                header("Location: ".$this->url."cliente/");
                exit;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
            }

        }else{
            mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
            header("Location: ".$this->url."cliente/");
            exit;
        }
    }
    public function export(){
        $db = new db("tb_cliente");
        $results = $db->selectAll();

        if($results){

            $arquivo  = fopen('Clientes.csv', "w");
           
	        fputcsv($arquivo, array("CODIGO","NOME CLIENTE","LOJA"));
            
            foreach ($results as $result){
                $array = array($result->cd_cliente,$result->nm_cliente,$result->nr_loja);
                fputcsv($arquivo, $array);  
                $array = [];
            }

            fclose($arquivo);

            header('Location: '.$this->url.'Clientes.csv');
        }
    }
}