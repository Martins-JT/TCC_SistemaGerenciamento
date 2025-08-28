<?php
session_start();
include_once('conexao.php');
$produto = $_POST['novoproduto'] ?? '';
$caracteristica = $_POST['Ncaracteristica'] ?? '';
$peso = $_POST['novo_peso'] ?? '';
$unidade = $_POST['unidades'] ?? '';
$descricao = $_POST['desc'] ?? '';
$categoria = $_POST['nova_categoria'] ?? '';
$fornecedor = $_SESSION['id'] ?? '';
/* $foto = $_SESSION['foto'] ?? ''; */
$valor = str_replace(',', '.', $_POST['novo_valor']);
$status = 1;
/* $produto = $_POST['test'];
$caracteristica = $_POST['test1']; */


$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');

$sql = "INSERT INTO produtos(id_fornecedor, produto, caracteristica, peso_unidade, estoque, descricao, categoria, valor, status) 
values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("issssssdi", $fornecedor, $produto, $caracteristica, $peso, $unidade, $descricao, $categoria, $valor, $status);

$stmt->execute();

/*
TESTAR ERROS
if ($resultado)
{
    echo "Dados inseridos.";
}
else
{
echo "Erro ao inserir: " . mysqli_error($conexao);
}

*/




$stmt->close();
$conexao->close();
header('location: ../arquivos_site/paginas/requisicoes.php');
exit;
?>