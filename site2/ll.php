<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
$a = $_POST["test"];
$email1 = $_POST["email"];
$senha = $_POST["senha"];
$d = "aaa.html";
$inicio = "index.html";
$email2 = $_POST["emaill"];
$senha2 = $_POST["senhaa"];

session_start();

    if ($email1 == 'a@a' && $senha == '123') {
        $_SESSION['usuario_logado'] = 'jose'; // Salva informações na sessão
        header('Location: aaa.php'); // Redireciona para a página protegida
        exit();
}
else
header("Location: $inicio");



}




//header("Location: $d"); 
//exit();
?>








