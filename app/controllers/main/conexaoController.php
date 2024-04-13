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
use app\models\main\conexaoModel;

class conexaoController extends controllerAbstract{

    public function index(){

        $nm_cliente = $this->getValue("nm_cliente");
        $nm_terminal = $this->getValue("nm_terminal");
        $nm_programa = $this->getValue("nm_programa");
        $nm_usuario = $this->getValue("nm_usuario");

        $head = new head();
        $head -> show("Conexão","consulta","Conexão");

        $elements = new elements();

        $filter = new filter($this->url."conexao/index/");

        $filter->addbutton($elements->button("Buscar","buscar","submit","btn btn-primary pt-2"))
                ->addFilter(3,$elements->input("nm_cliente","Nome Cliente",$nm_cliente))
                ->addFilter(3,$elements->input("nm_terminal","Terminal",$nm_terminal))
                ->addFilter(3,$elements->input("nm_programa","Sistema",$nm_programa))
                ->addFilter(3,$elements->input("nm_usuario","Usuario",$nm_usuario));

        $filter->show();
        
        $consulta = new consulta();
        $consulta->addButtons($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2","location.href='".$this->url."home'"))
        ->addButtons($elements->button("Exportar","btn_voltar","button",
        "btn btn-secondary pt-2","location.href='".$this->url."conexao/export'"));

        $consulta->addColumns("1","ID","cd_cliente")
                ->addColumns("15","NOME CLIENTE","nm_cliente")
                ->addColumns("2","LOJA","nr_loja")
                ->addColumns("10","CONEXÃO","id_conexao")
                ->addColumns("10","TERMINAL","nm_terminal")
                ->addColumns("2","CAIXA","nr_caixa")
                ->addColumns("10","PROGRAMA","nm_programa")
                ->addColumns("10","USUARIO","nm_usuario")
                ->addColumns("10","SENHA","senha")
                ->addColumns("10","OBSERVAÇÕES","obs")
                ->addColumns("12.5","AÇÕES","");

        $consulta->show($this->url."conexao/manutencao",$this->url."conexao/action",conexaoModel::getAll($nm_cliente,$nm_terminal,$nm_programa,$nm_usuario),"cd_conexao");

        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $cd = "";

        if ($parameters)
            $cd = functions::decrypt($parameters[0]);

        $head = new head;
        $head->show("Manutenção Conexão",titulo:"Manutenção Conexão");

        $dado = conexaoModel::get($cd);

        $elements = new elements();

        $form = new form($this->url."conexao/action/");

        $form->setHidden("cd",$cd);

        $elements->addOption("Balcão","Balcão")
                ->addOption("Deposito","Deposito")
                ->addOption("Escritorio","Escritorio")
                ->addOption("Frente De Caixa","Frente De Caixa")
                ->addOption("Servidor APP","Servidor APP")
                ->addOption("Servidor Super","Servidor Super");

        $terminais = $elements->datalist("Terminais","nm_terminal",$dado->nm_terminal,true);
       
        $elements->addOption("Anydesk","Anydesk")
                ->addOption("Teamviwer","Teamviwer")
                ->addOption("NetSuporte","NetSuporte")
                ->addOption("Ruskdesk","Ruskdesk")
                ->addOption("WTS","WTS")
                ->addOption("Radmin","Radmin")
                ->addOption("VNC","VNC");

        $programas = $elements->datalist("Programas","nm_programa",$dado->nm_programa,true);

        $elements->setOptions("tb_cliente","cd_cliente","nm_cliente");
        $cliente = $elements->select("Cliente","cd_cliente",$dado->cd_cliente);
                
        $form->setDoisInputs($elements->input("id_conexao","Conexão:",$dado->id_conexao,true),      
                            $elements->input("nr_caixa","Caixa:",$dado->nr_caixa,false,false,"","number","form-control",'min="1"')
        );
        $form->setTresInputs($cliente,$terminais,$programas);
        $form->setDoisInputs($elements->input("nm_usuario","Nome Usuario:",$dado->nm_usuario),
                            $elements->input("senha","Senha:",$dado->senha)
        );
        $form->setInputs($elements->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."conexao'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters){
            conexaoModel::delete(functions::decrypt($parameters[0]));
            $this->go("conexao");
            return;
        }

        $cd_conexao = $this->getValue('cd');
        $cd_cliente = $this->getValue('cd_cliente');
        $id_conexao = $this->getValue('id_conexao');
        $nm_terminal = $this->getValue('nm_terminal');
        $nr_caixa = $this->getValue('nr_caixa');
        $nm_programa = $this->getValue('nm_programa');
        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');
        $obs = $this->getValue('obs');

        conexaoModel::set($cd_cliente,$id_conexao,$nm_terminal,$nm_programa,$nr_caixa,$nm_usuario,$senha,$obs,$cd_conexao);

        $this->go("conexao/manutencao/".$cd_conexao);
    }

    public function export(){
        conexaoModel::export();
    }

}