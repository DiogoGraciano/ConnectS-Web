<head>
<div class="container-xxl" >
<h1>ADICIONAR CONEXÃO</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<body>
<form method="POST" class="form-control" action="action_adicionar_ramal.php">
<label>
RAMAL:</br>
<input type="text" class="form-control" name ="nr_ramal" required/>
<label>
FUNCIONARIO:</br>
<input type="text" class="form-control" name ="nm_funcionario" required/>
</label>
<label>
TELEFONE:</br>
<input type="text" id="nr_telefone" minlength="8" maxlength="9" name="nr_telefone" class="form-control">
<script>
    $( "#nr_telefone" ).keypress(function() {
        $(this).mask('(00) 0000-00009');
    });
</script>
</label></br>
<label>
IP:</br>
<input type="text" class="form-control ip_address" minlength="4" maxlength="12"  id ="nr_ip" name ="nr_ip"/>
<script>
    $( "#nr_ip" ).keypress(function() {
        $(this).mask('099.099.099.099');
    });
</script>
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
<button type="button" class="btn btn btn-dark" onclick="location.href='consulta_ramal.php'">VOLTAR</button>
</form>
</body>
</div>