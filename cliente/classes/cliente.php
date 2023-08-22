<?php
class cliente{
    private $cd_cliente;
    private $nm_cliente; 
    private $nr_loja;

    public function setcd_cliente($cd){
        $this -> cd_cliente = $cd;
    }
    public function getcd_cliente(){
        return $this -> cd_cliente; 
    }
    public function setnm_cliente($nm){
        $this -> nm_cliente = ucwords(trim($nm));
    }
    public function getnm_cliente(){
        return $this -> nm_cliente;
    }
    public function setnr_loja($nr){
        $this -> nr_loja = $nr;
    }
    public function getnr_loja(){
        return $this -> nr_loja;
    }
}
interface clienteDAO {
    public function add_cliente(cliente $u);
    public function findbycd_cliente($cd);
    public function findbynm_cliente(cliente $name);
    public function findall_cliente();
    public function update_cliente(cliente $u);
    public function delete_cliente($cd);
}
