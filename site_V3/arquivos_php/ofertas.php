<?php
session_start();
include_once('conexao.php');


$produto = $_POST['produtoo'];
$caracteristica = $_POST['produtoo1'];
$peso = $_POST['pesoU'];
$estoque = $_POST['estoque'];
$descricao = $_POST['descricao'];
$categoria= $_POST['categoria'];
$foto = $_SESSION['foto'];
$dias = $_POST['dias'];

$conexao = new mysqli('localhost','root','','entrega');

$usuario = $_SESSION['usuario'];

$sql = "INSERT INTO ofertas(usuario, foto, produto, caracteristica, peso_unidade, estoque, descricao, categoria, dias) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
// '$usuario', '$produto', '$caracteristica'
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssssssss", $usuario, $foto, $produto, $caracteristica, $peso, $estoque, $descricao, $categoria, $dias);
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