<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
session_start();
include_once('conexao.php');
if (!isset($_SESSION['usuario']))
{
    header('Location: ../index.html');
    exit;  
}
$produto = $_POST['novoproduto'] ?? '';
$caracteristica = $_POST['Ncaracteristica'] ?? '';
$peso = $_POST['novo_peso'] ?? '';
$unidade = $_POST['unidades'] ?? '';
$descricao = $_POST['desc'] ?? '';
$categoria = $_POST['nova_categoria'] ?? '';
$fornecedor = $_SESSION['id'] ?? '';
$marca = $_POST['nova_marca'] ?? '';
$medida = $_POST['nova_medida'] ?? '';
$check_vitrine = filter_var($_POST['check_vitrine'], FILTER_VALIDATE_BOOLEAN);
$valor = str_replace(',', '.', $_POST['novo_valor']);
$status = 1;




$sql = "INSERT INTO produtos(id_fornecedor, produto, caracteristica, peso_unidade, estoque, descricao, 
categoria, marca, unidade_medida, valor, estado_produto, exibir_vitrine) 
values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("issssssssdii", $fornecedor, $produto, $caracteristica, $peso, $unidade, $descricao, $categoria, 
$marca, $medida, $valor, $status, $check_vitrine);

$stmt->execute();






$stmt->close();
$conexao->close();
}
if ($_SESSION['permissao'] == 1){
header('location: ../arquivos_site/paginas/ofertas_fornecedor.php');
exit;
}
else{
header('location: ../arquivos_site/paginas/requisicoes.php');
exit;
}
?>