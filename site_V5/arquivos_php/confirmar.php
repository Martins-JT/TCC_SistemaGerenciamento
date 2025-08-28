<?php
include_once('conexao.php');
$id = $_POST['id'];

$update = $conexao->prepare("UPDATE ofertas set status = false where id_oferta = ?;");
$update->bind_param('i', $id);
$update->execute();
$update->close();

$dados_oferta = $conexao->prepare("SELECT id_fornecedor, id_produto FROM ofertas where id_oferta = ?");
$dados_oferta->bind_param('i', $id);
$dados_oferta->execute();
$data_criacao = date('Y-m-d');
$status = false;
$dados_oferta->bind_result($id_fornecedor, $id_produto);

// Faz o fetch (carrega os dados nas variáveis acima)
$dados_oferta->fetch();
$dados_oferta->close();

$stmt = $conexao->prepare("INSERT INTO contratos(fornecedor_id, produto_id, id_oferta, data_criacao) VALUES(?, ?, ?, ?)");

$stmt->bind_param("iiis", $id_fornecedor, $id_produto, $id, $data_criacao);
$stmt->execute();



$stmt->close();
mysqli_close($conexao);
header('location: ../arquivos_site/paginas/adminhome.php');
exit;
?>