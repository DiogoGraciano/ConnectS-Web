<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\footer;
use app\classes\elements;
use app\models\main\ramalModel;

class ramalController extends controllerAbstract{

    public function index(){
        $head = new head();
        $head->show("Ramal","consulta","Consulta Ramal");
    
        $consulta = new consulta();

        $elements = new elements();

        $consulta->addButtons($elements->button("Voltar","btn_voltar","button",
        "btn btn-dark pt-2","location.href='".$this->url."home'"))
        ->addButtons($elements->button("Exportar","btn_voltar","button",
        "btn btn-secondary pt-2","location.href='".$this->url."cliente/export'"));
        $consulta->addColumns("20","FUNCIONARIO","nm_funcionario")
                    ->addColumns("2","RAMAL","nr_ramal")
                    ->addColumns("10","TELEFONE","nr_telefone")
                    ->addColumns("10","IP","nr_ip")
                    ->addColumns("10","USUARIO","nm_usuario")
                    ->addColumns("10","SENHA","senha")
                    ->addColumns("10","OBSERVAÇÕES","obs")
                    ->addColumns("12.5","AÇÕES","");

        $consulta->show($this->url."ramal/manutencao",$this->url."ramal/action",ramalModel::getAll());
  
        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){
    
        $cd = "";

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Ramal",titulo:"Manutenção Ramal");

        $elements = new elements();

        $dado = ramalModel::get($cd);

        $form = new form("Manutenção Ramal",$this->url."ramal/action/".$cd);

        $form->setHidden("cd_ramal",$cd);

        $form->setDoisInputs($elements->input("nm_funcionario","Funcionario:",$dado->nm_funcionario,true),
                            $elements->input("nr_ramal","Ramal:",$dado->nr_ramal,true,false,"","number","form-control",'min="1"'),            
        );
        $form->setDoisInputs($elements->input("nr_telefone","Telefone:",$dado->nr_telefone),
                            $elements->input("nr_ip","Numero IP:",$dado->nr_ip)
        );
        $form->setDoisInputs($elements->input("nm_usuario","Nome Usuario:",$dado->nm_usuario),
                            $elements->input("senha","Senha:",$dado->senha)
        );
        $form->setInputs($elements->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."ramal'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters){
            ramalModel::delete($parameters[0]);
            $this->go("ramal");
            return;
        }

        $cd_ramal = $this->getValue('cd_ramal');
        $nr_ramal = $this->getValue('nr_ramal');
        $nm_funcionario = $this->getValue('nm_funcionario');
        $nr_telefone = $this->getValue('nr_telefone');
        $nr_ip = $this->getValue('nr_ip');
        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');
        $obs = $this->getValue('obs');

        ramalModel::set($nr_ramal,$nm_funcionario,$nr_telefone,$nr_ip,$nm_usuario,$senha,$obs,$cd_ramal);
        $this->go("ramal/manutencao".$cd_ramal);
    }   

    public function export(){
        $this->go("tabela/exportar/tb_ramal");
    }
}