<?php
require "config.php";

$nome = filter_input(INPUT_POST, 'nome');
$nrloja = filter_input(INPUT_POST, 'nrloja');

if($nome && $nrloja){

    $sql = $pdo->prepare("select cd_cliente from cadastro.tb_cliente order by cd_cliente desc limit 1"); 
    $sql ->execute();
    $cd = $sql ->fetchAll( PDO::FETCH_ASSOC);
    $sql = $pdo->prepare("INSERT into cadastro.tb_cliente (cd_cliente,nm_cliente,nr_Loja) values (:cd,:nome,:nrloja)"); 
    $sql ->bindValue(':nome',$nome);//manda na hora o valor da variavel
    //$sql ->bindParam(':nrloja',$nrloja);//manda o valor da variavel mesmo se alterado depois da execução da linha de codigo
    $sql ->bindValue(':nrloja',$nrloja);
    $sql ->bindValue(':cd', $cd[0]['cd_cliente']+1);
    $sql ->execute();

    header("Location: consulta_cliente.php");
    exit;

}else{
    header("Location: adicionar_cliente.php");
    exit;
}


?>