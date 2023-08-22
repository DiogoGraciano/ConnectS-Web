<?php
class ramal{
    private $cd_ramal;
    private $nm_funcionario;
    private $nr_ramal; 
    private $nr_telefone; 
    private $nr_ip; 
    private $nm_usuario; 
    private $senha; 
    private $obs; 

    public function setcd_ramal($cd){
        $this -> cd_ramal = $cd;
    }
    public function getcd_ramal(){
        return $this -> cd_ramal; 
    }
    public function setnm_funcionario($nt){
        $this -> nm_funcionario = ucwords(trim($nt));
    }
    public function getnm_funcionario(){
        return $this -> nm_funcionario;
    }
    public function setnr_telefone($np){
        $this -> nr_telefone = trim($np);
    }
    public function getnr_telefone(){
        return $this ->nr_telefone;
    }
    public function setnr_ip($np){
        $this -> nr_ip = trim($np);
    }
    public function getnr_ip(){
        return $this ->nr_ip;
    }
    public function setnr_ramal($nr){
        $this -> nr_ramal= $nr;
    }
    public function getnr_ramal(){
        return $this ->nr_ramal;
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
interface ramalDAO {
    public function add_ramal(ramal $u);
    public function findbycd_ramal($cd);
    public function findall_ramal();
    public function update_ramal(ramal $u);
    public function delete_ramal($cd);
}
