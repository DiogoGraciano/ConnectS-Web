<?php 
namespace app\models\main;
use app\db\db;
use app\classes\mensagem;
use app\classes\modelAbstract;

class clienteModel{

    public static function get($cd = ""){
        modelAbstract::get("tb_cliente",$cd);
    }

    public static function set($nome,$nrloja,$cd = ""){

        $db = new db("tb_cliente");

        if($cd && $nome && $nrloja){
 
            $values = $db->getObject();

            $values->cd_cliente = $cd;
            $values->nm_cliente= $nome;
            $values->nr_loja = $nrloja;

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
        elseif(!$cd && $nome && $nrloja){
            $values = $db->getObject();

            $values->nm_cliente= $nome;
            $values->nr_loja = $nrloja;

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
        modelAbstract::delete("tb_cliente",$cd);
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