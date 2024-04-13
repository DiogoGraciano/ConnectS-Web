<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\footer;
use app\classes\elements;
use app\classes\controllerAbstract;
use app\classes\functions;
use app\classes\filter;
use app\models\main\clienteModel;

class clienteController extends controllerAbstract{

    public function index(){

        $nm_cliente = $this->getValue("nm_cliente");
        $nr_loja = $this->getValue("nr_loja");

        $head = new head();
        $head->show("Manutenção Agenda","consulta","Cliente");

        $elements = new elements();

        $filter = new filter($this->url."cliente/index/");

        $filter->addbutton($elements->button("Buscar","buscar","submit","btn btn-primary pt-2"))
                ->addFilter(3,$elements->input("nm_cliente","Nome Cliente",$nm_cliente))
                ->addFilter(3,$elements->input("nrloja","Loja:",$nr_loja,false,false,"","number","form-control",'min="1"'));

        $filter->show();

        $consulta = new consulta();
        $consulta->addButtons($elements->button("Voltar","btn_voltar","button",
        "btn btn-dark pt-2","location.href='".$this->url."home'"))
        ->addButtons($elements->button("Exportar","btn_voltar","button",
        "btn btn-secondary pt-2","location.href='".$this->url."cliente/export'"));
        $consulta->addColumns("10","ID","cd_cliente")->addColumns("67","Nome","nm_cliente")->addColumns("10","Loja","nr_loja")->addColumns("13","Ações","");
        
        $consulta->show($this->url."cliente/manutencao",$this->url."cliente/action",clienteModel::getAll($nm_cliente,$nr_loja),"cd_cliente");
    
        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $cd="";

        if ($parameters)
            $cd = functions::decrypt($parameters[0]);

        $head = new head;
        $head->show("Manutenção Cliente",titulo:"Manutenção Cliente");

        $elements = new elements();

        $dado = clienteModel::get($cd);
        
        $form = new form($this->url."cliente/action/");

        $form->setHidden("cd",$cd);
        $form->setDoisInputs($elements->input("nome","Nome:",$dado->nm_cliente,true),
                            $elements->input("nrloja","Loja:",$dado->nr_loja,true,false,"","number","form-control",'min="1"')
        );
        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."cliente'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters){
            clienteModel::delete($parameters[0]);
            $this->go("cliente");
            return;
        }

        $cd = $this->getValue('cd');
        $nome = $this->getValue('nome');
        $nrloja = $this->getValue('nrloja');

        clienteModel::set($nome,$nrloja,$cd);

        $this->go("cliente/manutencao/".functions::encrypt($cd));
        
    }
    public function export(){
        
        if (clienteModel::export())
            $this->go('arquivos/Clientes.csv');
        else 
            $this->go("cliente");
    
    }
}