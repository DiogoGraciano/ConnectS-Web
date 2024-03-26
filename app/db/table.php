<?php
namespace app\db;

class login extends db{
    public function __construct(){
        parent::__construct("tb_login");
    }

    public function get($value="",$column="cd_login"){
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
        else
            $retorno = $this->getObject();

        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $retorno;
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
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
        else
            $retorno = $this->getObject();

        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $retorno;
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
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
        else
            $retorno = $this->getObject();

        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $retorno;
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
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
        else
            $retorno = $this->getObject();

        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $retorno;
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

    public function get($value="",$column="tb_ramal"){
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
        else
            $retorno = $this->getObject();

        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $retorno;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="tb_ramal"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}
class usuario extends db{
    public function __construct(){
        parent::__construct("tb_usuario");
    }

    public function get($value="",$column="tb_usuario"){
        if ($value)
            $retorno = $this->addFilter($column,"=",$value)->selectAll();
        else
            $retorno = $this->getObject();

        if (is_array($retorno) && count($retorno) == 1)
            return $retorno[0];

        return $retorno;
    }

    public function getAll(){
        return $this->selectAll();
    }

    public function delete($value,$column="tb_usuario"){
        return $this->addFilter($column,"=",$value)->deleteByFilter();
    }
}

