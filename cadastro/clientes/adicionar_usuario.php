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
ID CONEXÃO:</br>
<input type="text" name ="id_usuario" class="form-control" style="width: 420px;" required/>
</label></br>
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
CAIXA:</br>
<input type="number" class="form-control" name ="nr_caixa" style="width: 60px;" min="1" max="99" />
</label>
<label>
PROGRAMA:</br>
<select class="form-select" name ="nm_programa" style="width: 175px;" required>
  <option>Anydesk</option>
  <option>Teamviwer</option>
  <option>NetSuporte</option>
  <option>Ruskdesk</option>
  <option>WTS</option>
  <option>Radmin</option>
  <option>VNC</option>
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
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_usuario.php'">VOLTAR</button>
</form>
</body>
</div>