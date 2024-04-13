<?php 
namespace app\models\main;
use app\db\usuario;
use app\classes\mensagem;

class usuarioModel{

    public static function get($cd = ""){
        return (new usuario)->get($cd);
    }

    public static function getAll($nm_cliente="",$nm_terminal="",$nm_sistema="",$nm_usuario=""){

        $usuarios = (new usuario)->addJoin("LEFT","tb_cliente","tb_cliente.cd_cliente","tb_usuario.cd_cliente");

        if($nm_cliente){
            $usuarios->addFilter("nm_cliente","LIKE","%".$nm_cliente."%");
        }

        if($nm_terminal){
            $usuarios->addFilter("nm_terminal","LIKE","%".$nm_terminal."%");
        }

        if($nm_sistema){
            $usuarios->addFilter("nm_sistema","LIKE","%".$nm_sistema."%");
        }

        if($nm_usuario){
            $usuarios->addFilter("nm_usuario","LIKE","%".$nm_usuario."%");
        }
        
        return $usuarios->selectColumns("cd_usuario","nm_cliente","nr_loja","nm_terminal","nm_sistema","nm_usuario","senha","obs");;
    }

    public static function set($cd_cliente,$nm_terminal,$nm_sistema,$nm_usuario,$senha,$obs,$cd = ""){

        $usuario = new usuario;

        if (!clienteModel::get($cd_cliente)->cd_cliente){
            mensagem::setErro("Cliente não existe");
            return False;
        }

        if (!$nm_terminal || !$nm_sistema || !$nm_usuario || !$senha){
            mensagem::setErro("Um dos campos obrigatorios *Nome do Terminal* ou *Nome do Sistema* ou *Nome do Usuario* ou *Senha* não foi informado");
            return False;
        }

        if($cd && $cd_cliente && $nm_terminal && $nm_sistema && $nm_usuario && $senha){
        
            $values = $usuario->getObject();

            $values->cd_usuario = $cd;
            $values->cd_cliente = $cd_cliente;
            $values->nm_terminal= $nm_terminal;
            $values->nm_sistema = $nm_sistema;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $usuario->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $usuario->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd && $cd_cliente && $nm_terminal && $nm_usuario && $nm_usuario && $senha){
            $values = $usuario->getObject();

            $values->cd_cliente = $cd_cliente;
            $values->nm_terminal= $nm_terminal;
            $values->nm_sistema = $nm_sistema;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $usuario->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $usuario->getLastId();
            }
            else {
                mensagem::setErro("Erro ao excultar ação tente novamente");
                return False;
            }
        }
        else{
            mensagem::setErro("Erro ao excultar ação tente novamente");
            return False;
        }
    }

    public static function delete($cd){
        (new usuario)->delete($cd);
    }

    public function export(){
        $usuario = new usuario;
        $results = $usuario
        ->addJoin("INNER","tb_cliente","tb_cliente.cd_cliente","tb_usuario.cd_cliente")
        ->selectColumns("cd_usuario","tb_usuario.cd_cliente","nm_cliente","nr_loja",
                        "nm_usuario","nm_terminal","nm_sistema","senha","obs");

        if($results){

            $arquivo  = fopen('Clientes.csv', "w");
           
	        fputcsv($arquivo, array("CODIGO","CODIGO CLIENTE","NOME CLIENTE","LOJA","TERMINAL","SISTEMA","USUARIO","SENHA","OBS"));
            
            foreach ($results as $result){
                $array = array($result->cd_usuario,$result->cd_cliente,$result->nm_cliente,$result->nr_loja,$result->nm_terminal,$result->nm_sistema,$result->nm_usuario,$result->senha,$result->obs);
                fputcsv($arquivo, $array);  
                $array = [];
            }

            fclose($arquivo);

            return True;
        }
        return False;
    }

}