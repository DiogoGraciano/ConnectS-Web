<?php
require 'config.php';
$dados = [];
$sql = $pdo->query('select * from cadastro.tb_cliente');
if ($sql ->rowCount() > 0){
    $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
}
?>
<br>
<button onclick="location.href='adicionar_cliente.php'" type="button">Adicionar Cliente</button>
<br>
<br>
<table border="1" width="100%">
    <th>CODIGO</th>
    <th>NOME CLIENTE</th>
    <th>NUMERO LOJA</th>
    <th>AÇÕES</th>
    <?php foreach($dados as $dado): ?>
    <tr>
        <td><?php echo $dado['cd_cliente'];?></td>
        <td><?php echo $dado['nm_cliente'];?></td>
        <td><?php echo $dado['nr_loja'];?></td>
        <td>
        <button type="button"><a href='editar_cliente.php?cd=<?php echo $dado['cd_cliente'];?>'>Editar</a></button>
        <button onclick="return confirm('Deseja Excluir?')" type="button"><a href='action_excluir_cliente.php?cd=<?php echo $dado['cd_cliente'];?>'>Excluir</a></button>
        </td>
    <tr>
    <?php endforeach; ?>
</table>
