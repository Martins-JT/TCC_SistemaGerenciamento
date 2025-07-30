<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    
include_once('conexao.php');
$usuario = $_POST['email'];
$senha = $_POST['senha'];


$conexao = new mysqli('localhost','root','','entrega');

if($conexao->connect_error)
{
    die("Erro na conexão: " . $conexao->connect_error);
}

// where significa: "Busque a senha da tabela tabela_usuarios somente para o usuário cujo 
// nome de usuário (usuario) corresponde ao valor fornecido.".
$sql = 'SELECT senha, usuario, permissoes FROM informacoes WHERE usuario = ?';
// Se o usuário digita joao no login, a consulta executada será algo equivalente a: 
// SELECT senha FROM tabela_usuarios WHERE usuario = 'joao' 
// Isso faz com que o script recupere apenas a senha associada a 'joao'.

$stmt = $conexao->prepare($sql);
$stmt->bind_param('s', $usuario);

$stmt->execute();



$result = $stmt->get_result();


// explicações do getresult em outro arquivo
if ($result->num_rows === 1) 

{

    $row = $result->fetch_assoc();
    $hash_salvo = $row['senha'];
    


  


    if (password_verify($senha, $hash_salvo)) 
{
    
        session_start();
        
        $_SESSION['usuario'] = $usuario;
        $permissao = $row['permissoes'];
        if($permissao == 'usuario')
    {
        $_SESSION['permissoes'] = $permissao;
        
        header('location: ../arquivos_site/paginas/fornecedor.php');
        exit;
    }
    else if ($permissao == 'admin')
    {
        $_SESSION['permissoes'] = $permissao;
        header('location: ../arquivos_site/paginas/adminhome.php');
        exit;
    }
} 
    else 
    {
        // Senha incorreta
        echo "Senha incorreta";
        header('location: ../index.html?login_invalido=1');
        exit;
    }





}
else {
    //Usuário não encontrado
    echo "Usuário não encontrado";
    header('location: ../index.html?login_invalido=1');
    exit;
}
$stmt->close();
$conexao->close();
}




?>