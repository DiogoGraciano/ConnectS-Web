<?php
require '../config/config.php';
require 'classes/ramalDaoPgsql.php';
require_once 'classes/ramal.php';

$ramalDAO = new ramalDaoPgsql($pdo);
$dados = $ramalDAO->findall_ramal();
?>
<head>
<div class="container-xxl" >
<h1>CONSULTA RAMAL</h1>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
<label>
PESQUISA:
<input class="form-control" type="text" name ="pesquisa" id ="pesquisa"/>
</label>
<br>
<br>
<button class="btn btn-dark" onclick="location.href='adicionar_ramal.php'" type="button">Adicionar ramal</button>
<br>
<br>
<table id="rtabela" width="100%" class="sortable table table-hover table-bordered table-sm caption-top">
    <thead>
        <tr>
            <th width="20%">FUNCIONARIO</th>
            <th width="2%">RAMAL</th>
            <th width="10%">TELEFONE</th>
            <th width="9%">IP</th>
            <th width="10%">USUARIO</th>
            <th width="10%">SENHA</th>
            <th width="20%">OBSERVAÇÕES</th>
            <th width="11.2%">AÇÕES</th>
        </tr>
    </thead>
    <tbody id="tabelar">
    <?php 
    foreach($dados as $dado):  
    ?>
        <tr>
            <td><?php echo $dado->getnm_funcionario();?></td>
            <td><?php echo $dado->getnr_ramal();?></td>
            <td><?php echo $dado->getnr_telefone();?></td>
            <td><?php echo $dado->getnr_ip();?></td>
            <td><?php echo $dado->getnm_usuario();?></td>
            <td><?php echo $dado->getsenha();?></td>
            <td><?php echo $dado->getobs();?></td>
            <td>
            <button type="button" class="btn btn btn-dark">
                <a href='editar_ramal.php?cd=<?php echo $dado->getcd_ramal();?>'>Editar</a>
            </button>
            <button class="btn btn btn-dark" onclick="return confirm('Deseja Excluir? (Irá excluir todas as conexões e ramals desse ramal)')" type="button">
                <a href='action_excluir_ramal.php?cd=<?php echo $dado->getcd_ramal();?>'>Excluir</a>
            </button>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody> 
</table>
<script>
$(document).ready(function(){
  $("#pesquisa").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabelar tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</div>