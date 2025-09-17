<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
include_once('conexao.php');
$id_oferta = $_POST['id'] ?? null;
$id_vitrine = $_POST['id_vitrine'] ?? null;
$id_produto = $_POST['id_produto'];
$status = true;
$id = $id_oferta ?? $id_vitrine;
if ($id)
{
echo $id;
$update = $conexao->prepare("UPDATE produtos set estado_produto = ? where id_produto = ?;");
$update->bind_param('ii', $status, $id_produto);
$update->execute();
$update->close();

$status = false;
$update = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?;");
$update->bind_param('ii', $status, $id);
$update->execute();
$update->close();
}
if ($id_vitrine){
$update = $conexao->prepare("UPDATE ofertas set exibir_vitrine = ? where id_oferta = ?;");
$update->bind_param('ii', $status, $id_vitrine);
$update->execute();
$update->close();
}
$conexao->close();
}
header('location: ../arquivos_site/paginas/adminhome.php');
exit;
?>
