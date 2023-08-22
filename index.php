<head>
<div class="container-xxl" >
<h1>LOGIN</h1>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<body>
<form method="POST" class="form-control" action="action_login.php">
<label>
USUARIO:</br>
<input type="text" class="form-control" name ="nm_usuario" required/>
<label>
SENHA:</br>
<input type="text" class="form-control" name ="senha" required/>
</label>
</br></br>
<input type="submit" class="form-control" value="ENTRAR" required/>
</form>
