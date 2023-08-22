<?php
require_once '../cliente/classes/cliente.php';
class usuario extends cliente{
    private $cd_usuario;
    private $nm_usuario;
    private $nm_terminal; 
    private $nm_sistema; 
    private $nm_usuario; 
    private $senha; 
    private $obs; 

    public function setcd_usuario($cd){
        $this -> cd_usuario = $cd;
    }
    public function getcd_usuario(){
        return $this -> cd_usuario; 
    }
    public function setnm_usuario($cd){
        $this -> nm_usuario = $cd;
    }
    public function getnm_usuario(){
        return $this -> nm_usuario; 
    }
    public function setnm_terminal($nt){
        $this -> nm_terminal = ucwords(trim($nt));
    }
    public function getnm_terminal(){
        return $this -> nm_terminal;
    }
    public function setnm_sistema($np){
        $this -> nm_sistema = ucwords(trim($np));
    }
    public function getnm_sistema(){
        return $this ->nm_sistema;
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
}
interface usuarioDAO {
    public function add_usuario(usuario $u);
    public function findbycd_usuario($cd);
    public function findbycd_cliente($cd);
    public function findbynm_cliente(usuario $name);
    public function findall_usuario();
    public function update_usuario(usuario $u);
    public function delete_usuario($cd);
}
