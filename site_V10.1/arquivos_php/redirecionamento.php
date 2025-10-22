<?php


function verificPermissao()
{

    if (!isset($_SESSION['usuario'])){
     header('Location: ../../index.html');
     exit;
    }

$paginaAtual = basename($_SERVER['PHP_SELF']); 
$permissao = $_SESSION['permissao'] ?? null;


$paginasesRestritas = [
        1 => ['adminhome.php', 'requisicoes.php', 'sidebar_admin.php', 'sidebar.php'], 
        2 => ['adminhome.php', 'requisicoes.php', 'sidebar_admin.php', 'ofertas_fornecedor.php', 
              'fornecedor.php', 'historico.php', 'notificacoes.php', 'sidebar.php', 'perfil.php'],                   
        4 => ['fornecedor.php', 'ofertas_fornecedor.php', 'sidebar.php', 'sidebar_admin.php']                
    ];

if ($permissao !== null && in_array($paginaAtual, $paginasesRestritas[$permissao] ?? [])) {

        if ($permissao == 1) {
            header('Location: fornecedor.php');
            exit();
        }
        if ($permissao == 2) {
            header('Location: suporte.php');
            exit();
        }
        if ($permissao == 4) {
            header('Location: adminhome.php');
            exit();
        }
    }
  
}


function incluirSidebar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $permissao = $_SESSION['permissao'] ?? null;

    // Fecha a sessão de leitura
    session_abort();

    if ($permissao == 4) {
        include_once('sidebar_admin.php');
    } else {
        include_once('sidebar.php');
    }
}

?>