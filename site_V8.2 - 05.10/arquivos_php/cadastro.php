<?php
include_once('conexao.php');

//informações do usuário.
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

//dados da empresa.
$nome_empresa = $_POST['empresa'] ?? '';
$cnpj = $_POST['cnpj'] ?? '';
$areasinteresse = $_POST['interestAreas'] ?? []; 

//Contato.
$rua = $_POST['rua'] ?? '';
$numero = $_POST['numero'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$cep = $_POST['cep'] ?? '';
$telefone = $_POST['telefone'] ?? '';

// Validação básica
if (
    empty($email) || empty($senha) || empty($confirmarSenha) ||
    empty($nome_empresa) || empty($cnpj) || empty($rua) ||
    empty($numero) || empty($cidade) || empty($estado) || empty($cep)
) {
    echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');window.history.back();</script>";
    exit;
}

// Verifica se as senhas coincidem
if ($senha !== $confirmarSenha) {
    echo "<script>alert('As senhas não coincidem!');window.history.back();</script>";
    exit;
}


//permissão de cada usuário no sistema.
$permissao = 'usuario';

if (isset($_FILES["imagem"]) && !empty($_FILES["imagem"]))
{
    $imagem = "img/".$_FILES["imagem"]["name"];
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem);
}
else
{
    $imagem = "img/usuario.png";
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

// Trata interesses (array para string separada por vírgula)
$interesses = implode(',', $areasinteresse);

$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');

$sql = 'INSERT INTO fornecedores(email, senha, nome_empresa, cnpj, interesses, telefone, rua, 
numero, cidade, estado, cep, foto, permissoes) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';


$stmt = $conexao->prepare($sql);

$stmt->bind_param('sssssssssssss', $email, $hash, $nome_empresa, $cnpj, $interesses, $telefone, 
$rua, $numero, $cidade, $estado, $cep, $imagem, $permissao);


// Executa e apresenta resultado
if ($stmt->execute()) {
    // Mensagem com botão para login, layout simples e elegante
    echo '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro realizado</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 flex flex-col items-center">
            <svg class="text-green-500 mb-4" width="56" height="56" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="2" stroke="currentColor" fill="#c6f6d5"/>
                <path stroke="#38a169" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 12l2 2l4-4" />
            </svg>
            <h1 class="text-2xl font-bold text-green-700 mb-2">Cadastro realizado com sucesso!</h1>
            <p class="text-gray-700 mb-6 text-center">Você já pode acessar sua conta.</p>
            <a href="../index.html"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                Ir para Login
            </a>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </body>
    </html>
    ';
} else {
    if ($conexao->errno == 1062) {
        // E-mail já cadastrado
        echo "<script>alert('E-mail já cadastrado!');window.history.back();</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: ".$conexao->error."');window.history.back();</script>";
    }
}

$stmt->close();
$conexao->close();



//bind_param(): é o método que vincula variáveis aos parâmetros da instrução SQL preparada.

?>