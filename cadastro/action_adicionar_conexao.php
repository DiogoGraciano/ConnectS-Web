<?php
require '../config/config.php';
require 'classes/conexaoDaoPgsql.php';

$conexaoDAO = new conexaoDaoPgsql($pdo);

$cd_cliente = filter_input(INPUT_POST, 'cd_cliente');
$nm_conexao = filter_input(INPUT_POST, 'id_conexao');
$nm_terminal = filter_input(INPUT_POST, 'nm_terminal');
$nr_caixa = filter_input(INPUT_POST, 'nr_caixa');
$nm_programa = filter_input(INPUT_POST, 'nm_programa');
$nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
$senha = filter_input(INPUT_POST, 'senha');
$obs = filter_input(INPUT_POST, 'obs');

if ($nm_terminal != 'Frente De Caixa'){
    $nr_caixa = null;
}

if($cd_cliente && $nm_conexao && $nm_terminal && $nm_programa && $nm_usuario && $senha && $obs){

    $c = new conexao();
    $c->setcd_cliente($cd_cliente);
    $c->setid_conexao($nm_conexao);
    $c->setnm_terminal($nm_terminal );
    $c->setnr_caixa($nr_caixa);
    $c->setnm_programa($nm_programa);
    $c->setnm_usuario($nm_usuario);
    $c->setsenha($senha);
    $c->setobs($obs);


    $conexaoDAO ->add_conexao($c);

    header("Location: consulta_cadastro.php");
    exit;

}else{
    header("Location: adicionar_conexao.php");
    exit;
}


?>