<?php
namespace app\db;

class login extends db{
    public function __construct(){
        parent::__construct("tb_login");
    }

    public function get($value="",$column="cd_login"){
        $retorno = [];

        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
    
        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $this->getObject(); ;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="cd_login"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}
class agenda extends db{
    public function __construct(){
        parent::__construct("tb_agendamento");
    }

    public function get($value="",$column="cd_agenda"){
        $retorno = [];

        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
    
        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $this->getObject(); ;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="cd_agenda"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}
class cliente extends db{
    public function __construct(){
        parent::__construct("tb_cliente");
    }

    public function get($value="",$column="cd_cliente"){
        $retorno = [];

        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
    
        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $this->getObject(); ;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="cd_cliente"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}
class conexao extends db{
    public function __construct(){
        parent::__construct("tb_conexao");
    }

    public function get($value="",$column="cd_conexao"){
        $retorno = [];

        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
    
        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $this->getObject(); ;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="cd_conexao"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}
class ramal extends db{
    public function __construct(){
        parent::__construct("tb_ramal");
    }

    public function get($value="",$column="cd_ramal"){
        $retorno = [];

        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
    
        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $this->getObject(); ;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="cd_ramal"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}
class usuario extends db{
    public function __construct(){
        parent::__construct("tb_usuario");
    }

    public function get($value="",$column="cd_usuario"){
        $retorno = [];
        
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
    
        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $this->getObject(); ;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="cd_usuario"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}

