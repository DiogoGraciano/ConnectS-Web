<?php 
namespace app\models\main;
use app\db\conexao;
use app\classes\mensagem;

class conexaoModel{

    /**
     * Obtém um registro específico da tabela 'conexao' com base no código.
     *
     * @param int|string $cd Código do registro a ser obtido.
     * @return mixed Retorna o registro encontrado ou null se nenhum registro for encontrado.
     */
    public static function get(int|string $cd = ""){
        return (new conexao)->get($cd);
    }

    /**
     * Obtém todos os registros da tabela 'conexao' com base nos filtros fornecidos.
     *
     * @param string $nm_cliente Nome do cliente (filtro opcional).
     * @param string $nm_terminal Nome do terminal (filtro opcional).
     * @param string $nm_programa Nome do programa (filtro opcional).
     * @param string $nm_usuario Nome do usuário (filtro opcional).
     * @return array Retorna um array contendo todos os registros da tabela 'conexao' que correspondem aos filtros fornecidos.
    */
    public static function getAll(string $nm_cliente="",string $nm_terminal="",string $nm_programa="",string $nm_usuario=""){
        $conexoes = (new conexao)->addJoin("LEFT","tb_cliente","tb_cliente.cd_cliente","tb_conexao.cd_cliente");

        if($nm_cliente){
            $conexoes->addFilter("nm_cliente","LIKE","%".$nm_cliente."%");
        }

        if($nm_terminal){
            $conexoes->addFilter("nm_terminal","LIKE","%".$nm_terminal."%");
        }

        if($nm_programa){
            $conexoes->addFilter("nm_programa","LIKE","%".$nm_programa."%");
        }

        if($nm_usuario){
            $conexoes->addFilter("nm_usuario","LIKE","%".$nm_usuario."%");
        }

        return $conexoes->selectColumns("cd_conexao","nm_cliente","nr_loja","id_conexao","nm_terminal",
                    "nr_caixa","nm_programa","nm_usuario","senha","obs");
    }

    /**
     * Insere ou atualiza um registro na tabela 'conexao'.
     *
     * @param string|int $cd_cliente Código do cliente.
     * @param string $id_conexao Identificador da conexão.
     * @param string $nm_terminal Nome do terminal.
     * @param string $nm_programa Nome do programa.
     * @param string|int $nr_caixa Número do caixa.
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha da conexão.
     * @param string $obs Observações.
     * @param string|int $cd_conexao (Opcional) Código da conexão para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set(string|int $cd_cliente,string $id_conexao,string $nm_terminal,string $nm_programa,string|int $nr_caixa,string $nm_usuario,string $senha,string $obs,string|int $cd_conexao = ""){

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

    /**
     * Deleta um registro da tabela 'conexao' com base no código.
     *
     * @param string|int $cd Código do registro a ser deletado.
     * @return bool Retorna true se o registro foi deletado com sucesso, caso contrário, retorna false.
     */
    public static function delete(string|int $cd){
        $retorno = (new conexao)->delete($cd);

        if ($retorno == true){
            mensagem::setSucesso("Deletado com Sucesso");
            return True;
        }

        mensagem::setErro("Falha ao deletar, tente novamente");
        return False;
    }

    /**
     * Exporta todos os registros da tabela 'conexao' para um arquivo CSV.
     *
     * @return bool Retorna true se a exportação foi bem-sucedida, caso contrário, retorna false.
    */
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