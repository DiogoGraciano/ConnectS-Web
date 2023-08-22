<head>
<div class="container-xxl" >
<h1>ADICIONAR CLIENTE</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<form method="POST" action="action_adicionar_cliente.php">
<label>
NOME:</br>
<input type="text" name ="nome"/>
</label><br></br>
<label>
LOJA:</br>
<input type="number" name ="nrloja"/>
</label><br></br>
<input type="submit" class="btn btn btn-dark" value="ADICIONAR"/>
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_cliente.php'">VOLTAR</button>
</form>
</body>
</div>