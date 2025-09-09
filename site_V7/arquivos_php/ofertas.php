<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
session_start();
include_once('conexao.php');

$dias = $_POST['dias'];
$id = $_SESSION['id'];
$id_produto = $_POST['produto_id'];
$valor = str_replace(',', '.', $_POST['valor']);
date_default_timezone_set('America/Sao_Paulo');
$data_inicio = date('Y-m-d H:i:s');
$status = 1;



$dados_recebidos = $conexao->prepare("SELECT exibir_vitrine FROM produtos where id_produto = ?");
$dados_recebidos->bind_param('i', $id_produto);
$dados_recebidos->execute();
$dados_recebidos->bind_result($vitrine_status);

$dados_recebidos->fetch();
$dados_recebidos->close();


$status = 0;
$update = $conexao->prepare("UPDATE produtos set estado_produto = ? where id_produto = ?");
$update->bind_param('ii', $status, $id_produto);
$update->execute();
$update->close();



$sql = "INSERT INTO ofertas(id_fornecedor, id_produto,
data_inicio, dias, status, exibir_vitrine) 
VALUES(?, ?, ?, ?, ?, ?)";
$status = 1;
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iisiii", $id, $id_produto,
$data_inicio, $dias, $status, $vitrine_status);
$stmt->execute(); 



$stmt->close();
mysqli_close($conexao);
header('location: ../arquivos_site/paginas/requisicoes.php');
exit;
}
else{
    header('Location: ../index.html');
    exit;
}
?>