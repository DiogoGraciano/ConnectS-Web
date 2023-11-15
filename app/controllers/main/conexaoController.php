<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\mensagem;
use app\classes\footer;

class conexaoController extends controllerAbstract{

    public function index(){
        $head = new head();
        $head -> show("Conexão","consulta");

        $consulta = new consulta();
        $buttons = array($consulta->getButton($this->url."home","Voltar"));
        $columns = array($consulta->getColumns("15","NOME CLIENTE","nm_cliente"),
                        $consulta->getColumns("2","LOJA","nr_loja"),
                        $consulta->getColumns("10","CONEXÃO","id_conexao"),
                        $consulta->getColumns("10","TERMINAL","nm_terminal"),
                        $consulta->getColumns("2","CAIXA","nr_caixa"),
                        $consulta->getColumns("10","PROGRAMA","nm_programa"),
                        $consulta->getColumns("10","USUARIO","nm_usuario"),
                        $consulta->getColumns("10","SENHA","senha"),
                        $consulta->getColumns("10","OBSERVAÇÕES","obs"),
                        $consulta->getColumns("12.5","AÇÕES",""));
        
        $consulta->show("CONSULTA CONEXÃO",$this->url."conexao/manutencao",$this->url."conexao/action",$buttons,$columns,"tb_conexao","select cd_conexao,
        tb_conexao.cd_cliente,nm_cliente,nr_loja,id_conexao,nm_terminal,nr_caixa,nm_programa,nm_usuario,senha,obs 
        from tb_conexao 
        inner join tb_cliente on tb_cliente.cd_cliente = tb_conexao.cd_cliente");

        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $cd = "";

        $db = new db("tb_conexao");

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Conexão");

        if ($cd)
            $dado = $db->selectOne($cd);
        else
            $dado = $db->getObject();

        $form = new form("Manutenção Conexão",$this->url."conexao/action/".$cd);

        $form->setHidden("cd",$cd);

        $Terminais = array($form->getObjectOption("Balcão","Balcão"),
                        $form->getObjectOption("Deposito","Deposito"),
                        $form->getObjectOption("Escritorio","Escritorio"),
                        $form->getObjectOption("Frente De Caixa","Frente De Caixa"),
                        $form->getObjectOption("Servidor APP","Servidor APP"),
                        $form->getObjectOption("Servidor Super","Servidor Super")
        );

        $Programas = array($form->getObjectOption("Anydesk","Anydesk"),
                        $form->getObjectOption("Teamviwer","Teamviwer"),
                        $form->getObjectOption("NetSuporte","NetSuporte"),
                        $form->getObjectOption("Ruskdesk","Ruskdesk"),
                        $form->getObjectOption("WTS","WTS"),
                        $form->getObjectOption("Radmin","Radmin"),
                        $form->getObjectOption("VNC","VNC")
        );

        $form->setDoisInputs($form->input("id_conexao","Conexão:",$dado->id_conexao,true),      
                            $form->input("nr_caixa","Caixa:",$dado->nr_caixa,false,"","number","form-control",'min="1"')
        );
        $form->setTresInputs($form->select("Cliente","cd_cliente",$form->getOptions("tb_cliente","cd_cliente","nm_cliente"),$dado->cd_cliente,true),
                            $form->datalist("Terminais","nm_terminal",$Terminais,$dado->nm_terminal,true),
                            $form->datalist("Programas","nm_programa",$Programas,$dado->nm_programa,true)
        );
        $form->setDoisInputs($form->input("nm_usuario","Nome Usuario:",$dado->nm_usuario),
                            $form->input("senha","Senha:",$dado->senha)
        );
        $form->setInputs($form->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($form->button("Salvar","btn_submit"));
        $form->setButton($form->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."conexao'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){

        if ($parameters)
            $cddelete = $parameters[0];

        $cd_conexao = filter_input(INPUT_POST, 'cd');
        $cd_cliente = filter_input(INPUT_POST, 'cd_cliente');
        $id_conexao = filter_input(INPUT_POST, 'id_conexao');
        $nm_terminal = filter_input(INPUT_POST, 'nm_terminal');
        $nr_caixa = filter_input(INPUT_POST, 'nr_caixa');
        $nm_programa = filter_input(INPUT_POST, 'nm_programa');
        $nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
        $senha = filter_input(INPUT_POST, 'senha');
        $obs = filter_input(INPUT_POST, 'obs');

        $db = new db("tb_conexao");

        if($cd_conexao && $cd_cliente && $id_conexao && $nm_terminal && $nm_programa){
        
            $values = $db->getObject();

            $values->cd_conexao = $cd_conexao;
            $values->cd_cliente = $cd_cliente;
            $values->id_conexao = $id_conexao;
            $values->nm_terminal= $nm_terminal;
            $values->nm_programa = $nm_programa;
            $values->nr_caixa = $nr_caixa;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Atualizado com Sucesso"));
                header("Location: ".$this->url."conexao/manutencao/".$cd_conexao);
                exit;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
                header("Location: ".$this->url."conexao/manutencao/".$cd_conexao);
                exit;
            }

        }
        elseif(!$cd_conexao && $cd_cliente && $id_conexao && $nm_terminal && $nm_programa){
            $values = $db->getObject();

            $values->cd_cliente = $cd_cliente;
            $values->id_conexao = $id_conexao;
            $values->nm_terminal= $nm_terminal;
            $values->nm_programa = $nm_programa;
            $values->nr_caixa = $nr_caixa;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Criado com Sucesso"));
                header("Location: ".$this->url."conexao/manutencao");
                exit;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
                header("Location: ".$this->url."conexao/manutencao");
                exit;
            }
        }
        elseif($cddelete && !$cd_cliente && !$id_conexao && !$nm_terminal && !$nm_programa){
            $retorno = $db->delete($cddelete);

            if ($retorno == true){
                mensagem::setSucesso(array("Excluido com Sucesso"));
                header("Location: ".$this->url."conexao/index");
                exit;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
                header("Location: ".$this->url."conexao/index");
                exit;
            }

        }else{
            mensagem::setErro(array("Erro ao excultar ação tente novamente"));
            header("Location: ".$this->url."conexao/index");
            exit;
        }
    }

}