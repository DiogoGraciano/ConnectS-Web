<?php
require '../config/config.php';
require 'classes/clienteDaoPgsql.php';
$dados = false;
$clienteDAO = new clienteDaoPgsql($pdo);
$cd = filter_input(INPUT_GET, 'cd');
if ($cd > 0){
    $dados = $clienteDAO -> findbycd_cliente($cd);
}
if ($dados === false){
    header("Location: editar_cliente.php?cd=".$cd);
    exit;
}
?>
<?php
foreach($dados as $dado): 
?>
<head>
<div class="container-xxl" >
<h1>EDITAR CLIENTE</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<form method="POST" action="action_editar_cliente.php">
<label>
<input type="hidden" name ="cd" value= "<?= $dado->getcd_cliente();?>"/>
NOME:</br>
<input type="text" name ="nome" value= "<?= $dado->getnm_cliente();?>"/>
</label><br></br>
<label>
LOJA:</br>
<input type="number" name ="nrloja" value="<?= $dado->getnr_loja();?>"/>
</label><br></br>
<input class="btn btn-dark" type="submit" value="SALVAR"/>
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_cliente.php'">VOLTAR</button>
</form>
<?php endforeach;?>
</body>
</div>