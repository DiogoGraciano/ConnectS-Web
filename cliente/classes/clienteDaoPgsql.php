<?php
require_once '../cliente/classes/cliente.php';

class clienteDAOPgsql implements clienteDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function add_cliente(cliente $u){
            $sql = $this->pdo->prepare("select cd_cliente from cadastro.tb_cliente order by cd_cliente desc limit 1"); 
            $sql ->execute();
            $cd = $sql ->fetchAll( PDO::FETCH_ASSOC);
            $sql = $this->pdo->prepare("INSERT into cadastro.tb_cliente (cd_cliente,nm_cliente,nr_Loja) values (:cd,:nome,:nrloja)"); 
            $sql ->bindValue(':nome',$u->getnm_cliente());
            $sql ->bindValue(':nrloja',$u->getnr_loja());
            $sql ->bindValue(':cd', $cd[0]['cd_cliente']+1);
            $sql ->execute();
            return $cd[0]['cd_cliente']+1;
    }
    public function delete_cliente($cd){
        if ($cd > 0){
            $sql = $this->pdo->prepare("delete from cadastro.tb_cliente where cd_cliente = :cd"); 
            $sql ->bindValue(':cd', $cd);
            $sql ->execute();  
            return true;
        }
        return false;
    }
    public function update_cliente(cliente $u){
        $sql = $this->pdo->prepare("update cadastro.tb_cliente set nm_cliente = :nome,nr_loja = :nrloja where cd_cliente = :cd"); 
        $sql ->bindValue(':nome', $u -> getnm_cliente());
        $sql ->bindValue(':nrloja', $u -> getnr_loja());
        $sql ->bindValue(':cd',  $u -> getcd_cliente());
        $sql ->execute();
        return true;
    }
    public function findall_cliente(){
    $array = [];
    $sql = $this->pdo->query('select * from cadastro.tb_cliente');
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new cliente();
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);

            $array[] = $c;
        }
    return $array;
    }  
    else{
        return false;
    }  
    }
    public function findbycd_cliente($cd){
    $array = [];
    $sql = $this->pdo->prepare("select * from cadastro.tb_cliente where cd_cliente = :cd"); 
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();
        
        if ($sql -> rowcount() > 0){
            $dados = $sql -> fetch();
            $c = new cliente;
            $c->setcd_cliente($dados['cd_cliente']);
            $c->setnm_cliente($dados['nm_cliente']);
            $c->setnr_loja($dados['nr_loja']);
            $array[0] = $c;
        
        }
        else{
            return false;
        }
        return $array;
    }
    public function findbynm_cliente(cliente $nome){
    $array = [];
    $sql = $this->pdo->prepare("select * from cadastro.tb_cliente where nm_cliente like :nome");
    $sql ->bindValue(':nome', '%'.$nome->getnm_cliente().'%');
    $sql ->execute(); 
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new cliente();
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);

            $array[] = $c;
        }
    return $array;
    }  
    else{
        return false;
    }  
    }
}
    ?>