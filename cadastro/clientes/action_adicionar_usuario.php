<?php
require '../config/config.php';
require 'classes/usuarioDaoPgsql.php';

$usuarioDAO = new usuarioDaoPgsql($pdo);

$cd_cliente = filter_input(INPUT_POST, 'cd_cliente');
$nm_usuario = filter_input(INPUT_POST, 'id_usuario');
$nm_terminal = filter_input(INPUT_POST, 'nm_terminal');
$nr_caixa = filter_input(INPUT_POST, 'nr_caixa');
$nm_programa = filter_input(INPUT_POST, 'nm_programa');
$nm_usuario = filter_input(INPUT_POST, 'nm_usuario');
$senha = filter_input(INPUT_POST, 'senha');
$obs = filter_input(INPUT_POST, 'obs');

if ($nm_terminal != 'Frente De Caixa'){
    $nr_caixa = null;
}

if($cd_cliente && $nm_usuario && $nm_terminal && $nm_programa && $nm_usuario && $senha && $obs){

    $c = new usuario();
    $c->setcd_cliente($cd_cliente);
    $c->setid_usuario($nm_usuario);
    $c->setnm_terminal($nm_terminal );
    $c->setnr_caixa($nr_caixa);
    $c->setnm_programa($nm_programa);
    $c->setnm_usuario($nm_usuario);
    $c->setsenha($senha);
    $c->setobs($obs);


    $usuarioDAO ->add_usuario($c);

    header("Location: consulta_usuario.php");
    exit;

}else{
    header("Location: adicionar_usuario.php");
    exit;
}


?>