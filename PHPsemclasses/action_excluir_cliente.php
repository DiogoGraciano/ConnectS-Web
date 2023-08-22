<?php
require "config.php";

$cd = filter_input(INPUT_GET, 'cd');

if ($cd > 0){
    $sql = $pdo->prepare("delete from cadastro.tb_cliente where cd_cliente = :cd"); 
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();  
}
header("Location: consulta_cliente.php");
exit; 

?>