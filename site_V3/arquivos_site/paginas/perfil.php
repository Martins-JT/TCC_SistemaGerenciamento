<?php
include_once('sidebar.php');


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <div class="container">

        <table border="1">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Senha</th>
            <th>Foto</th>
            
            <th>Alterar</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
     <?php
     include_once('../../arquivos_php/conexao.php');
    $conexao = new mysqli('localhost', 'root', '', 'entrega');
    $usuario = $_SESSION['usuario'];
    $sql = "SELECT id, usuario, senha, foto from informacoes where usuario = '$usuario'";

    $resultado = mysqli_query($conexao, $sql);

    while($dados = $resultado->fetch_assoc())
    {
        echo $dados['id'];
        ?>
        <tr>
            <td> <?php echo $dados['usuario']; ?> </td>
            <td> <?php echo $dados['senha']; ?> </td>
            <td> <?php echo $dados['foto']; ?> </td>
            
            
            <td> <a href="../../arquivos_php/alterar.php"> <button type="button" id="editar"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M5 19h1.425L16.2 9.225L14.775 7.8L5 17.575zm-2 2v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM19 6.4L17.6 5zm-3.525 2.125l-.7-.725L16.2 9.225z"/></svg> </button> </td> </a>
            
            <td> <a href="../../arquivos_php/excluir.php"><button type="button" id="excluir"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/></svg></button></td></a>
            
        </tr>


        

<?php
    }

    mysqli_close($conexao);
?>



</table>



    </div>
</body>
</html>

<?php
 /*        <table border="1">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Produto1</th>
            <th>Produto2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Valor 1A</td>
            <td>Valor 1B</td>
            <td>Valor 1C</td>
        </tr>
 
    </tbody>
</table> */


?>