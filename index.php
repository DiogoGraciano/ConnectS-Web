<head>
    <link href="estilo.css" rel="stylesheet" />
</head>
<header>
</header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
    <div class="login" >
        <div class="form_login" >
            <h1>LOGIN</h1>
            <form method="POST" class="form_login" action="action_login.php">
                <label>
                    USUARIO:
                    <input type="text" class="form-control" name ="nm_usuario" required/>
                </label>
                <label>
                    SENHA:
                    <input type="text" class="form-control" name ="senha" required/>
                </label>
                    <input type="submit" class="form-control btn btn-primary" value="ENTRAR" required/>
            </form>
        </div>
    </div>    
</body>