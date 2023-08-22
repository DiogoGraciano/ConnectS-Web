<?php
require '../config/config.php';
require 'classes/usuarioDaoPgsql.php';
require '../cliente/classes/clienteDaoPgsql.php';

$dados = false;
$usuarioDAO = new usuarioDaoPgsql($pdo);
$clienteDAO = new clienteDaoPgsql($pdo);
$clientes = $clienteDAO -> findall_cliente();
$cd = filter_input(INPUT_GET, 'cd');
if ($cd > 0){
    $dados = $usuarioDAO -> findbycd_usuario($cd);
}
if ($dados === false){
    header("Location: editar_usuario.php?cd=".$cd);
    exit;
}

?>
<?php
foreach($dados as $dado): 
?>
<head>
<div class="container-xxl" >
<h1>EDITAR USUARIO</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<form method="POST" action="action_editar_usuario.php">
<input type="hidden" name ="cd_usuario" class="form-control" style="width: 420px;" value="<?php echo $cd?>" required/>
<label>
CLIENTE:</br>
<select class="form-select" name ="cd_cliente" required>
<?php foreach($clientes as $cliente): ?>
    <option value="<?php echo $cliente->getcd_cliente();?>" 
    <?php if($cliente->getcd_cliente() === $dado->getcd_cliente()){ echo "selected";}?>>
    <?php echo $cliente->getnm_cliente();echo " Loja: ";echo $cliente->getnr_loja();?>
    </option>
<?php endforeach; ?>
</select>
<label>
TERMINAL:</br>
<select class="form-select" name ="nm_terminal" style="width: 175px;" required>
  <option <?php if("Balcão" == $dado->getnm_terminal()){ echo "selected";}?>>Balcão</option>
  <option <?php if("Deposito" == $dado->getnm_terminal()){ echo "selected";}?>>Deposito</option>
  <option <?php if("Escritorio" == $dado->getnm_terminal()){ echo "selected";}?>>Escritorio</option>
  <option <?php if("Frente De Caixa" == $dado->getnm_terminal()){ echo "selected";}?>>Frente De Caixa</option>
  <option <?php if("Servidor APP" == $dado->getnm_terminal()){ echo "selected";}?>>Servidor APP</option>
  <option <?php if("Servidor Super" == $dado->getnm_terminal()){ echo "selected";}?>>Servidor Super</option>
  <option <?php if("Servidor SITEF" == $dado->getnm_terminal()){ echo "selected";}?>>Servidor SITEF</option>
</select>
</label>
<label>
SISTEMA:</br>
<select class="form-select" name ="nm_sistema" style="width: 175px;" required>
  <option <?php if("Windows" == $dado->getnm_sistema()){ echo "selected";}?>>Windows</option>
  <option <?php if("Linux" == $dado->getnm_sistema()){ echo "selected";}?>>Linux</option>
  <option <?php if("Mac OS" == $dado->getnm_sistema()){ echo "selected";}?>>Mac OS</option>
  <option <?php if("TEF WEB" == $dado->getnm_sistema()){ echo "selected";}?>>TEF Web</option>
  <option <?php if("Token Email" == $dado->getnm_sistema()){ echo "selected";}?>>Token Email</option>
  <option <?php if("Outro" == $dado->getnm_sistema()){ echo "selected";}?>>Outro</option>
</select>
</label></br>
<label>
USUARIO:</br>
<input type="text" class="form-control" name ="nm_usuario" value="<?php echo $dado->getnm_usuario();?>"/>
</label>
<label>
SENHA:</br>
<input type="text" class="form-control" name ="senha" value="<?php echo $dado->getsenha();?>"/>
</label></br>
<label>
OBSERVAÇÕES:</br>
<textarea class="form-control" rows="3" id="comment" style="width: 420px;" name="obs"><?php echo $dado->getobs();?></textarea>
</label><br></br>
<input class="btn btn-dark" type="submit" value="SALVAR"/>
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_cadastro.php'">VOLTAR</button>
</form>
<?php endforeach;?>
</body>
</div>