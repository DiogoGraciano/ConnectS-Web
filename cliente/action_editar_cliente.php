<?php
require '../config/config.php';
require 'classes/clienteDaoPgsql.php';

$clienteDAO = new clienteDaoPgsql($pdo);

$cd = filter_input(INPUT_POST, 'cd');
$nome = filter_input(INPUT_POST, 'nome');
$nrloja = filter_input(INPUT_POST, 'nrloja');

if($cd && $nome && $nrloja){
  
    $cliente = new cliente();
    $cliente -> setcd_cliente($cd);
    $cliente -> setnm_cliente(strtolower($nome));
    $cliente -> setnr_loja($nrloja);
    $clienteDAO -> update_cliente($cliente);

    header("Location: consulta_cliente.php");
    exit;

}else{
    header("Location: editar_cliente.php?cd="$cd);
    exit;
}


?>