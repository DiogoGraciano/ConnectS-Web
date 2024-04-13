<?php 
namespace app\controllers\main;

use app\classes\head;
use app\classes\form;
use app\classes\consulta;
use app\classes\footer;
use app\classes\elements;
use app\classes\controllerAbstract;
use app\classes\functions;
use app\models\main\loginApiModel;

class cadastroApiController extends controllerAbstract{

    /**
     * Método principal para exibir a página inicial do cadastro da API.
     */
    public function index(){

        $head = new head();
        $head->show("Usuarios da API","consulta","Usuarios da API");

        $elements = new elements();

        $consulta = new consulta();
        $consulta->addButtons($elements->button("Voltar","btn_voltar","button",
        "btn btn-dark pt-2","location.href='".$this->url."home'"));

        $consulta->addColumns("10","Id","cd_cadastro")->addColumns("67","Nome","nm_usuario")->addColumns("13","Ações","");
        
        $consulta->show($this->url."cadastroApi/manutencao",$this->url."cadastroApi/action",loginApiModel::getAll(),"cd_login_api");
    
        $footer = new footer;
        $footer->show();
    }

    /**
     * Método para manutenção do cadastro de usuários da API.
     *
     * @param array $parameters Parâmetros recebidos pela URL.
     */
    public function manutencao(array $parameters){

        $cd="";

        if ($parameters){
            $cd = functions::decrypt($parameters[0]);
        }

        $head = new head;
        $head->show("Cadastro de Usuarios da API",titulo:"Cadastro de Usuarios da API");

        $elements = new elements();

        $dado = loginApiModel::get($cd);
        
        $form = new form($this->url."cadastroApi/action/");

        $form->setHidden("cd_login_api",$cd);
        $form->setDoisInputs($elements->input("nm_usuario","Usuario:",$dado->nm_usuario,true),
                            $elements->input("senha","Senha:","",false,false,"","number","form-control",'min="1"')
        );
        $form->setButton($elements->button("Salvar","btn_submit"));
        $form->setButton($elements->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."cadastroApi'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }

    /**
     * Método para realizar ações no cadastro de usuários da API.
     *
     * @param array $parameters Parâmetros recebidos pela URL.
     */
    public function action(array $parameters){

        if ($parameters){
            loginApiModel::delete(functions::decrypt($parameters[0]));
            $this->go("cadastroApi");
            return;
        }

        $cd_login_api = $this->getValue('cd_login_api');
        $nm_usuario = $this->getValue('nm_usuario');
        $senha = $this->getValue('senha');

        loginApiModel::set($nm_usuario,$senha,$cd_login_api);

        $this->go("cadastroApi/manutencao/".functions::encrypt($cd_login_api));
        
    }
}
