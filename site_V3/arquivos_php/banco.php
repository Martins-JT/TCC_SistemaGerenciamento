<?php
include_once('conexao.php');
$usuario = $_POST['email'];
$senha = $_POST['senha'];
$permissao = 'usuario';
if (isset($_FILES["imagem"]) && !empty($_FILES["imagem"]))
{
    $imagem = "img/".$_FILES["imagem"]["name"];
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem);
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

$conexao = new mysqli('localhost','root','','entrega');

$sql = 'INSERT INTO informacoes(usuario, senha, foto, permissoes) VALUES(?,?,?,?)';

$stmt = $conexao->prepare($sql);

$stmt->bind_param('ssss', $usuario, $hash, $imagem, $permissao);

if ($stmt->execute())
{
    echo 'Usuario cadastrado';
}
else {
    echo "erro ao cadastrar". $stmt->error;
}

$stmt->close();
$conexao->close();



//bind_param(): é o método que vincula variáveis aos parâmetros da instrução SQL preparada.

?>