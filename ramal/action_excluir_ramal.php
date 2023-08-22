<?php
require '../config/config.php';
require 'classes/ramalDaoPgsql.php';

$cd = filter_input(INPUT_GET, 'cd');
$ramalDAO = new ramalDaoPgsql($pdo);
$ramalDAO -> delete_ramal($cd);

header("Location: consulta_ramal.php");
exit; 

?>