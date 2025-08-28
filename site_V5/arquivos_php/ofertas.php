<?php
session_start();
include_once('conexao.php');


/* $produto = $_POST['produtoo'];
$caracteristica = $_POST['produtoo1'];
$peso = $_POST['pesoU'];
$estoque = $_POST['estoque'];
$descricao = $_POST['descricao'];
$categoria= $_POST['categoria']; */
$dias = $_POST['dias'];
$id = $_SESSION['id'];
$id_produto = $_POST['produto_id'];
$valor = str_replace(',', '.', $_POST['valor']);
date_default_timezone_set('America/Sao_Paulo');
$data_inicio = date('Y-m-d H:i:s');
$status = true;

$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');



$sql = "INSERT INTO ofertas(id_fornecedor, id_produto,
data_inicio, dias, status) 
VALUES(?, ?, ?, ?, ?)";

// '$usuario', '$produto', '$caracteristica'
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iisii", $id, $id_produto,
$data_inicio, $dias, $status);
$stmt->execute(); 



/* $produtos = $_POST['datas'];
$ultimo_id = $conexao->insert_id; 
/* $ultimo_id = $_POST['produto_id1']; 
$_SESSION['ultimo_id'] = $ultimo_id;
echo "Produto cadastrado. ID: " . $ultimo_id;
echo "<br> <br>". $produtos;
$_SESSION['datas'] = $produtos;
echo $_SESSION['datas']; */
/* 

$dados = "SELECT usuario, produto, caracteristica FROM produtos ORDER BY id DESC";
$resultado2 = mysqli_query($conexao, $dados);



if ($resultado2->num_rows > 0)
{
   while($linha = mysqli_fetch_assoc($resultado2))
    {
        $_SESSION['usuario'] = $linha['produto'];
        $_SESSION['produto'] = $linha['caracteristica'];
        echo $_SESSION['produto'];
    } 

        if($linha = mysqli_fetch_assoc($resultado2))
        {
            $_SESSION['usuario'] = $linha['produto'];
        $_SESSION['produto'] = $linha['caracteristica'];
        echo $_SESSION['produto'];
        }
} */
/* $stmt->close(); */
$stmt->close();
mysqli_close($conexao);
header('location: ../arquivos_site/paginas/requisicoes.php');
exit;
?>