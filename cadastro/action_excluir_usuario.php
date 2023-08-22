<?php
require '../config/config.php';
require 'classes/usuarioDaoPgsql.php';

$cd = filter_input(INPUT_GET, 'cd');
$usuarioDAO = new usuarioDaoPgsql($pdo);
$usuarioDAO -> delete_usuario($cd);

header("Location: consulta_cadastro.php");
exit; 

?>