<?php
session_start();
include_once('conexao.php');


$produto = $_POST['produtoo'];
$produto2 = $_POST['produtoo1'];

$conexao = new mysqli('localhost','root','','entrega');

$usuario = $_SESSION['usuario'];

/* $sql = "INSERT INTO produtos(usuario, produto1, produto2) VALUES(?, ?, ?)";
// '$usuario', '$produto', '$produto2'
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sss", $usuario, $produto, $produto2);
$stmt->execute(); */


$produtos = $_POST['datas'];
/* $ultimo_id = $conexao->insert_id; */
$ultimo_id = $_POST['produto_id'];
$_SESSION['ultimo_id'] = $ultimo_id;
echo "Produto cadastrado. ID: " . $ultimo_id;
echo "<br> <br>". $produtos;
$_SESSION['datas'] = $produtos;
echo $_SESSION['datas'];
/* 

$dados = "SELECT usuario, produto1, produto2 FROM produtos ORDER BY id DESC";
$resultado2 = mysqli_query($conexao, $dados);



if ($resultado2->num_rows > 0)
{
   while($linha = mysqli_fetch_assoc($resultado2))
    {
        $_SESSION['usuario'] = $linha['produto1'];
        $_SESSION['produto1'] = $linha['produto2'];
        echo $_SESSION['produto1'];
    } 

        if($linha = mysqli_fetch_assoc($resultado2))
        {
            $_SESSION['usuario'] = $linha['produto1'];
        $_SESSION['produto1'] = $linha['produto2'];
        echo $_SESSION['produto1'];
        }
} */
/* $stmt->close(); */
mysqli_close($conexao);
?>