<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include_once('conexao.php');
if (!isset($_SESSION['usuario']))
{
    header('Location: ../index.html');
    exit;  
}

$id = $_POST['id'];
$status = 1;
$estado_produto = $conexao->prepare("select id_produto from ofertas where id_oferta = ?");
$estado_produto->bind_param('i', $id);
$estado_produto->execute();
$estado_produto->bind_result($id_produto);

$estado_produto->fetch();
$estado_produto->close();

if ($id)
{
echo $id;
$update = $conexao->prepare("UPDATE produtos set estado_produto = ? where id_produto = ?;");
$update->bind_param('ii', $status, $id_produto);
$update->execute();
$update->close();

$status = 0;
$update = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?;");
$update->bind_param('ii', $status, $id);
$update->execute();
$update->close();

$update = $conexao->prepare("UPDATE ofertas set exibir_vitrine = ? where id_oferta = ?;");
$update->bind_param('ii', $status, $id);
$update->execute();
$update->close();
}



$conexao->close();

}else {
    header('Location: ../index.html');
    exit;
}

  


?>