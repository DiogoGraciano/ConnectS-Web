<?php
require '../config/config.php';
require 'classes/clienteDaoPgsql.php';

$cd = filter_input(INPUT_GET, 'cd');
$clienteDAO = new clienteDaoPgsql($pdo);
$clienteDAO -> delete_cliente($cd);

header("Location: consulta_cliente.php");
exit; 

?>