<?php 
namespace app\models\main;
use app\db\login;
use app\classes\mensagem;

/**
 * Classe loginModel
 * 
 * Esta classe fornece métodos para interagir com os dados dos usuarios da plataforma.
 * Ela utiliza a classe login para realizar operações de consulta no banco de dados.
 * 
 * @package app\models\main
 */
class loginModel{

    /**
     * Realiza o login do usuário e inicializa a sessão.
     *
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha do usuário.
     * @return bool Retorna true se o login for bem-sucedido, caso contrário, retorna false.
     */
    public static function login(string $nm_usuario,string $senha){
        $login = new login;
        $login = $login->get($nm_usuario,"nm_usuario");

        if ($login && password_verify($senha,$login->senha)){
            $_SESSION["user"] = $login->cd_login;
            $_SESSION["nome"] = $login->nm_usuario;
            return True;
        }

        mensagem::setErro("Usuario ou Senha invalido");
        return False;
    }

    /**
     * Obtém um registro específico da tabela 'login' com base no código.
     *
     * @param int|string $cd Código do registro a ser obtido.
     * @return mixed Retorna o registro encontrado ou null se nenhum registro for encontrado.
     */
    public static function get(int|string $cd){
        return (new login)->get($cd); 
    }

    /**
     * Obtém todos os registros da tabela 'login'.
     *
     * @return array Retorna um array contendo todos os registros da tabela 'login'.
     */
    public static function getAll(){
        return (new login)->selectColumns("cd_login","nm_usuario"); 
    }

    /**
     * Insere ou atualiza um registro na tabela 'login'.
     *
     * @param string $nm_usuario Nome do usuário.
     * @param string $senha Senha do usuário.
     * @param int|string $cd_login (Opcional) Código do registro para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set(string $nm_usuario,string $senha,int|string $cd_login = ""){

        $login = new login;

        if(!$nm_usuario){
            mensagem::setErro("Nome do Usuario é obrigatorio");
            return false;
        }

        if ($login->get($nm_usuario,"nm_usuario")->cd_login){
            mensagem::setErro("Nome do Usuario já utilizado");
            return false;
        }

        if($cd_login && $nm_usuario){

            $values = $login->getObject();

            $values->cd_login = $cd_login;
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
        elseif(!$cd_login && $nm_usuario && $senha){

            if(!$senha){
                mensagem::setErro("Senha é obrigatorio");
                return false;
            }

            $values = $login->getObject();

            $values->cd_login = $cd_login;
            $values->nm_usuario= $nm_usuario;
            $values->senha = password_hash($senha,PASSWORD_DEFAULT);;
            
            if ($values)
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
     * Deleta um registro da tabela 'login' com base no código.
     *
     * @param string $cd Código do registro a ser deletado.
     * @return bool Retorna true se o registro foi deletado com sucesso, caso contrário, retorna false.
     */
    public static function delete(int|string $cd){
        return (new login)->delete($cd);
    }

    /**
     * Desloga o usuário, destruindo a sessão atual.
     */
    public static function deslogar(){
        session_destroy();
    }

}
