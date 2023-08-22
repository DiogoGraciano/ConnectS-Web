<?php
require_once '../cliente/classes/cliente.php';
class conexao extends cliente{
    private $cd_conexao;
    private $id_conexao;
    private $nm_terminal; 
    private $nm_programa; 
    private $nm_usuario; 
    private $senha; 
    private $obs; 
    private $nr_caixa; 

    public function setcd_conexao($cd){
        $this -> cd_conexao = $cd;
    }
    public function getcd_conexao(){
        return $this -> cd_conexao; 
    }
    public function setid_conexao($cd){
        $this -> id_conexao = $cd;
    }
    public function getid_conexao(){
        return $this -> id_conexao; 
    }
    public function setnm_terminal($nt){
        $this -> nm_terminal = ucwords(trim($nt));
    }
    public function getnm_terminal(){
        return $this -> nm_terminal;
    }
    public function setnm_programa($np){
        $this -> nm_programa = ucwords(trim($np));
    }
    public function getnm_programa(){
        return $this ->nm_programa;
    }
    public function setnm_usuario($u){
        $this -> nm_usuario = ucwords(trim($u));
    }
    public function getnm_usuario(){
        return $this -> nm_usuario;
    }
    public function setsenha($se){
        $this -> senha = ucwords(trim($se));
    }
    public function getsenha(){
        return $this -> senha;
    }
    public function setobs($ob){
        $this -> obs = ucwords(trim($ob));
    }
    public function getobs(){
        return $this -> obs;
    }
    public function setnr_caixa($nr){
        $this -> nr_caixa = $nr;
    }
    public function getnr_caixa(){
        return $this -> nr_caixa;
    }
    public function setnr_loja($nr){
        $this -> nr_loja = $nr;
    }
    public function getnr_loja(){
        return $this -> nr_loja;
    }
}
interface conexaoDAO {
    public function add_conexao(conexao $u);
    public function findbycd_conexao($cd);
    public function findbycd_cliente($cd);
    public function findbynm_cliente(conexao $name);
    public function findall_conexao();
    public function update_conexao(conexao $u);
    public function delete_conexao($cd);
}
