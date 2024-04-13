<?php 
namespace app\models\main;
use app\db\conexao;
use app\classes\mensagem;

class conexaoModel{

    public static function get($cd = ""){
        return (new conexao)->get($cd);
    }

    public static function getAll(){
        return (new conexao)
        ->addJoin("LEFT","tb_cliente","tb_cliente.cd_cliente","tb_conexao.cd_cliente")
        ->selectColumns("cd_conexao","nm_cliente","nr_loja","id_conexao","nm_terminal",
                    "nr_caixa","nm_programa","nm_usuario","senha","obs");
    }

    public static function set($cd_cliente,$id_conexao,$nm_terminal,$nm_programa,$nr_caixa,$nm_usuario,$senha,$obs,$cd_conexao = ""){

        $conexao = (new conexao);

        if($cd_conexao && $cd_cliente && $id_conexao && $nm_terminal && $nm_programa){
        
            $values = $conexao->getObject();

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
                $retorno = $conexao->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $conexao->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd_conexao && $cd_cliente && $id_conexao && $nm_terminal && $nm_programa){
            $values = $conexao->getObject();

            $values->cd_cliente = $cd_cliente;
            $values->id_conexao = $id_conexao;
            $values->nm_terminal= $nm_terminal;
            $values->nm_programa = $nm_programa;
            $values->nr_caixa = $nr_caixa;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            if ($values)
                $retorno = $conexao->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $conexao->getLastId();
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
        $retorno = (new conexao)->delete($cd);

        if ($retorno == true){
            mensagem::setSucesso("Deletado com Sucesso");
            return True;
        }

        mensagem::setErro("Falha ao deletar, tente novamente");
        return False;
    }

    public static function export(){

        $results = self::getAll();

        if($results){

            $arquivo  = fopen('arquivos/conexao.csv', "w");
           
	        fputcsv($arquivo, array("CODIGO","NOME CLIENTE","LOJA","CONEXÃO","TERMINAL","CAIXA","PROGRAMA",
            "USUARIO","SENHA","OBSERVAÇÕES"
            ));
            
            foreach ($results as $result){
                fputcsv($arquivo, array_values($result));  
            }

            fclose($arquivo);

            return True;
        }
        return False;
    }
}