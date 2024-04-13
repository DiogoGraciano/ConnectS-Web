<?php 
namespace app\models\main;
use app\db\loginApi;
use app\classes\mensagem;
use stdClass;

class loginApiModel{

    /**
     * Realiza o login do usuário.
     *
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha do usuário.
     * @return bool Retorna true se o login for bem-sucedido, caso contrário, retorna false.
     */
    public static function login(string $nm_usuario,string $senha){
        $login = new loginApi;
        $login = $login->get($nm_usuario,"nm_usuario");

        if ($login && password_verify($senha,$login->senha)){
            return True;
        }

        return False;
    }

    /**
     * Obtém um registro específico da tabela 'loginApi' com base no código.
     *
     * @param string|int $cd Código do registro a ser obtido.
     * @return mixed Retorna o registro encontrado ou null se nenhum registro for encontrado.
     */
    public static function get(string|int $cd){
        return (new loginApi)->get($cd); 
    }

    /**
     * Obtém todos os registros da tabela 'loginApi'.
     *
     * @return array Retorna um array contendo todos os registros da tabela 'loginApi'.
     */
    public static function getAll(){
        return (new loginApi)->selectColumns("cd_login_api","nm_usuario"); 
    }

    /**
     * Insere ou atualiza um registro na tabela 'loginApi'.
     *
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha do usuário.
     * @param string|int $cd_login_api (Opcional) Código do registro para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set(string $nm_usuario,string $senha,string|int $cd_login_api = ""){

        $login = new loginApi;

        if(!$nm_usuario){
            mensagem::setErro("Nome do Usuario é obrigatorio");
            return false;
        }

        if ($login->get($nm_usuario,"nm_usuario")->cd_login_api){
            mensagem::setErro("Nome do Usuario já utilizado");
            return false;
        }

        if($cd_login_api && $nm_usuario){

            $values = new stdClass;

            $values->cd_login_api = $cd_login_api;
            $values->nm_usuario= $nm_usuario;
            if($senha){
                $values->senha = password_hash($senha,PASSWORD_DEFAULT);
            }

            $retorno = $login->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $login->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd_login_api && $nm_usuario && $senha){

            if(!$senha){
                mensagem::setErro("Senha é obrigatorio");
                return false;
            }

            $values = new stdClass;
            $values->nm_usuario= $nm_usuario;
            $values->senha = password_hash($senha,PASSWORD_DEFAULT);
            
            $retorno = $login->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $login->getLastId();
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
     * Deleta um registro da tabela 'loginApi' com base no código.
     *
     * @param string $cd Código do registro a ser deletado.
     * @return bool Retorna true se o registro foi deletado com sucesso, caso contrário, retorna false.
     */
    public static function delete(string|int $cd){
        return (new loginApi)->delete($cd);
    }

}
