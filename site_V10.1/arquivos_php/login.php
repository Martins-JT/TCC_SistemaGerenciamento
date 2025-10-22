<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    
include_once('conexao.php');
$email = $_POST['email'];
$senha = $_POST['senha'];


$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');

if($conexao->connect_error)
{
    die("Erro na conexão: " . $conexao->connect_error);
}


$sql = 'SELECT id, senha, email, permissao, nome_empresa, foto FROM fornecedores WHERE email = ?';


$stmt = $conexao->prepare($sql);
$stmt->bind_param('s', $email);

$stmt->execute();



$result = $stmt->get_result();

if ($result->num_rows === 0){
$sql = 'SELECT id, nome, senha, email, permissao, foto FROM suportes WHERE email = ?';
$stmt = $conexao->prepare($sql);
$stmt->bind_param('s', $email);

$stmt->execute();
$result = $stmt->get_result();
}

// explicações do getresult em outro arquivo
if ($result->num_rows === 1) 

{

    $row = $result->fetch_assoc();
    $hash_salvo = $row['senha'];

    if (password_verify($senha, $hash_salvo)) 
{
    
        session_start();
        
        $_SESSION['usuario'] = $email;
        $_SESSION['id'] = $row['id'];
        $_SESSION['empresa'] = $row['nome_empresa'];
        $_SESSION['foto'] = $row['foto'];
        
        $permissao = $row['permissao'];
        if($permissao == 1)
    {
        $_SESSION['permissao'] = $permissao;
        
        
        header('location: ../arquivos_site/paginas/fornecedor.php');
        exit;
    }
    else if ($permissao == 4)
    {
        $_SESSION['permissao'] = $permissao;
        header('location: ../arquivos_site/paginas/adminhome.php');
        exit;
    }
    else if ($permissao == 2)
    {
        $_SESSION['permissao'] = $permissao;
        header('location: ../arquivos_site/paginas/suporte.php');
        exit;
    }
} 
    else 
    {
        // Senha incorreta
        
        header('location: ../index.html?login_invalido=1');
        exit;
    }





}
else {
    //Usuário não encontrado

    header('location: ../index.html?login_invalido=1');
    exit;
}
$stmt->close();
$conexao->close();
}




?>