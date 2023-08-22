<?php
require "config.php";

$cd = filter_input(INPUT_GET, 'cd');
$nome = filter_input(INPUT_POST, 'nome');
$nrloja = filter_input(INPUT_POST, 'nrloja');

if($cd && $nome && $nrloja){

    $sql = $pdo->prepare("update cadastro.tb_cliente set nm_cliente = :nome,nr_loja = :nrloja where cd_cliente = :cd"); 
    $sql ->bindValue(':nome',$nome);//manda na hora o valor da variavel
    //$sql ->bindParam(':nrloja',$nrloja);//manda o valor da variavel mesmo se alterado depois da execução da linha de codigo
    $sql ->bindValue(':nrloja',$nrloja);
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();

    header("Location: consulta_cliente.php");
    exit;

}else{
    header("Location: editar_cliente.php?cd=<?php echo $cd;?>");
    exit;
}


?>