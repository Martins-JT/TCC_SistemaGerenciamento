<?php
session_start(); // Inicia a sessão
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: index.html'); // Redireciona para a página inicial se não estiver logado
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=<div>, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="logado.css">
</head>
<body>


</body>
</html>