<?php
require '../config/config.php';
require 'classes/conexaoDaoPgsql.php';
require_once 'classes/conexao.php';
require 'classes/usuarioDaoPgsql.php';
require_once 'classes/usuario.php';

$conexaoDAO = new conexaoDaoPgsql($pdo);
$dadosc = $conexaoDAO->findall_conexao();
$usuarioDAO = new usuarioDaoPgsql($pdo);
$dadosu = $usuarioDAO->findall_usuario();
?>
<head>
<div class="container-xxl" >
<h1>CONSULTA CONEXÃO</h1>
<br/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
<button class="btn btn-dark" onclick="location.href='adicionar_conexao.php'" type="button">Adicionar Conexão</button>
<button class="btn btn-dark" onclick="location.href='adicionar_usuario.php'" type="button">Adicionar Usuario</button>
<br/>
<br/>
<label>
PESQUISA:
<input class="form-control" type="text" id="pesquisac"/>
</label>

<table id="ctabela" width="100%" class="sortable table table-hover table-bordered table-sm caption-top"> 
    <caption>Conexões</caption>
    <thead>
        <tr>
            <!--<th width="2%">CD</th>-->
            <!--<th width="5%">CLIENTE</th>-->
            <th width="15%">NOME CLIENTE</th>
            <th width="2%">LOJA</th>
            <th width="10%">ID CONEXÃO</th>
            <th width="10%">TERMINAL</th>
            <th width="2%">CAIXA</th>
            <th width="10%">PROGRAMA</th>
            <th width="10%">USUARIO</th>
            <th width="10%">SENHA</th>
            <th width="10%">OBSERVAÇÕES</th>
            <th width="12%">AÇÕES</th>
        </tr>
    </thead>
    <tbody id="tabelac">
    <?php 
    foreach($dadosc as $dadoc):  
    ?>
    <tr>   
        <!--<td><?php echo $dadoc->getcd_conexao();?></td>-->
        <!--<td><?php echo $dadoc->getcd_cliente();?></td>-->
        <td><?php echo $dadoc->getnm_cliente();?></td>
        <td><?php echo $dadoc->getnr_loja();?></td>
        <td><?php echo $dadoc->getid_conexao();?></td>
        <td><?php echo $dadoc->getnm_terminal();?></td>
        <td><?php echo $dadoc->getnr_caixa();?></td>
        <td><?php echo $dadoc->getnm_programa();?></td>
        <td><?php echo $dadoc->getnm_usuario();?></td>
        <td><?php echo $dadoc->getsenha();?></td>
        <td><?php echo $dadoc->getobs();?></td>
        <td>
        <button type="button" class="btn btn btn-dark">
            <a href='editar_conexao.php?cd=<?php echo $dadoc->getcd_conexao();?>'>Editar</a>
        </button>
        <button class="btn btn btn-dark" onclick="return confirm('Deseja Excluir? (Irá excluir todas as conexões e usuarios desse conexao)')" type="button">
            <a href='action_excluir_conexao.php?cd=<?php echo $dadoc->getcd_conexao();?>'>Excluir</a>
        </button>
        </td>   
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<label>
PESQUISA:
<input class="form-control" type="text" id="pesquisau"/>
</label>
<table id="utabela" width="100%" class="sortable table table-hover table-bordered table-sm caption-top"> 
<caption>Usuarios</caption>  
    <thead>
    <!--<th width="2%">CD</th>-->
    <!--<th width="5%">CD CLIENTE</th>-->
        <tr>
            <th width="15%">NOME CLIENTE</th>
            <th width="2%">LOJA</th>
            <th width="10%">TERMINAL</th>
            <th width="10%">SISTEMA</th>
            <th width="10%">USUARIO</th>
            <th width="10%">SENHA</th>
            <th width="10%">OBSERVAÇÕES</th>
            <th width="11.2%">AÇÕES</th>
        </tr>
    </thead>
    <tbody id="tabelau">
    <?php 
    foreach($dadosu as $dadou):  
    ?>
    <tr>
        <!--<td><?php echo $dadou->getcd_usuario();?></td>-->
        <!--<td><?php echo $dadou->getcd_cliente();?></td>-->
        <td><?php echo $dadou->getnm_cliente();?></td>
        <td><?php echo $dadou->getnr_loja();?></td>
        <td><?php echo $dadou->getnm_terminal();?></td>
        <td><?php echo $dadou->getnm_sistema();?></td>
        <td><?php echo $dadou->getnm_usuario();?></td>
        <td><?php echo $dadou->getsenha();?></td>
        <td><?php echo $dadou->getobs();?></td>
        <td>
        <button type="button" class="btn btn btn-dark">
            <a href='editar_usuario.php?cd=<?php echo $dadou->getcd_usuario();?>'>Editar</a>
        </button>
        <button class="btn btn btn-dark" onclick="return confirm('Deseja Excluir? (Irá excluir todas as conexões e usuarios desse usuario)')" type="button">
            <a href='action_excluir_usuario.php?cd=<?php echo $dadou->getcd_usuario();?>'>Excluir</a>
        </button>
        </td>    
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<script>
$(document).ready(function(){
  $("#pesquisac").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabelac tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
$(document).ready(function(){
  $("#pesquisau").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabelau tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</div>