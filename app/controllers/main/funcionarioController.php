<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\footer;
use app\classes\elements;
use app\classes\functions;
use app\classes\filter;
use app\models\main\funcionarioModel;

class funcionarioController extends controllerAbstract{

    /**
     * Método principal para exibir a página inicial de consulta de funcionários.
     */
    public function index(){
        $nm_funcionario = $this->getValue("nm_funcionario");
        $nr_ramal = $this->getValue("nr_ramal");
        $nr_telefone = $this->getValue("nr_telefone");
        $nr_ip = $this->getValue("nr_ip");
        $nm_usuario = $this->getValue("nm_usuario");

        $head = new head();
        $head->show("funcionario","consulta","Consulta funcionario");
    
        $consulta = new consulta();

        $elements = new elements();

        $filter = new filter($this->url."funcionario/index/");

        $filter->addbutton($elements->button("Buscar","buscar","submit","btn btn-primary pt-2"))
                ->addFilter(3,$elements->input("nm_funcionario","Nome Funcionario",$nm_funcionario))
                ->addFilter(3,$elements->input("nr_ramal","Numero Ramal:",$nr_ramal,false,false,"","number","form-control",'min="1"'))
                ->addFilter(3,$elements->input("nr_telefone","Telefone",$nr_telefone))
                ->addFilter(3,$elements->input("nr_ip","Numero de IP",$nr_ip))
                ->addLinha()
                ->addFilter(3,$elements->input("nm_usuario","Nome Usuario",$nm_usuario))
                ->show();

        $consulta->addButtons($elements->button("Voltar","btn_voltar","button",
        "btn btn-dark pt-2","location.href='".$this->url."home'"))
        ->addButtons($elements->button("Exportar","btn_voltar","button",
        "btn btn-secondary pt-2","location.href='".$this->url."cliente/export'"));
        $consulta->addColumns("1","ID","cd_funcionario")
                    ->addColumns("20","FUNCIONARIO","nm_funcionario")
                    ->addColumns("2","RAMAL","nr_ramal")
                    ->addColumns("10","TELEFONE","nr_telefone")
                    ->addColumns("10","IP","nr_ip")
                    ->addColumns("10","USUARIO","nm_usuario")
                    ->addColumns("10","SENHA","senha")
                    ->addColumns("10","OBSERVAÇÕES","obs")
                    ->addColumns("12.5","AÇÕES","");

        $consulta->show($this->url."funcionario/manutencao/",$this->url."funcionario/action/",funcionarioModel::getAll($nm_funcionario,$nr_ramal,$nr_telefone,$nr_ip,$nm_usuario),"cd_funcionario");
  
        $footer = new footer;
        $footer->show();
    }

     /**
     * Método para manutenção de um funcionário específico.
     *
     * @param array $parameters Parâmetros recebidos pela URL.
     */
    public function manutencao(array $parameters){
    
        $cd = "";

        if ($parameters)
            $cd = functions::decrypt($parameters[0]);

        $head = new head;
        $head->show("Manutenção funcionario",titulo:"Manutenção funcionario");

        $elements = new elements();

        $dado = funcionarioModel::get($cd);

        $form = new form($this->url."funcionario/action/");

        $form->setHidden("cd_funcionario",$cd);

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
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."funcionario'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }

     /**
     * Método para realizar ações no cadastro de funcionários.
     *
     * @param array $parameters Parâmetros recebidos pela URL.
     */
    public function action(array $parameters){

        if ($parameters){
            funcionarioModel::delete(functions::decrypt($parameters[0]));
            $this->go("funcionario");
            return;
        }

        $cd_funcionario = $this->getValue('cd_funcionario');
        $nr_ramal = $this->getValue('nr_ramal');
        $nm_funcionario = $this->getValue('nm_funcionario');
        $nr_telefone = $this->getValue('nr_telefone');
        $nr_ip = $this->getValue('nr_ip');
        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');
        $obs = $this->getValue('obs');

        funcionarioModel::set($nr_ramal,$nm_funcionario,$nr_telefone,$nr_ip,$nm_usuario,$senha,$obs,$cd_funcionario);

        $this->go("funcionario/manutencao/".functions::encrypt($cd_funcionario));
    }   

    /**
     * Método para exportar os dados dos funcionários para um arquivo CSV.
    */
    public function export(){
        $this->go("tabela/exportar/tb_funcionario");
    }
}