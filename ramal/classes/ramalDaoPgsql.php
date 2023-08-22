<?php
require_once 'classes/ramal.php';

class ramalDAOPgsql implements ramalDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function add_ramal(ramal $u){
            $sql = $this->pdo->prepare("select cd_ramal from cadastro.tb_ramal order by cd_ramal desc limit 1"); 
            $sql ->execute();
            $cd = $sql ->fetchAll( PDO::FETCH_ASSOC);
            $sql = $this->pdo->prepare("
            INSERT INTO cadastro.tb_ramal(cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)
            VALUES (:cd_ramal, :nm_funcionario, :nr_ramal, :nr_telefone, :nr_ip, :nm_usuario, :senha, :obs);"); 
            $sql ->bindValue(':cd_ramal', $cd[0]['cd_ramal']+1);
            $sql ->bindValue(':nm_funcionario',$u->getnm_funcionario());
            $sql ->bindValue(':nr_ramal',$u->getnr_ramal());
            $sql ->bindValue(':nr_telefone',$u->getnr_telefone());
            $sql ->bindValue(':nr_ip',$u->getnr_ip());
            $sql ->bindValue(':nm_usuario',$u->getnm_usuario());
            $sql ->bindValue(':senha',$u->getsenha());
            $sql ->bindValue(':obs',$u->getobs());
            $sql ->execute();
            return $cd[0]['cd_ramal']+1;
    }
    public function delete_ramal($cd){
        if ($cd > 0){
            $sql = $this->pdo->prepare("delete from cadastro.tb_ramal where cd_ramal = :cd"); 
            $sql ->bindValue(':cd', $cd);
            $sql ->execute();  
            return true;
        }
        return false;
    }
    public function update_ramal(ramal $u){
        $sql = $this->pdo->prepare("UPDATE cadastro.tb_ramal
        SET
        nm_funcionario=:nm_funcionario, 
        nr_ramal=:nr_ramal, nr_telefone=:nr_telefone, nr_ip=:nr_ip, nm_usuario=:nm_usuario, senha=:senha, obs=:obs
        WHERE cd_ramal=:cd_ramal;"); 
        $sql ->bindValue(':cd_ramal', $u->getcd_ramal());
        $sql ->bindValue(':nm_funcionario',$u->getnm_funcionario());
        $sql ->bindValue(':nr_ramal',$u->getnr_ramal());
        $sql ->bindValue(':nr_telefone',$u->getnr_telefone());
        $sql ->bindValue(':nr_ip',$u->getnr_ip());
        $sql ->bindValue(':nm_usuario',$u->getnm_usuario());
        $sql ->bindValue(':senha',$u->getsenha());
        $sql ->bindValue(':obs',$u->getobs());
        $sql ->execute();
        return true;
    }
    public function findall_ramal(){
    $array = [];
    $sql = $this->pdo->query('select * from cadastro.tb_ramal');
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new ramal();
            $c->setcd_ramal($dado['cd_ramal']);
            $c->setnr_ramal($dado['nr_ramal']);
            $c->setnm_funcionario($dado['nm_funcionario']);
            $c->setnr_telefone($dado['nr_telefone']);
            $c->setnr_ip($dado['nr_ip']);
            $c->setnm_usuario($dado['nm_usuario']);
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
    public function findbycd_ramal($cd){
    $array = [];
    $sql = $this->pdo->prepare("select * from cadastro.tb_ramal where cd_ramal = :cd"); 
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();
        
        if ($sql -> rowcount() > 0){
            $dado = $sql -> fetch();
            $c = new ramal();
            $c->setcd_ramal($dado['cd_ramal']);
            $c->setnr_ramal($dado['nr_ramal']);
            $c->setnm_funcionario($dado['nm_funcionario']);
            $c->setnr_telefone($dado['nr_telefone']);
            $c->setnr_ip($dado['nr_ip']);
            $c->setnm_usuario($dado['nm_usuario']);
            $c->setsenha($dado['senha']);
            $c->setobs($dado['obs']);
            $array[0] = $c;
        
        }
        else{
            return false;
        }
        return $array;
    }
}
    ?>