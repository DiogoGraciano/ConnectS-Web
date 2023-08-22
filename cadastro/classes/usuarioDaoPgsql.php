<?php
require_once 'classes/usuario.php';

class usuarioDAOPgsql implements usuarioDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function add_usuario(usuario $u){
            $sql = $this->pdo->prepare("select cd_usuario from cadastro.tb_usuario order by cd_usuario desc limit 1"); 
            $sql ->execute();
            $cd = $sql ->fetchAll( PDO::FETCH_ASSOC);
            $sql = $this->pdo->prepare("
            INSERT INTO cadastro.tb_usuario
            (cd_usuario, nm_usuario, cd_cliente, nm_terminal, nm_sistema, senha, obs) 
            VALUES 
            (:cd_usuario,:nm_usuario,:cd_cliente,:nm_terminal,:nm_sistema,:senha,:obs)"); 
            $sql ->bindValue(':cd_usuario', $cd[0]['cd_usuario']+1);
            $sql ->bindValue(':cd_cliente',$u->getcd_cliente());
            $sql ->bindValue(':nm_usuario',$u->getnm_usuario());
            $sql ->bindValue(':nm_terminal',$u->getnm_terminal());
            $sql ->bindValue(':nm_sistema',$u->getnm_sistema());
            $sql ->bindValue(':senha',$u->getsenha());
            $sql ->bindValue(':obs',$u->getobs());
            $sql ->execute();
            return $cd[0]['cd_usuario']+1;
    }
    public function delete_usuario($cd){
        if ($cd > 0){
            $sql = $this->pdo->prepare("delete from cadastro.tb_usuario where cd_usuario = :cd"); 
            $sql ->bindValue(':cd', $cd);
            $sql ->execute();  
            return true;
        }
        return false;
    }
    public function update_usuario(usuario $u){
        $sql = $this->pdo->prepare("UPDATE cadastro.tb_usuario SET nm_usuario = :nm_usuario, 
        cd_cliente = :cd_cliente
        ,nm_terminal = :nm_terminal, nm_sistema = :nm_sistema, senha = :senha, 
        obs = :obs WHERE cd_usuario = :cd_usuario"); 
        $sql ->bindValue(':nm_usuario',$u->getnm_usuario());
        $sql ->bindValue(':cd_cliente',$u->getcd_cliente());
        $sql ->bindValue(':nm_terminal',$u->getnm_terminal());
        $sql ->bindValue(':nm_sistema',$u->getnm_sistema());
        $sql ->bindValue(':senha',$u->getsenha());
        $sql ->bindValue(':obs',$u->getobs());
        $sql ->bindValue(':cd_usuario',  $u -> getcd_usuario());
        $sql ->execute();
        return true;
    }
    public function findall_usuario(){
    $array = [];
    $sql = $this->pdo->query('select 
    cd_usuario,tb_usuario.cd_cliente,nm_cliente,nr_loja,nm_usuario,nm_terminal,nm_sistema,senha,obs 
    from cadastro.tb_usuario 
    inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_usuario.cd_cliente');
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new usuario();
            $c->setcd_usuario($dado['cd_usuario']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setnm_usuario($dado['nm_usuario']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnm_sistema($dado['nm_sistema']);
            $c->setsenha($dado['senha']);
            $c->setobs($dado['obs']);

            $array[] = $c;
        }
    return $array;
    }  
    else{
        return false;
    }  
    }
    public function findbycd_usuario($cd){
    $array = [];
    $sql = $this->pdo->prepare("select 
    cd_usuario,tb_usuario.cd_cliente,nm_cliente,nr_loja,nm_usuario,nm_terminal,nm_sistema,senha,obs 
    from cadastro.tb_usuario 
    inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_usuario.cd_cliente where cd_usuario = :cd"); 
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();
        
        if ($sql -> rowcount() > 0){
            $dado = $sql -> fetch();
            $c = new usuario();
            $c->setcd_usuario($dado['cd_usuario']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setnm_usuario($dado['nm_usuario']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnm_sistema($dado['nm_sistema']);
            $c->setsenha($dado['senha']);
            $c->setobs($dado['obs']);
            $array[0] = $c;
        
        }
        else{
            return false;
        }
        return $array;
    }
    public function findbycd_cliente($cd){
        $array = [];
        $sql = $this->pdo->prepare("select 
        cd_usuario,tb_usuario.cd_cliente,nm_cliente,nr_loja,nm_usuario,nm_terminal,nm_sistema,senha,obs 
        from cadastro.tb_usuario 
        inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_usuario.cd_cliente 
        where tb_usuario.cd_cliente = :cd"); 
        $sql ->bindValue(':cd', $cd);
        $sql ->execute();
        
        if ($sql -> rowcount() > 0){
            $dado = $sql -> fetch();
            $c = new usuario();
            $c->setcd_usuario($dado['cd_usuario']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setnm_usuario($dado['nm_usuario']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnm_sistema($dado['nm_sistema']);
            $c->setsenha($dado['senha']);
            $c->setobs($dado['obs']);
            $array[0] = $c;
        
        }
        else{
            return false;
        }
        return $array;
        }
    public function findbynm_cliente(usuario $nome){
    $array = [];
    $sql = $this->pdo->prepare("select 
    cd_usuario,tb_usuario.cd_cliente,nm_cliente,nr_loja,nm_usuario,nm_terminal,nm_sistema,senha,obs 
    from cadastro.tb_usuario 
    inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_usuario.cd_cliente 
    where tb_cliente.nm_cliente like :nome");
    $sql ->bindValue(':nome', '%'.$nome->getnm_cliente().'%');
    $sql ->execute(); 
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new usuario();
            $c->setcd_usuario($dado['cd_usuario']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setnm_usuario($dado['nm_usuario']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnm_sistema($dado['nm_sistema']);
            $c->setsenha($dado['senha']);
            $c->setobs($dado['obs']);

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