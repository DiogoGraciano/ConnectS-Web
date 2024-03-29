<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\footer;
use app\classes\elements;
use app\classes\functions;
use app\models\main\usuarioModel;

class usuarioController extends controllerAbstract{

    public function index(){

        $head = new head();
        $head->show("Usuario","consulta","Consulta Usuario");

        $elements = new elements();
    
        $consulta = new consulta();
        $consulta->addButtons($elements->button("Voltar","btn_voltar","button","btn btn-dark pt-2","location.href='".$this->url."home'"))
                ->addButtons($elements->button("Exportar","btn_voltar","button","btn btn-secondary pt-2","location.href='".$this->url."cliente/export'"));

        $consulta->addColumns("15","NOME CLIENTE","nm_cliente")
                ->addColumns("2","LOJA","nr_loja")
                ->addColumns("10","TERMINAL","nm_terminal")
                ->addColumns("10","SISTEMA","nm_sistema")
                ->addColumns("10","USUARIO","nm_usuario")
                ->addColumns("10","SENHA","senha")
                ->addColumns("10","OBSERVAÇÕES","obs")
                ->addColumns("12.5","AÇÕES","");
        
        $consulta->show($this->url."usuario/manutencao",$this->url."usuario/action",usuarioModel::getAll(),"cd_usuario");

        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $cd = "";

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Usuario");

        $dado = usuarioModel::get($cd);

        $elements = new elements();

        $form = new form($this->url."usuario/action/");

        $form->setHidden("cd",$cd);

        $elements->setOptions("tb_cliente","cd_cliente","nm_cliente");
        $cliente = $elements->select("Cliente","cd_cliente");

        $elements->addOption("Balcão","Balcão")
                ->addOption("Deposito","Deposito")
                ->addOption("Escritorio","Escritorio")
                ->addOption("Frente De Caixa","Frente De Caixa")
                ->addOption("Servidor APP","Servidor APP")
                ->addOption("Servidor Super","Servidor Super")
                ->addOption("Outro","Outro");

        $terminais = $elements->datalist("Terminais","nm_terminal",$dado->nm_terminal,true);
    
        $elements->addOption("Windows","Windows")
                            ->addOption("Linux","Linux")
                            ->addOption("Mac OS","Mac OS")
                            ->addOption("TEF WEB","TEF WEB")
                            ->addOption("Token Email","Token Email")
                            ->addOption("Outro","Outro");

        $sistemas =$elements->datalist("Sistema:","nm_sistema",$dado->nm_sistema,true);

        $form->setTresInputs($cliente,
                            $terminais
                            ,$sistemas             
        );
        $form->setDoisInputs($elements->input("nm_usuario","Nome Usuario:",$dado->nm_usuario,true),
                            $elements->input("senha","Senha:",$dado->senha,true)
        );
        $form->setInputs($elements->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."usuario'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){
    
        if ($parameters){
            usuarioModel::delete(functions::encrypt($parameters[0]));
            $this->go("usuario");
            return;
        }
        
        $cd = $this->getValue('cd');
        $cd_cliente = $this->getValue('cd_cliente');
        $nm_terminal = $this->getValue('nm_terminal');
        $nm_sistema = $this->getValue('nm_sistema');
        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');
        $obs = $this->getValue('obs');
        
        usuarioModel::set($cd_cliente,$nm_terminal,$nm_sistema,$nm_usuario,$senha,$obs,$cd);

        $this->go("usuario");
    }

    public function export(){
        $this->go("tabela/exportar/tb_usuario");
    }
    
}

