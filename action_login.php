<?php
require 'config/config.php';
$senha = '';
$nm_usuario = '';
$nm_usuario = strtoupper(filter_input(INPUT_POST, 'nm_usuario'));
$senha = filter_input(INPUT_POST, 'senha');
$sql = $pdo -> prepare("SELECT nm_usuario, senha FROM cadastro.tb_login where nm_usuario = :nm_usuario and senha = :senha");
$sql -> bindValue(":nm_usuario",$nm_usuario);
$sql -> bindValue(":senha",$senha);
$sql -> execute();

if ($sql -> rowCount() > 0){
    header("Location: menu.php");
}
else {
    header("Location: index.php");
    exit;
} 

?>