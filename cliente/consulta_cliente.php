<?php
require '../config/config.php';
require 'classes/cliente.php';
require 'classes/clienteDaoPgsql.php';

$clienteDAO = new clienteDaoPgsql($pdo);
$dados = $clienteDAO->findall_cliente();
?>
<head>
<div class="container-xxl" >
<h1>CONSULTA CLIENTE</h1>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<body>
<label>
PESQUISA:
<input class="form-control" type="text" name ="pesquisa" id ="pesquisa"/>
</label>
<br>
</br>
<button class="btn btn-dark" onclick="location.href='adicionar_cliente.php'" type="button">Adicionar Cliente</button>
<br>
</br>
<table id="ctabela" width="100%" class="sortable table table-hover table-bordered table-sm caption-top">
    <thead>
        <tr>
            <th width="10%">CODIGO</th>
            <th>NOME CLIENTE</th>
            <th width="10%">LOJA</th>
            <th width="13%">AÇÕES</th>
        </tr>
    </thead>
    <tbody id="tabelac">
        <?php 
        foreach($dados as $dado):  
        ?>
        <tr>
            <td><?php echo $dado->getcd_cliente();?></td>
            <td><?php echo $dado->getnm_cliente();?></td>
            <td><?php echo $dado->getnr_loja();?></td>
            <td>
            <button type="button" class="btn btn btn-dark">
                <a href='editar_cliente.php?cd=<?php echo $dado->getcd_cliente();?>'>Editar</a>
            </button>
            <button class="btn btn btn-dark" onclick="return confirm('Deseja Excluir? (Irá excluir todas as conexões e usuarios desse cliente)')" type="button">
                <a href='action_excluir_cliente.php?cd=<?php echo $dado->getcd_cliente();?>'>Excluir</a>
            </button>
            </td>
        <tr>
        <?php endforeach;?>
    </tbody>
</table>
</body>
<script>
$(document).ready(function(){
  $("#pesquisa").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabelac tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</div>