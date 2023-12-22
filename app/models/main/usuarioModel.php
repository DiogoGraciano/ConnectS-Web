<?php 
namespace app\models\main;
use app\db\db;
use app\classes\mensagem;
use app\classes\modelAbstract;

class usuarioModel{

    public static function get($cd = ""){
        return modelAbstract::get("tb_usuario",$cd);
    }

    public static function set($cd_cliente,$nm_terminal,$nm_sistema,$nm_usuario,$senha,$obs,$cd = ""){

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
                return True;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($Mensagems);
                return False;
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
                return True;
            }
            else {
                $Mensagems = ($db->getError());
                mensagem::setErro($Mensagems);
                return False;
            }
        }
        else{
            mensagem::setErro(array("Erro ao excultar ação tente novamente"));
            return False;
        }
    }

    public static function delete($cd){
        modelAbstract::delete("tb_usuario",$cd);
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

            return True;
        }
        return False;
    }

}