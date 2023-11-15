<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\form;
use app\classes\consulta;
use app\classes\controllerAbstract;
use app\classes\Mensagem;
use app\classes\footer;

class usuarioController extends controllerAbstract{

    public function index(){

        $head = new head();
        $head->show("Usuario","consulta");
    
        $consulta = new consulta();
        $buttons = array($consulta->getButton($this->url."home","Voltar"));
        $columns = array($consulta->getColumns("15","NOME CLIENTE","nm_cliente"),
                        $consulta->getColumns("2","LOJA","nr_loja"),
                        $consulta->getColumns("10","TERMINAL","nm_terminal"),
                        $consulta->getColumns("10","SISTEMA","nm_sistema"),
                        $consulta->getColumns("10","USUARIO","nm_usuario"),
                        $consulta->getColumns("10","SENHA","senha"),
                        $consulta->getColumns("10","OBSERVAÇÕES","obs"),
                        $consulta->getColumns("12.5","AÇÕES",""));
        
        $consulta->show("CONSULTA USUARIO",$this->url."usuario/manutencao",$this->url."usuario/action",$buttons,$columns,"tb_usuario","select 
        cd_usuario,tb_usuario.cd_cliente,nm_cliente,nr_loja,nm_usuario,nm_terminal,nm_sistema,senha,obs 
        from tb_usuario 
        inner join tb_cliente on tb_cliente.cd_cliente = tb_usuario.cd_cliente;");

        $footer = new footer;
        $footer->show();
    }
    public function manutencao($parameters){

        $db = new db("tb_usuario");

        $cd = "";

        if ($parameters)
            $cd = $parameters[0];

        $head = new head;
        $head->show("Manutenção Usuario");

        if ($cd)
            $dado = $db->selectOne($cd);
        else
            $dado = $db->getObject();

        $form = new form("Manutenção Usuario",$this->url."usuario/action/".$cd);

        $form->setHidden("cd",$cd);

        $Terminais = array($form->getObjectOption("Balcão","Balcão"),
                        $form->getObjectOption("Deposito","Deposito"),
                        $form->getObjectOption("Escritorio","Escritorio"),
                        $form->getObjectOption("Frente De Caixa","Frente De Caixa"),
                        $form->getObjectOption("Servidor APP","Servidor APP"),
                        $form->getObjectOption("Servidor Super","Servidor Super"),
                        $form->getObjectOption("Outro","Outro"),
        );

        $Sistemas = array($form->getObjectOption("Windows","Windows"),
                        $form->getObjectOption("Linux","Linux"),
                        $form->getObjectOption("Mac OS","Mac OS"),
                        $form->getObjectOption("TEF WEB","TEF WEB"),
                        $form->getObjectOption("Token Email","Token Email"),
                        $form->getObjectOption("Outro","Outro"),
        );

        $form->setTresInputs($form->select("Cliente","cd_cliente",$form->getOptions("tb_cliente","cd_cliente","nm_cliente"),true),
                            $form->datalist("Terminais","nm_terminal",$Terminais,$dado->nm_terminal,true),
                            $form->datalist("Sistema:","nm_sistema",$Sistemas,$dado->nm_sistema,true)
        );
        $form->setDoisInputs($form->input("nm_usuario","Nome Usuario:",$dado->nm_usuario,true),
                            $form->input("senha","Senha:",$dado->senha,true)
        );
        $form->setInputs($form->textarea("obs","Observações:",$dado->obs,false,false,"","3","12"));

        $form->setButton($form->button("Salvar","btn_submit"));
        $form->setButton($form->button("Voltar","btn_submit","button","btn btn-dark pt-2 btn-block","location.href='".$this->url."usuario'"));
        $form->show();

        $footer = new footer;
        $footer->show();
    }
    public function action($parameters){
    
        if ($parameters)
            $cddelete = $parameters[0];
        
        $cd = filter_input(INPUT_POST, 'cd');
        $cd_cliente = filter_input(INPUT_POST, 'cd_cliente');
        $nm_terminal = filter_input(INPUT_POST, 'nm_terminal');
        $nm_sistema = filter_input(INPUT_POST, 'nm_sistema');
        $nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
        $senha = filter_input(INPUT_POST, 'senha');
        $obs = filter_input(INPUT_POST, 'obs');

        $db = new db("tb_usuario");

        if($cd && $cd_cliente && $nm_terminal && $nm_usuario && $nm_usuario && $senha){
        
            $values = $db->getObject();

            $values->cd_usuario = $cd;
            $values->cd_cliente = $cd_cliente;
            $values->nm_terminal= $nm_terminal;
            $values->nm_sistema = $nm_sistema;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Criado com Sucesso"));
                header("Location: ".$this->url."usuario");
                exit;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
            }

        }
        elseif(!$cd && $cd_cliente && $nm_terminal && $nm_usuario && $nm_usuario && $senha){
            $values = $db->getObject();

            $values->cd_cliente = $cd_cliente;
            $values->nm_terminal= $nm_terminal;
            $values->nm_sistema = $nm_sistema;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $db->store($values);

            if ($retorno == true){
                mensagem::setSucesso(array("Atualizado com Sucesso"));
                header("Location: ".$this->url."usuario");
                exit;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro($Mensagems);
            }
        }
        elseif($cddelete && !$cd_cliente && !$nm_terminal && !$nm_usuario && !$nm_usuario && !$senha){
            $retorno = $db->delete($cddelete);

            if ($retorno == true){
                mensagem::setSucesso(array("Excluido com Sucesso"));
                header("Location:".$this->url."usuario");
                exit;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
            }

        }else{
            mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
            header("Location: ".$this->url."usuario/index/".$cddelete);
            exit;
        }
    }
    public function export(){
        $db = new db("tb_usuario");
        $results = $db->selectInstruction("select 
        cd_usuario,tb_usuario.cd_cliente,nm_cliente,nr_loja,nm_usuario,nm_terminal,nm_sistema,senha,obs 
        from tb_usuario 
        inner join tb_cliente on tb_cliente.cd_cliente = tb_usuario.cd_cliente;");

        if($results){

            $arquivo  = fopen('Clientes.csv', "w");
           
	        fputcsv($arquivo, array("CODIGO","CODIGO CLIENTE","NOME CLIENTE","LOJA","TERMINAL","SISTEMA","USUARIO","SENHA","OBS"));
            
            foreach ($results as $result){
                $array = array($result->cd_usuario,$result->cd_cliente,$result->nm_cliente,$result->nr_loja,$result->nm_terminal,$result->nm_sistema,$result->nm_usuario,$result->senha,$result->obs);
                fputcsv($arquivo, $array);  
                $array = [];
            }

            fclose($arquivo);

            header('Location: '.$this->url.'Clientes.csv');
        }
    }
}

