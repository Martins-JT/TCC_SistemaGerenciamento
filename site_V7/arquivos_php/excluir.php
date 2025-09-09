<?php
include_once('conexao.php');
$id = $_POST['id'];
$id_produto = $_POST['id_produto'];
$status = true;


$update = $conexao->prepare("UPDATE produtos set status = ? where id_produto = ?;");
$update->bind_param('ii', $status, $id_produto);
$update->execute();
$update->close();

$status = false;
$update = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?;");
$update->bind_param('ii', $status, $id);
$update->execute();
$update->close();

$conexao->close();
header('location: ../arquivos_site/paginas/adminhome.php');
exit;
?>
