<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
session_start();
include_once('conexao.php');
$id_oferta = $_POST['id']?? null;
$id_vitrine = $_POST['id_vitrine'] ?? null;
$valorfinal = $_POST['valor_final'];
$status = 0;
$id = $id_oferta ?? $id_vitrine;
$comprador = $_SESSION['id'];
echo $id;
$update = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?");
$update->bind_param('ii', $status, $id);
$update->execute();
$update->close();

if ($id_vitrine){
    $update_vitrine = $conexao->prepare("UPDATE ofertas set exibir_vitrine = ? where id_oferta = ?");
    $update_vitrine->bind_param('ii', $status, $id);
    $update_vitrine->execute();
    $update_vitrine->close();
}

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

$stmt = $conexao->prepare("INSERT INTO contratos(fornecedor_id, produto_id, comprador, id_oferta, data_criacao, validade, 
valor_final) VALUES(?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iiiissd", $id_fornecedor, $id_produto, $comprador, $id, $data_criacao, $data_validade, $valorfinal);
$stmt->execute();



$stmt->close();
mysqli_close($conexao);
if ($_SESSION['permissoes'] == 'admin'){
header('Location: ../arquivos_site/paginas/adminhome.php');
exit;
}
header('Location: ../arquivos_site/paginas/fornecedor.php');
exit;
}
else
{
    header('Location: ../index.html');
    exit;
}
?>