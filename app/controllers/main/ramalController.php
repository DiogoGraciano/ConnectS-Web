<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\footer;
use app\models\main\ramalModel;

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
    
        $cd = "";

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Ramal");

        $dado = ramalModel::get($cd);

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
        $form->setInputs($form->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($form->button("Salvar","btn_submit"));
        $form->setButton($form->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."ramal'"));
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