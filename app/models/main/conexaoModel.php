<?php 
namespace app\models\main;
use app\db\db;
use app\classes\mensagem;
use app\classes\modelAbstract;

class conexaoModel{

    public static function get($cd = ""){
        return modelAbstract::get("tb_conexao",$cd);
    }

    public static function set($cd_cliente,$id_conexao,$nm_terminal,$nm_programa,$nr_caixa,$nm_usuario,$senha,$obs,$cd_conexao = ""){

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
                return True;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
                return False;
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
                return True;
            }
            else {
                $erros = ($db->getError());
                mensagem::setErro(array("Erro ao execultar a ação tente novamente"));
                mensagem::addErro($erros);
                return False;
            }
        }
        else{
            mensagem::setErro(array("Erro ao excultar ação tente novamente"));
            return False;
        }
    }

    public static function delete($cd){
        modelAbstract::delete("tb_conexao",$cd);
    }

    public static function export(){
        $db = new db("tb_cliente");
        $results = $db->selectAll();

        if($results){

            $arquivo  = fopen('arquivos/Clientes.csv', "w");
           
	        fputcsv($arquivo, array("CODIGO","NOME CLIENTE","LOJA"));
            
            foreach ($results as $result){
                $array = array($result->cd_cliente,$result->nm_cliente,$result->nr_loja);
                fputcsv($arquivo, $array);  
                $array = [];
            }

            fclose($arquivo);

            return True;
        }
        return False;
    }
}