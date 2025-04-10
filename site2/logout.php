<?php
session_start(); // Inicia a sessão
session_unset(); // Remove todas as variáveis da sessão
session_destroy(); // Destroi a sessão
header('Location: index.html'); // Redireciona para a página inicial
exit();
?>
