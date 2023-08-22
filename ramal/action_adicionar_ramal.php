<?php
require '../config/config.php';
require 'classes/ramalDaoPgsql.php';

$ramalDAO = new ramalDaoPgsql($pdo);

$nr_ramal = filter_input(INPUT_POST, 'nr_ramal');
$nm_funcionario = filter_input(INPUT_POST, 'nm_funcionario');
$nr_telefone = filter_input(INPUT_POST, 'nr_telefone');
$nr_ip = filter_input(INPUT_POST, 'nr_ip');
$nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
$senha = filter_input(INPUT_POST, 'senha');
$obs = filter_input(INPUT_POST, 'obs');

if($nm_funcionario && $nr_ramal && $nr_telefone && $nr_ip && $nm_usuario && $senha && $obs){

    $c = new ramal();
    $c->setnr_ramal($nr_ramal);
    $c->setnm_funcionario($nm_funcionario);
    $c->setnr_telefone($nr_telefone);
    $c->setnr_ip($nr_ip);
    $c->setnm_usuario($nm_usuario);
    $c->setsenha($senha);
    $c->setobs($obs);

    $ramalDAO ->add_ramal($c);

    header("Location: consulta_ramal.php");
    exit;

}else{
    header("Location: adicionar_ramal.php");
    exit;
}


?>