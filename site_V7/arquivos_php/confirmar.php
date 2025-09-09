<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
include_once('conexao.php');
$id = $_POST['id'];
$valorfinal = $_POST['valor_final'];
$status = 0;
$update = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?;");
$update->bind_param('ii', $status, $id);
$update->execute();
$update->close();

$dados_oferta = $conexao->prepare("SELECT id_fornecedor, id_produto, dias FROM ofertas where id_oferta = ?");
$dados_oferta->bind_param('i', $id);
$dados_oferta->execute();
$data_criacao = date('Y-m-d');
$dados_oferta->bind_result($id_fornecedor, $id_produto, $dias);

// Faz o fetch (carrega os dados nas variáveis acima)
$dados_oferta->fetch();
$dados_oferta->close();


$data = new DateTime($data_criacao);
$data->modify('+' . $dias . ' days');
$data_validade = $data->format('Y-m-d');

$stmt = $conexao->prepare("INSERT INTO contratos(fornecedor_id, produto_id, id_oferta, data_criacao, validade, 
valor_final) VALUES(?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iiissd", $id_fornecedor, $id_produto, $id, $data_criacao, $data_validade, $valorfinal);
$stmt->execute();



$stmt->close();
mysqli_close($conexao);
header('location: ../arquivos_site/paginas/adminhome.php');
exit;
}
else
{
    header('Location: ../index.html');
    exit;
}
?>