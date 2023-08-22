<?php
require '../config/config.php';
require 'classes/usuarioDaoPgsql.php';

$usuarioDAO = new usuarioDaoPgsql($pdo);

$cd_usuario = filter_input(INPUT_POST, 'cd_usuario');
$cd_cliente = filter_input(INPUT_POST, 'cd_cliente');
$nm_terminal = filter_input(INPUT_POST, 'nm_terminal');
$nm_sistema = filter_input(INPUT_POST, 'nm_sistema');
$nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
$senha = filter_input(INPUT_POST, 'senha');
$obs = filter_input(INPUT_POST, 'obs');
if($cd_usuario && $cd_cliente && $nm_usuario && $nm_terminal && $nm_sistema && $nm_usuario && $senha && $obs){

    $c = new usuario();
    $c->setcd_usuario($cd_usuario);
    $c->setcd_cliente($cd_cliente);
    $c->setnm_terminal($nm_terminal );
    $c->setnm_sistema($nm_sistema);
    $c->setnm_usuario($nm_usuario);
    $c->setsenha($senha);
    $c->setobs($obs);
    $usuarioDAO -> update_usuario($c);

    header("Location: consulta_cadastro.php");
    exit;

}else{
    header("Location: editar_usuario.php?cd=".$cd_usuario);
    exit;
}


?>