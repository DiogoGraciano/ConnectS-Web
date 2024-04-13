<?php 
namespace app\models\main;
use app\db\cliente;
use app\classes\mensagem;

class clienteModel{

    public static function get($cd = ""){
        return (new cliente)->get($cd);
    }

    public static function getAll($nm_cliente,$nr_loja){
        $cliente = new cliente;

        if($nm_cliente){
            $cliente->addFilter("nm_cliente","LIKE","%".$nm_cliente."%");
        }

        if($nr_loja){
            $cliente->addFilter("nr_loja","=",$nr_loja);
        }

        return $cliente->selectAll();
    }

    public static function set($nome,$nrloja,$cd = ""){

        $cliente = new cliente;

        if($cd && $nome && $nrloja){
 
            $values = $cliente->getObject();

            $values->cd_cliente = $cd;
            $values->nm_cliente= $nome;
            $values->nr_loja = $nrloja;

            if ($values)
                $retorno = $cliente->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $cliente->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd && $nome && $nrloja){
            $values = $cliente->getObject();

            $values->nm_cliente= $nome;
            $values->nr_loja = $nrloja;

            if ($values)
                $retorno = $cliente->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $cliente->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }
        }
        else{
            mensagem::setErro("Erro ao excultar ação tente novamente");
            return False;
        }
    }

    public static function delete($cd){
        $retorno = (new cliente)->delete($cd);

        if ($retorno == true){
            mensagem::setSucesso("Deletado com Sucesso");
            return True;
        }

        return False;
    }

    public static function export(){
        $cliente = new cliente;
        $results = $cliente->selectAll();

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