<?php 
namespace app\models\main;
use app\db\cliente;
use app\classes\mensagem;

/**
 * Classe clienteModel
 * 
 * Esta classe fornece métodos para interagir com os dados dos clientes.
 * Ela utiliza a classe cliente para realizar operações de consulta no banco de dados.
 * 
 * @package app\models\main
 */
class clienteModel{

    /**
     * Obtém um registro específico da tabela 'agenda' com base no código.
     *
     * @param string $cd Código do registro a ser obtido.
     * @return mixed Retorna o registro encontrado ou null se nenhum registro for encontrado.
    */
    public static function get($cd = ""){
        return (new cliente)->get($cd);
    }

    /**
     * Obtém todos os registros da tabela 'cliente' com base nos filtros fornecidos.
     *
     * @param string $nm_cliente Nome do cliente (filtro opcional).
     * @param string $nr_loja Número da loja (filtro opcional).
     * @return array Retorna um array contendo todos os registros da tabela 'cliente' que correspondem aos filtros fornecidos.
    */
    public static function getAll(string $nm_cliente="",string $nr_loja=""){
        $cliente = new cliente;

        if($nm_cliente){
            $cliente->addFilter("nm_cliente","LIKE","%".$nm_cliente."%");
        }

        if($nr_loja){
            $cliente->addFilter("nr_loja","=",$nr_loja);
        }

        return $cliente->selectAll();
    }

    /**
     * Insere ou atualiza um registro na tabela 'cliente'.
     *
     * @param string $nome Nome do cliente.
     * @param string|int $nrloja Número da loja.
     * @param string $cd (Opcional) Código do cliente para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set(string $nome,string|int $nrloja,string|int $cd = ""){

        $cliente = new cliente;

        if($cd && $nome && $nrloja){
 
            $values = self::get($cd);

            if(!$values->cd_cliente){
                mensagem::setErro("Cliente não existe");
                return false;
            }

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

    /**
     * Deleta um registro da tabela 'cliente' com base no código.
     *
     * @param string|int $cd Código do registro a ser deletado.
     * @return bool Retorna true se o registro foi deletado com sucesso, caso contrário, retorna false.
     */
    public static function delete(string|int $cd){
        $retorno = (new cliente)->delete($cd);

        if ($retorno == true){
            mensagem::setSucesso("Deletado com Sucesso");
            return True;
        }

        return False;
    }

    /**
     * Exporta todos os registros da tabela 'cliente' para um arquivo CSV.
     *
     * @return bool Retorna true se a exportação foi bem-sucedida, caso contrário, retorna false.
     */
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