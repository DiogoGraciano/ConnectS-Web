<?php 
namespace app\controllers\main;
use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\footer;
use app\classes\elements;
use app\classes\controllerAbstract;
use app\classes\functions;
use app\models\main\loginModel;

class cadastroController extends controllerAbstract{

    public function index(){

        $head = new head();
        $head->show("Usuarios do Sistema","consulta","Usuarios do Sistema");

        $elements = new elements();

        $consulta = new consulta();
        $consulta->addButtons($elements->button("Voltar","btn_voltar","button",
        "btn btn-dark pt-2","location.href='".$this->url."home'"));

        $consulta->addColumns("10","ID","cd_cadastro")->addColumns("67","Nome","nm_usuario")->addColumns("13","Ações","");
        
        $consulta->show($this->url."cadastro/manutencao",$this->url."cadastro/action",loginModel::getAll(),"cd_login");
    
        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $cd="";

        if ($parameters){
            $cd = functions::decrypt($parameters[0]);
        }

        $head = new head;
        $head->show("Cadastro de Usuarios do Sistema",titulo:"Cadastro de Usuarios do Sistema");

        $elements = new elements();

        $dado = loginModel::get($cd);
        
        $form = new form($this->url."cadastro/action/");

        $form->setHidden("cd_login",$cd);
        $form->setDoisInputs($elements->input("nm_usuario","Usuario:",$dado->nm_usuario,true),
                            $elements->input("senha","Senha:","",false,false,"","number","form-control",'min="1"')
        );
        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."cadastro'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters){
            loginModel::delete(functions::decrypt($parameters[0]));
            $this->go("cadastro");
            return;
        }

        $cd_login = $this->getValue('cd_login');
        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');

        loginModel::set($nm_usuario,$senha,$cd_login);

        $this->go("cadastro/manutencao/".functions::encrypt($cd_login));
        
    }
}