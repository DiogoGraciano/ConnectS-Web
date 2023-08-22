<?php
require '../config/config.php';
require 'classes/conexaoDaoPgsql.php';

$cd = filter_input(INPUT_GET, 'cd');
$conexaoDAO = new conexaoDaoPgsql($pdo);
$conexaoDAO -> delete_conexao($cd);

header("Location: consulta_cadastro.php");
exit; 

?>