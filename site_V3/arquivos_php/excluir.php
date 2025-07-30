<?php
include_once('conexao.php');
$id = $_POST['id'];
echo $id;
$conexao = new mysqli("localhost", "root", "", "entrega");

$delete = "DELETE from ofertas where id_oferta = ?";

$stmt2 = $conexao->prepare($delete);

$stmt2->bind_param('i', $id);

$stmt2->execute();

$stmt2->close();
$conexao->close();
header('location: ../arquivos_site/paginas/adminhome.php');
exit;
?>
