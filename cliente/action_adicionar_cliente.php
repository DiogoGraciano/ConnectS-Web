<?php
require '../config/config.php';
require 'classes/clienteDaoPgsql.php';

$clienteDAO = new clienteDaoPgsql($pdo);
$dados = $clienteDAO->findall_cliente();

$nome = filter_input(INPUT_POST, 'nome');
$nrloja = filter_input(INPUT_POST, 'nrloja');

if($nome && $nrloja){

    $cliente = new cliente();
    $cliente -> setnm_cliente(strtolower($nome));
    $cliente -> setnr_loja($nrloja);

    $clienteDAO ->add_cliente($cliente);

    header("Location: consulta_cliente.php");
    exit;

}else{
    header("Location: adicionar_cliente.php");
    exit;
}


?>