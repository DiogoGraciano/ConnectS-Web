<?php 
namespace app\models\main;
use app\db\usuario;
use app\classes\mensagem;

class usuarioModel{

    /**
     * Obtém um registro específico da tabela 'usuario' com base no código.
     *
     * @param string|int $cd (Opcional) Código do registro a ser obtido.
     * @return mixed Retorna o registro encontrado ou null se nenhum registro for encontrado.
     */
    public static function get(string|int $cd = ""){
        return (new usuario)->get($cd);
    }

    /**
     * Obtém todos os registros da tabela 'usuario' com possibilidade de filtros.
     *
     * @param string $nm_cliente (Opcional) Nome do cliente para filtro.
     * @param string $nm_terminal (Opcional) Nome do terminal para filtro.
     * @param string $nm_sistema (Opcional) Nome do sistema para filtro.
     * @param string $nm_usuario (Opcional) Nome do usuário para filtro.
     * @return array Retorna um array contendo todos os registros filtrados da tabela 'usuario'.
     */
    public static function getAll(string $nm_cliente="",string $nm_terminal="",string $nm_sistema="",string $nm_usuario=""){

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
        
        return $usuarios->selectColumns("cd_usuario","nm_cliente","nr_loja","nm_terminal","nm_sistema","nm_usuario","senha","obs");
    }

    /**
     * Insere ou atualiza um registro na tabela 'usuario'.
     *
     * @param string|int $cd_cliente Código do cliente.
     * @param string $nm_terminal Nome do terminal.
     * @param string $nm_sistema Nome do sistema.
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha do usuário.
     * @param string $obs Observação.
     * @param string|int $cd (Opcional) Código do registro para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set(string|int $cd_cliente,string $nm_terminal,string $nm_sistema,string $nm_usuario,string $senha,string $obs,string|int $cd = ""){

        $usuario = new usuario;

        if (!clienteModel::get($cd_cliente)->cd_cliente){
            mensagem::setErro("Cliente não existe");
            return False;
        }

        if (!$nm_terminal || !$nm_sistema || !$nm_usuario || !$senha){
            mensagem::setErro("Um dos campos obrigatórios *Nome do Terminal* ou *Nome do Sistema* ou *Nome do Usuario* ou *Senha* não foi informado");
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

            $retorno = $usuario->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $usuario->getLastId();
            }
            else {
                mensagem::setErro("Erro ao executar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd && $cd_cliente && $nm_terminal && $nm_usuario && $senha){
            $values = $usuario->getObject();

            $values->cd_cliente = $cd_cliente;
            $values->nm_terminal= $nm_terminal;
            $values->nm_sistema = $nm_sistema;
            $values->nm_usuario = $nm_usuario;
            $values->senha = $senha;
            $values->obs= $obs;

            $retorno = $usuario->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $usuario->getLastId();
            }
            else {
                mensagem::setErro("Erro ao executar a ação tente novamente");
                return False;
            }
        }
        else{
            mensagem::setErro("Erro ao executar ação tente novamente");
            return False;
        }
    }

    /**
     * Deleta um registro da tabela 'usuario' com base no código.
     *
     * @param string|int $cd Código do registro a ser deletado.
     */
    public static function delete(string|int $cd){
        (new usuario)->delete($cd);
    }

    /**
     * Exporta os registros da tabela 'usuario' para um arquivo CSV.
     *
     * @return bool Retorna true se a exportação for bem-sucedida, caso contrário, retorna false.
     */
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
