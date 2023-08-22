<?php
interface Database {
    public function listar();
    public function adcionar();
    public function alterar();
}
class pgDB implements database{

    public function listar(){

    }
    public function adcionar(){
        echo "adicionado com PG";

    }
    public function alterar(){
        
    }
}

class mysqlDB implements database{

    public function listar(){

    }
    public function adcionar(){
        echo "adicionado com mysql";
    }
    public function alterar(){
        
    }
}

$db = new pgDB();
$db -> adcionar();




?>