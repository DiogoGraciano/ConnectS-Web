<?php
require '../config/config.php';
require 'classes/conexaoDaoPgsql.php';
require_once 'classes/conexao.php';

$conexaoDAO = new conexaoDaoPgsql($pdo);
$dados = $conexaoDAO->findall_conexao();
?>
<head>
<div class="container-xxl" >
<h1>CONSULTA CONEXÃO</h1>
<br/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<form method="POST">
<label>
PESQUISA:
<input type="text" name ="pesquisa"/>
</label>
<input type="submit" class="btn btn-dark" value="Pesquisar"/>
</form>
<?php
$pesquisa = filter_input(INPUT_POST, 'pesquisa');

if (is_numeric($pesquisa)){
    $dados = $conexaoDAO->findbycd_cliente($pesquisa); 
    $dado = $dados;
}
else if (is_string($pesquisa)){
    $conexao = new conexao; 
    $conexao -> setnm_cliente($pesquisa);
    $dados = $conexaoDAO->findbynm_cliente($conexao);
}
else if ($pesquisa === null){
    $dados = $conexaoDAO->findall_conexao();
}
?>

<button class="btn btn-dark" onclick="location.href='adicionar_conexao.php'" type="button">Adicionar Conexão</button>
<br>
<br>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script>
<table border="1" width="100%" class="sortable">
    <th width="1%"></th>
    <th width="2%">CD</th>
    <!--<th width="5%">CD CLIENTE</th>-->
    <th width="15%">NOME CLIENTE</th>
    <th width="2%">LOJA</th>
    <th width="10%">ID CONEXÃO</th>
    <th width="10%">TERMINAL</th>
    <th width="2%">CAIXA</th>
    <th width="10%">PROGRAMA</th>
    <th width="10%">USUARIO</th>
    <th width="10%">SENHA</th>
    <th width="10%">OBSERVAÇÕES</th>
    <th width="11.2%">AÇÕES</th>
    <?php 
    foreach($dados as $dado):  
    ?>
    <tr>
        <td></td>
        <td><?php echo $dado->getcd_conexao();?></td>
        <!--<td><?php echo $dado->getcd_cliente();?></td>-->
        <td><?php echo $dado->getnm_cliente();?></td>
        <td><?php echo $dado->getnr_loja();?></td>
        <td><?php echo $dado->getid_conexao();?></td>
        <td><?php echo $dado->getnm_terminal();?></td>
        <td><?php echo $dado->getnr_caixa();?></td>
        <td><?php echo $dado->getnm_programa();?></td>
        <td><?php echo $dado->getnm_usuario();?></td>
        <td><?php echo $dado->getsenha();?></td>
        <td><?php echo $dado->getobs();?></td>
        <td>
        <button type="button" class="btn btn btn-dark">
            <a href='editar_conexao.php?cd=<?php echo $dado->getcd_conexao();?>'>Editar</a>
        </button>
        <button class="btn btn btn-dark" onclick="return confirm('Deseja Excluir? (Irá excluir todas as conexões e usuarios desse conexao)')" type="button">
            <a href='action_excluir_conexao.php?cd=<?php echo $dado->getcd_conexao();?>'>Excluir</a>
        </button>
        </td>
    <tr>
    <?php endforeach;?>
</table>
</body>
</div>