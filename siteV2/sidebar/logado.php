<?php
session_start(); // Inicia a sessão
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: index.html'); // Redireciona para a página inicial se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <button id="btn-abrir"> <i class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 8V7h17v1zm17 4v1H3v-1zM3 17h17v1H3z"/></svg> </i> </button>
    <nav class="side-menu" id="side">
    <div id="expandir">
    <ul>
        
        
        <li class="menu-item">
            <a href="#">
                
                <i class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m16 8.41l-4.5-4.5L4.41 11H6v8h3v-6h5v6h3v-8h1.59L17 9.41V6h-1zM2 12l9.5-9.5L15 6V5h3v4l3 3h-3v8h-5v-6h-3v6H5v-8z"/></svg> </i>
                <span class="text-items">Home </span>

            </a>
        </li>
            <li class="menu-item">
                <a href="#">
    
                    <i class="icons"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 5V4h17v1zm0 4V8h17v1zm0 4v-1h17v1zm0 4v-1h17v1zm0 4v-1h17v1z"/></svg></i>
                    <span class="text-items"> Requisições </span>
    
                </a>
            </li>

                <li class="menu-item">
                    <a href="#">
        
                        <i class="icons"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5a.5.5 0 0 0-.5-.5a.5.5 0 0 0-.5.5v1.53c-2.25.25-4 2.15-4 4.47v5.91L5.41 18h12.18L16 16.41V10.5c0-2.32-1.75-4.22-4-4.47zM11.5 3A1.5 1.5 0 0 1 13 4.5v.71c2.31.65 4 2.79 4 5.29V16l3 3H3l3-3v-5.5C6 8 7.69 5.86 10 5.21V4.5A1.5 1.5 0 0 1 11.5 3m0 19a2.5 2.5 0 0 1-2.45-2h1.04a1.495 1.495 0 0 0 2.82 0h1.04a2.5 2.5 0 0 1-2.45 2"/></svg> </i>
                        <span class="text-items"> Notificações </span>
        
                    </a>
                </li>
                    <li class="menu-item">
                        <a href="#">
            
                            <i class="icons"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 3h13a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-4.59l-3.7 3.71c-.18.18-.43.29-.71.29a1 1 0 0 1-1-1v-3H5a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3m13 1H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h4v4l4-4h5a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2"/></svg></i>
                            <span class="text-items"> Em Aberto </span>
            
                        </a>
                    </li>
        
                    
                    

    </ul>
    <button type="submit" id="logout"> <i class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16"><g fill="#fff" fill-rule="evenodd"><path d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/><path d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/></g></svg> </i> <span class="text-items"> Logout </span> </button>
    

</div>
</nav>
   
<script>
 document.getElementById('btn-abrir').addEventListener('click', function () {
    document.getElementById('side').classList.toggle('expandir');
});

  </script>
</body>
</html>
