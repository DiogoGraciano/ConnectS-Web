<?php
require_once 'classes/conexao.php';

class conexaoDAOPgsql implements conexaoDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function add_conexao(conexao $u){
            $sql = $this->pdo->prepare("select cd_conexao from cadastro.tb_conexao order by cd_conexao desc limit 1"); 
            $sql ->execute();
            $cd = $sql ->fetchAll( PDO::FETCH_ASSOC);
            $sql = $this->pdo->prepare("
            INSERT INTO cadastro.tb_conexao
            (cd_conexao, id_conexao, cd_cliente, nm_terminal, nm_programa, nm_usuario, senha, obs, nr_caixa) 
            VALUES 
            (:cd_conexao,:id_conexao,:cd_cliente,:nm_terminal,:nm_programa,:nm_usuario,:senha,:obs,:nr_caixa)"); 
            $sql ->bindValue(':cd_conexao', $cd[0]['cd_conexao']+1);
            $sql ->bindValue(':id_conexao',$u->getid_conexao());
            $sql ->bindValue(':cd_cliente',$u->getcd_cliente());
            $sql ->bindValue(':nm_terminal',$u->getnm_terminal());
            $sql ->bindValue(':nm_programa',$u->getnm_programa());
            $sql ->bindValue(':nm_usuario',$u->getnm_usuario());
            $sql ->bindValue(':senha',$u->getsenha());
            $sql ->bindValue(':obs',$u->getobs());
            $sql ->bindValue(':nr_caixa',$u->getnr_caixa()); 
            $sql ->execute();
            return $cd[0]['cd_conexao']+1;
    }
    public function delete_conexao($cd){
        if ($cd > 0){
            $sql = $this->pdo->prepare("delete from cadastro.tb_conexao where cd_conexao = :cd"); 
            $sql ->bindValue(':cd', $cd);
            $sql ->execute();  
            return true;
        }
        return false;
    }
    public function update_conexao(conexao $u){
        $sql = $this->pdo->prepare("UPDATE cadastro.tb_conexao SET id_conexao = :id_conexao, 
        cd_cliente = :cd_cliente
        ,nm_terminal = :nm_terminal, nm_programa = :nm_programa, nm_usuario = :nm_usuario, senha = :senha, 
        obs = :obs, nr_caixa = :nr_caixa  WHERE cd_conexao = :cd_conexao"); 
        $sql ->bindValue(':id_conexao',$u->getid_conexao());
        $sql ->bindValue(':cd_cliente',$u->getcd_cliente());
        $sql ->bindValue(':nm_terminal',$u->getnm_terminal());
        $sql ->bindValue(':nm_programa',$u->getnm_programa());
        $sql ->bindValue(':nm_usuario',$u->getnm_usuario());
        $sql ->bindValue(':senha',$u->getsenha());
        $sql ->bindValue(':obs',$u->getobs());
        $sql ->bindValue(':nr_caixa',$u->getnr_caixa());
        $sql ->bindValue(':cd_conexao',  $u -> getcd_conexao());
        $sql ->execute();
        return true;
    }
    public function findall_conexao(){
    $array = [];
    $sql = $this->pdo->query('select cd_conexao,tb_conexao.cd_cliente,nm_cliente,nr_loja,id_conexao,nm_terminal,nr_caixa,nm_programa,nm_usuario,senha,obs from cadastro.tb_conexao inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_conexao.cd_cliente');
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new conexao();
            $c->setcd_conexao($dado['cd_conexao']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setid_conexao($dado['id_conexao']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnr_caixa($dado['nr_caixa']);
            $c->setnm_programa($dado['nm_programa']);
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
    public function findbycd_conexao($cd){
    $array = [];
    $sql = $this->pdo->prepare("select cd_conexao,tb_conexao.cd_cliente,nm_cliente,nr_loja,id_conexao,nm_terminal,nr_caixa,nm_programa,nm_usuario,senha,obs from cadastro.tb_conexao inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_conexao.cd_cliente where cd_conexao = :cd"); 
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();
        
        if ($sql -> rowcount() > 0){
            $dado = $sql -> fetch();
            $c = new conexao();
            $c->setcd_conexao($dado['cd_conexao']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setid_conexao($dado['id_conexao']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnr_caixa($dado['nr_caixa']);
            $c->setnm_programa($dado['nm_programa']);
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
    public function findbycd_cliente($cd){
        $array = [];
        $sql = $this->pdo->prepare("select cd_conexao,tb_conexao.cd_cliente,nm_cliente,nr_loja,id_conexao,nm_terminal,nr_caixa,nm_programa,nm_usuario,senha,obs from cadastro.tb_conexao inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_conexao.cd_cliente where tb_conexao.cd_cliente = :cd"); 
        $sql ->bindValue(':cd', $cd);
        $sql ->execute();
        
        if ($sql -> rowcount() > 0){
            $dado = $sql -> fetch();
            $c = new conexao();
            $c->setcd_conexao($dado['cd_conexao']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setid_conexao($dado['id_conexao']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnr_caixa($dado['nr_caixa']);
            $c->setnm_programa($dado['nm_programa']);
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
    public function findbynm_cliente(conexao $nome){
    $array = [];
    $sql = $this->pdo->prepare("select 
    cd_conexao,tb_conexao.cd_cliente,nm_cliente,nr_loja,id_conexao,nm_terminal,nr_caixa,nm_programa,nm_usuario,senha,obs from cadastro.tb_conexao inner join cadastro.tb_cliente on tb_cliente.cd_cliente = tb_conexao.cd_cliente 
    where tb_cliente.nm_cliente like :nome");
    $sql ->bindValue(':nome', '%'.$nome->getnm_cliente().'%');
    $sql ->execute(); 
    if ($sql ->rowCount() > 0){
        $dados = $sql->fetchAll();
        foreach ($dados as $dado){
            $c = new conexao();
            $c->setcd_conexao($dado['cd_conexao']);
            $c->setcd_cliente($dado['cd_cliente']);
            $c->setnm_cliente($dado['nm_cliente']);
            $c->setnr_loja($dado['nr_loja']);
            $c->setid_conexao($dado['id_conexao']);
            $c->setnm_terminal($dado['nm_terminal']);
            $c->setnr_caixa($dado['nr_caixa']);
            $c->setnm_programa($dado['nm_programa']);
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
}
    ?>