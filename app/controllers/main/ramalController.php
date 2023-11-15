<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\Mensagem;
use app\classes\footer;

class ramalController extends controllerAbstract{

    public function index(){
        $head = new head();
        $head -> show("Ramal","consulta");
    
        $consulta = new consulta();
        $buttons = array($consulta->getButton($this->url,"Voltar"));
        $columns = array($consulta->getColumns("20","FUNCIONARIO","nm_funcionario"),
                        $consulta->getColumns("2","RAMAL","nr_ramal"),
                        $consulta->getColumns("10","TELEFONE","nr_telefone"),
                        $consulta->getColumns("10","IP","nr_ip"),
                        $consulta->getColumns("10","USUARIO","nm_usuario"),
                        $consulta->getColumns("10","SENHA","senha"),
                        $consulta->getColumns("10","OBSERVAÇÕES","obs"),
                        $consulta->getColumns("12.5","AÇÕES",""));
        
        $consulta->show("CONSULTA RAMAL",$this->url."ramal/manutencao",$this->url."ramal/action",$buttons,$columns,"tb_ramal");
  
        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){
        $db = new db("tb_ramal");

        $cd = "";

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Ramal");

        if ($cd)
            $dado = $db->selectOne($cd);
        else
            $dado = $db->getObject();

        $form = new form("Manutenção Ramal",$this->url."ramal/action/".$cd);

        $form->setHidden("cd_ramal",$cd);

        $form->setDoisInputs($form->input("nm_funcionario","Funcionario:",$dado->nm_funcionario,true),
                            $form->input("nr_ramal","Ramal:",$dado->nr_ramal,true,"","number","form-control",'min="1"'),            
        );
        $form->setDoisInputs($form->input("nr_telefone","Telefone:",$dado->nr_telefone),
                            $form->input("nr_ip","Numero IP:",$dado->nr_ip)
        );
        $form->setDoisInputs($form->input("nm_usuario","Nome Usuario:",$dado->nm_usuario),
                            $form->input("senha","Senha:",$dado->senha)
        );
        $form->setInputs($form->textarea("obs","Observações:",$dado->obs,false,"","3","12"));

        $form->setButton($form->button("Salvar","btn_submit"));
        $form->setButton($form->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."ramal'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters)
            $cddelete = $parameters[0];

        $cd_ramal = filter_input(INPUT_POST, 'cd_ramal');
        $nr_ramal = filter_input(INPUT_POST, 'nr_ramal');
        $nm_funcionario = filter_input(INPUT_POST, 'nm_funcionario');
        $nr_telefone = filter_input(INPUT_POST, 'nr_telefone');
        $nr_ip = filter_input(INPUT_POST, 'nr_ip');
        $nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
        $senha = filter_input(INPUT_POST, 'senha');
        $obs = filter_input(INPUT_POST, 'obs');

        $db = new db("tb_ramal");

        if($cd_ramal && $nr_ramal){
   
        $values = $db->getObject();

        $values->cd_ramal = $cd_ramal;
        $values->nr_ramal = $nr_ramal;
        $values->nm_funcionario = $nm_funcionario;
        $values->nr_telefone= $nr_telefone;
        $values->nr_ip = $nr_ip;
        $values->nm_usuario = $nm_usuario;
        $values->senha = $senha;
        $values->obs= $obs;

        if ($values)
            $retorno = $db->store($values);

        if ($retorno == true){
            mensagem::setSucesso(array("Atualizado com Sucesso"));
            header("Location: ".$this->url."ramal/manutencao/".$cd_ramal);
            exit;
        }
        else {
            $Mensagems = ($db->getError());
            mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
            mensagem::addErro($Mensagems);
            header("Location: ".$this->url."ramal/manutencao/".$cd_ramal);
        }

        }
        elseif(!$cd_ramal && $nr_ramal){
            $values = $db->getObject();

            $values->cd_ramal = $cd_ramal;
            $values->nr_ramal = $nr_ramal;
            $values->nm_funcionario = $nm_funcionario;
            $values->nr_telefone= $nr_telefone;
            $values->nr_ip = $nr_ip;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Adicionado com Sucesso"));
                header("Location: ".$this->url."ramal/manutencao/");
                exit;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
                header("Location: ".$this->url."ramal/manutencao/");
            }
        }
        elseif($cddelete && !$cd_ramal && !$nr_ramal){
            $retorno = $db->delete($cddelete);

            if ($retorno == true){
                mensagem::setSucesso(array("Excluido com Sucesso"));
                header("Location: ".$this->url."ramal/index/");
                exit;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
                header("Location: ".$this->url."ramal/index/");
            }

        }else{
            mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
            header("Location: ".$this->url."ramal/index/".$cddelete);
            exit;
        }
    }   
}