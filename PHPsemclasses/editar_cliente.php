<?php
require "config.php";

$cd = filter_input(INPUT_GET, 'cd');
if ($cd > 0){
    $sql = $pdo->prepare("select * from cadastro.tb_cliente where cd_cliente = :cd"); 
    $sql ->bindValue(':cd', $cd);
    $sql ->execute();

    if ($sql -> rowcount() > 0){
       $dados = $sql -> fetch( PDO::FETCH_ASSOC);
    }
    else{
        header("Location: consulta_cliente.php");
        exit; 
    }
}
else{
    header("Location: consulta_cliente.php");
    exit; 
}
?>
<h1>EDITAR CLIENTE</h1>
<form method="POST" action="action_editar_cliente.php?cd=<?php echo $cd;?>">
<label>
NOME:</br>
<input type="text" name ="nome" value= "<?php echo $dados['nm_cliente'];?>"/>
</label><br></br>
<label>
LOJA:</br>
<input type="number" name ="nrloja" value="<?php echo $dados['nr_loja'];?>"/>
</label><br></br>
<input type="submit" value="SALVAR"/>
</form>