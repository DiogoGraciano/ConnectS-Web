<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\agenda;
use app\classes\controllerAbstract;
use app\classes\elements;
use app\classes\footer;
use app\models\main\agendaModel;

class agendaController extends controllerAbstract{

    public function index(){
        $head = new head();
        $head->show("Agenda","agenda","Agenda");

        $elements = new elements();

        $agenda = new agenda();
        $agenda->addButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."home'"));
        $agenda->show($this->url."agenda/manutencao/",agendaModel::getEvents(date("Y-m-d H:i:s",strtotime("-1 Year")),date("Y-m-d H:i:s",strtotime("+1 Year"))));
      
        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $cd = "";
        $dt_fim = "";
        $dt_ini = "";

        if (array_key_exists(1,$parameters)){
            $dt_fim = date("Y-m-d H:i:s",strtotime(substr(base64_decode($parameters[1]),0,34)));
            $dt_ini = date("Y-m-d H:i:s",strtotime(substr(base64_decode($parameters[0]),0,34)));
        }
        elseif (array_key_exists(0,$parameters) && !array_key_exists(1,$parameters))
            $cd = $parameters[0];
        
        $head = new head;
        $head->show("Manutenção Agenda",titulo:"Manutenção Agenda");

        $dado = agendaModel::get($cd);

        $elements = new elements();

        $form = new form($this->url."agenda/action/");

        $elements->addOption("Em Andamento","Em Andamento")->addOption("Completo","Completo");

        $status = $elements->select("Status","status ",$dado->status,true);

        $elements->setOptions("tb_funcionario","cd_funcionario","nm_funcionario");
        $funcionario = $elements->select("Funcionario","cd_funcionario",$dado->cd_funcionario,true);

        $elements->setOptions("tb_cliente","cd_cliente","nm_cliente");
        $cliente = $elements->select("Cliente","cd_cliente",$dado->cd_cliente,true);

        $form->setHidden("cd",$cd);

        $form->setInputs($elements->input("cor","Cor:",$dado->cor,false,false,"","color","form-control form-control-color"));

        $form->setTresInputs($cliente,
                            $funcionario,
                            $status               
        );

        $form->setDoisInputs($elements->input("dt_inicio","Data Inicial:",$dado->dt_inicio?:$dt_ini,true,false,"","datetime-local","form-control form-control-date"),
                            $elements->input("dt_fim","Data Final:",$dado->dt_fim?:$dt_fim,true,false,"","datetime-local","form-control form-control-date"));
        
        $form->setInputs($elements->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."agenda'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters){
            agendaModel::delete($parameters[0]);
            $this->go("agenda");
            return;
        }

        $cd_agenda  = $this->getValue('cd');
        $cd_cliente = $this->getValue('cd_cliente');
        $cd_funcionario  = $this->getValue('cd_funcionario');
        $titulo = $this->getValue('titulo');
        $dt_inicio = $this->getValue('dt_inicio');
        $dt_fim = $this->getValue('dt_fim');
        $cor = $this->getValue('cor');
        $obs = $this->getValue('obs');

        agendaModel::set($cd_cliente,$cd_funcionario,$titulo,$dt_inicio,$dt_fim,$cor,$obs,$cd_agenda);

        $this->go("agenda/manutencao/".$cd_agenda);
    }

    public function export(){
        $this->go("tabela/exportar/tb_agenda");
    }

}