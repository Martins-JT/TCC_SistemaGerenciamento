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
<!-- Ícone de menu (3 pontos) -->
<div class="menu-icon" id="menu-icon">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Aba lateral -->
    <div class="side-menu" id="side-menu">
        <h2>Menu</h2>
        <ul>
            <li><a href="logout.php">Sair</a></li>
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Serviços</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
    </div>

    <script>
        // Obtendo elementos
        const menuIcon = document.getElementById('menu-icon');
        const sideMenu = document.getElementById('side-menu');

        // Função para alternar a classe 'open' e abrir/fechar a aba lateral
        menuIcon.addEventListener('click', () => {
            sideMenu.classList.toggle('open');
        });
    </script>

</body>
</html>