<?php
session_start();
include_once('conexao.php');
$produto = $_POST['novoproduto'];
$caracteristica = $_POST['Ncaracteristica'];
$peso = $_POST['novo_peso'];
$unidade = $_POST['unidades'];
$descricao = $_POST['desc'];
$categoria = $_POST['nova_categoria'];
$usuario = $_SESSION['usuario'];
$foto = $_SESSION['foto'];

/* $produto = $_POST['test'];
$caracteristica = $_POST['test1']; */


$conexao = new mysqli('localhost','root','','entrega');

$sql = "INSERT INTO produtos(usuario, foto, produto, caracteristica, peso_unidade, estoque, descricao, categoria) values(?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssssssss", $usuario, $foto, $produto, $caracteristica, $peso, $unidade, $descricao, $categoria);

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