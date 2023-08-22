<?php
require '../config/config.php';
require '../cliente/classes/clienteDaoPgsql.php';

$clienteDAO = new clienteDaoPgsql($pdo);
$clientes = $clienteDAO -> findall_cliente();

?>
<head>
<div class="container-xxl" >
<h1>ADICIONAR CONEXÃO</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<form method="POST" class="form-control" action="action_adicionar_usuario.php">
<label>
CLIENTE:</br>
<select class="form-select" name ="cd_cliente" required>
<?php foreach($clientes as $cliente): ?>
    <option value="<?php echo $cliente->getcd_cliente();?>"><?php echo $cliente->getnm_cliente();echo " Loja: ";echo $cliente->getnr_loja();?></option>
<?php endforeach; ?>
</select>
<label>
TERMINAL:</br>
<select class="form-select" name ="nm_terminal" style="width: 175px;" required>
  <option>Balcão</option>
  <option>Deposito</option>
  <option>Escritorio</option>
  <option>Frente De Caixa</option>
  <option>Servidor APP</option>
  <option>Servidor Super</option>
  <option>Servidor SITEF</option>
</select>
</label>
<label>
SISTEMA:</br>
<select class="form-select" name ="nm_sistema" style="width: 175px;" required>
  <option>Windows</option>
  <option>Linux</option>
  <option>Mac OS</option>
  <option>TEF Web</option>
  <option>Token Email</option>
  <option>Outro</option>
</select>
</label></br>
<label>
USUARIO:</br>
<input type="text" class="form-control" name ="nm_usuario"/>
</label>
<label>
SENHA:</br>
<input type="text" class="form-control" name ="senha"/>
</label></br>
<label>
OBSERVAÇÕES:</br>
<textarea class="form-control" rows="3" id="comment" style="width: 420px;" name="obs"></textarea>
</label><br></br>
<input type="submit" class="btn btn btn-dark" value="ADICIONAR"/>
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_cadastro.php'">VOLTAR</button>
</form>
</body>
</div>