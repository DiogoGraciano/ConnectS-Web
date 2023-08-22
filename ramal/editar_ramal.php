<?php
require '../config/config.php';
require 'classes/ramalDaoPgsql.php';
require '../cliente/classes/clienteDaoPgsql.php';

$dados = false;
$ramalDAO = new ramalDaoPgsql($pdo);
$clienteDAO = new clienteDaoPgsql($pdo);
$clientes = $clienteDAO -> findall_cliente();
$cd = filter_input(INPUT_GET, 'cd');
if ($cd > 0){
    $dados = $ramalDAO -> findbycd_ramal($cd);
}
if ($dados === false){
    header("Location: editar_ramal.php?cd=".$cd);
    exit;
}

?>
<?php
foreach($dados as $dado): 
?>
<head>
<div class="container-xxl" >
<h1>EDITAR RAMAL</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<form method="POST" action="action_editar_ramal.php">
<input type="hidden" name ="cd_ramal" class="form-control" style="width: 420px;" value="<?php echo $cd?>" required/>
<label>
RAMAL:</br>
<input type="text" class="form-control" name ="nr_ramal" value="<?php echo $dado->getnr_ramal()?>" required/>
<label>
FUNCIONARIO:</br>
<input type="text" class="form-control" name ="nm_funcionario" value="<?php echo $dado->getnm_funcionario()?>" required/>
</label>
<label>
TELEFONE:</br>
<input type="text" id="nr_telefone" minlength="8" maxlength="9" name="nr_telefone"  value="<?php echo $dado->getnr_telefone()?>" class="form-control">
<script>
    $( "#nr_telefone" ).keypress(function() {
        $(this).mask('(00) 0000-00009');
    });
</script>
</label></br>
<label>
IP:</br>
<input type="text" class="form-control ip_address" minlength="4" maxlength="12"  id ="nr_ip" name ="nr_ip" value="<?php echo $dado->getnr_ip()?>"/>
<script>
    $( "#nr_ip" ).keypress(function() {
        $(this).mask('099.099.099.099');
    });
</script>
</label></br>
<label>
USUARIO:</br>
<input type="text" class="form-control" name ="nm_usuario" value="<?php echo $dado->getnm_usuario()?>"/>
</label>
<label>
SENHA:</br>
<input type="text" class="form-control" name ="senha" value="<?php echo $dado->getsenha()?>"/>
</label></br>
<label>
OBSERVAÇÕES:</br>
<textarea class="form-control" rows="3" id="comment" style="width: 420px;" name="obs"><?php echo $dado->getobs()?></textarea>
</label><br></br>
<input class="btn btn-dark" type="submit" value="SALVAR"/>
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_ramal.php'">VOLTAR</button>
</form>
<?php endforeach;?>
</body>
</div>