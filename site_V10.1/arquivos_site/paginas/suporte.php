<?php
session_start();
include_once('../../arquivos_php/redirecionamento.php');
incluirSidebar();

/************************************
 * SISTEMA DE SUPORTE - PREGO TORTO *
 ************************************/

// CONFIGURAÇÃO DO BANCO
$host = 'localhost';
$db   = 'sistema_gerenciamento_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("❌ Erro na conexão: " . $e->getMessage());
}

// DADOS DA EMPRESA
$empresa = [
    'nome' => 'Prego Torto',
    'area' => 'Serviços de Suporte Técnico e Manutenção',
    'whatsapp' => '+5511999999999',
    'facebook' => '#',
    'Prego Torto' => '../../index.html',
];

// -------------------- NOVO CHAMADO --------------------

// -------------------- NOVO CHAMADO --------------------
if (isset($_POST['acao']) && $_POST['acao'] === 'novo_chamado') {
    // Captura e valida os campos do formulário
    $cliente = trim($_POST['cliente'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $assunto = trim($_POST['assunto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $prioridade = trim($_POST['prioridade'] ?? '');

    // Verifica se todos os campos obrigatórios estão preenchidos
    if (!empty($cliente) && !empty($email) && !empty($telefone) && !empty($assunto) && !empty($descricao) && !empty($categoria) && !empty($prioridade)) {
        // Insere no banco de dados
        $stmt = $pdo->prepare("
            INSERT INTO chamados (cliente, email, telefone, assunto, descricao, categoria, prioridade, status, data_criacao)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Aberto', NOW())
        ");
        $stmt->execute([$cliente, $email, $telefone, $assunto, $descricao, $categoria, $prioridade]);

        // Mensagem de sucesso
        $mensagem = "✅ Chamado registrado com sucesso!";
    } else {
        // Mensagem de erro caso falte algum campo
        $mensagem = "⚠️ Por favor, preencha todos os campos obrigatórios.";
    }
}


if (isset($_POST['acao']) && $_POST['acao'] === 'mensagem_suporte') {
    // Captura e valida os campos do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensagem_texto = trim($_POST['mensagem'] ?? '');

    if (!empty($nome) && !empty($email) && !empty($mensagem_texto)) {
        // Insere no banco de dados
        $stmt = $pdo->prepare("
            INSERT INTO mensagens_suporte (nome, email, mensagem, data_envio)
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$nome, $email, $mensagem_texto]);

        $mensagem = "✅ Mensagem enviada ao suporte com sucesso!";
    } else {
        $mensagem = "⚠️ Por favor, preencha todos os campos antes de enviar.";
    }
}



// -------------------- MENSAGEM SUPORTE --------------------
if (isset($_POST['acao']) && $_POST['acao'] === 'mensagem_suporte') {
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $mensagem_texto = $_POST['mensagem'] ?? null;

    if ($nome && $email && $mensagem_texto) {
        $stmt = $pdo->prepare("INSERT INTO mensagens_suporte (nome, email, mensagem) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $mensagem_texto]);
        $mensagem = "📩 Mensagem enviada ao suporte com sucesso!";
    } else {
        $mensagem = "⚠️ Preencha todos os campos antes de enviar a mensagem.";
    }
}


// -------------------- ALTERAR STATUS --------------------
if (isset($_GET['status'], $_GET['id'])) {
    $id = (int) $_GET['id'];
    $novo_status = $_GET['status'];

    $pdo->prepare("UPDATE chamados SET status = ? WHERE id = ?")->execute([$novo_status, $id]);
    $pdo->prepare("INSERT INTO historico_status (chamado_id, status) VALUES (?, ?)")->execute([$id, $novo_status]);

    $mensagem = "🔄 Status do chamado #$id atualizado para '$novo_status'.";
}

// -------------------- APAGAR CHAMADO --------------------
if (($_GET['acao'] ?? '') === 'apagar' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $pdo->prepare("DELETE FROM historico_status WHERE chamado_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM chamados WHERE id = ?")->execute([$id]);

    $mensagem = "🗑️ Chamado #$id apagado com sucesso!";
}

// -------------------- FUNÇÃO DE COR --------------------
function status_color($status) {
    return match($status) {
        'Aberto' => '#ffebee',
        'Em Andamento' => '#fff8e1',
        'Resolvido' => '#e8f5e9',
        default => '#f5f5f5',
    };
}

// -------------------- BUSCA CHAMADOS --------------------
$chamados = $pdo->query("SELECT * FROM chamados ORDER BY data_criacao DESC")->fetchAll();

$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');
$carregarInformacoes = $conexao->prepare('SELECT nome_empresa, email, telefone from fornecedores where id = ?');
$carregarInformacoes->bind_param('i', $_SESSION['id']);
$carregarInformacoes->execute();
$carregarInformacoes->bind_result($nome, $email, $telefone);
$carregarInformacoes->fetch();

$conexao->close();
$carregarInformacoes->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($empresa['nome']) ?> - Sistema de Suporte</title>
<style>
/* ===== ESTILO GLOBAL ===== */
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f2f4f8;
    color: #333;
    margin: 0;
 
}
h1 {
    color: rgb(220 38 38 / var(--tw-text-opacity, 1));
    margin-bottom: 5px;
}
h2 {
    color: rgb(220 38 38 / var(--tw-text-opacity, 1));
    padding-bottom: 4px;
}
.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 70px;
}

/* ===== CABEÇALHO ===== */
.header {
    background-color: rgb(17 24 39 / var(--tw-bg-opacity, 1));
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
}
.header h1 { margin: 0; }
.links a {
    color: #fff;
    margin-right: 15px;
    text-decoration: none;
    font-weight: 500;
}
.links a:hover { text-decoration: underline; }

/* ===== FORMULÁRIOS ===== */
form {
    background-color: rgb(17 24 39 / var(--tw-bg-opacity, 1));
    color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
input, textarea, select, button {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 15px;
    background: cadetblue;
}
button {
    background: rgb(51 72 95);
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
}
button:hover { background: rgb(55 89 125); }

/* ===== TABELA ===== */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: rgb(59 63 75);
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
th, td {
    padding: 12px 10px;
    border-bottom: 1px solid #000000ff;
    text-align: left;
    font-size: 14px;
}
th {
    background-color: rgb(17 24 39 / var(--tw-bg-opacity, 1));
    color: white;
}
tr:hover { background: rgb(79 87 113 / 81%); }
.historico {
    font-size: 12px;
    color: #555;
    margin-top: 5px;
}

/* ===== BOTÕES ===== */
.status-links a {
    color: #1976d2;
    text-decoration: none;
    font-weight: 500;
}
.status-links a:hover { text-decoration: underline; }

.botao-apagar {
    background: #d32f2f;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}
.botao-apagar:hover { background: #b71c1c; }

/* ===== MENSAGEM DE ALERTA ===== */
.mensagem {
    background: #e8f5e9;
    border-left: 6px solid #4caf50;
    padding: 12px;
    border-radius: 6px;
    color: #2e7d32;
    margin-bottom: 20px;
    font-weight: 500;
}
.estilo{
    color: white;
}
</style>

<script>
function confirmarApagar(id) {
    if (confirm("⚠️ Tem certeza que deseja apagar o chamado #" + id + "?")) {
        window.location.href = "?acao=apagar&id=" + id;
    }
}
</script>
</head>

<body>

<div class="container">

    <div class="header">
        <h1><?= htmlspecialchars($empresa['nome']) ?></h1>
        <p><?= htmlspecialchars($empresa['area']) ?></p>
        <div class="links">
            <a href="https://wa.me/<?= preg_replace('/\D/', '', $empresa['whatsapp']) ?>" target="_blank">📱 WhatsApp</a>
            <a href="<?= $empresa['facebook'] ?>" target="_blank">📘 Facebook</a>
            <a href="<?= $empresa['Prego Torto'] ?>" target="_blank">💼 Prego Torto</a>
        </div>
    </div>

    <?php if (!empty($mensagem)): ?>
        <div class="mensagem"><?= $mensagem ?></div>
    <?php endif; ?>
<?php if ($_SESSION['permissao'] == 1 || $_SESSION['permissao'] == 4){ ?>
    <h2>📋 Novo Chamado</h2>
    <form method="post">
        <input type="hidden" name="acao" value="novo_chamado">

        <label>Nome do Cliente</label>
        <input type="text" name="cliente" value="<?php echo $nome; ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?php echo $telefone; ?>" required>

        <label>Assunto</label>
        <input type="text" name="assunto" required>

        <label>Categoria</label>
        <select name="categoria" required>
            <option>Geral</option>
            <option>Suporte Técnico</option>
            <option>Instalação</option>
            <option>Manutenção</option>
            <option>Financeiro</option>
        </select>

        <label>Prioridade</label>
        <select name="prioridade" required>
            <option>Baixa</option>
            <option selected>Normal</option>
            <option>Alta</option>
            <option>Urgente</option>
        </select>

        <label>Descrição</label>
        <textarea name="descricao" rows="4" required></textarea>

        <button type="submit">✅ Registrar Chamado</button>
    </form>

    <h2>💬 Contato com o Suporte</h2>
    <form method="post">
        <input type="hidden" name="acao" value="mensagem_suporte">

        <label>Seu Nome</label>
        <input type="text" name="nome" required>

        <label>Seu E-mail</label>
        <input type="email" name="email" required>

        <label>Mensagem</label>
        <textarea name="mensagem" rows="4" required></textarea>

        <button type="submit">📨 Enviar Mensagem</button>
    </form>
<?php }else{ ?>
    <h2>🧾 Chamados Registrados</h2>
    <?php if (empty($chamados)): ?>
        <p>Nenhum chamado registrado no momento.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Assunto</th>
            <th>Categoria</th>
            <th>Prioridade</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($chamados as $c): 
            $hist = $pdo->prepare("SELECT * FROM historico_status WHERE chamado_id = ? ORDER BY data ASC");
            $hist->execute([$c['id']]);
            $historico = $hist->fetchAll();
        ?>
        <tr style="background: <?= status_color($c['status']) ?>">
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['cliente']) ?><br><small><?= htmlspecialchars($c['telefone']) ?><br><?= htmlspecialchars($c['email']) ?></small></td>
            <td><?= htmlspecialchars($c['assunto']) ?></td>
            <td><?= htmlspecialchars($c['categoria']) ?></td>
            <td><?= htmlspecialchars($c['prioridade']) ?></td>
            <td>
                <?= htmlspecialchars($c['status']) ?>
                <div class="historico">
                    <?php foreach ($historico as $h): ?>
                        • <?= $h['status'] ?> (<?= $h['data'] ?>)<br>
                    <?php endforeach; ?>
                </div>
            </td>
            <td><?= $c['data_criacao'] ?></td>
            <td class="status-links">
                <a href="?id=<?= $c['id'] ?>&status=Aberto">Aberto</a> |
                <a href="?id=<?= $c['id'] ?>&status=Em Andamento">Andamento</a> |
                <a href="?id=<?= $c['id'] ?>&status=Resolvido">Resolvido</a><br><br>
                <button type="button" class="botao-apagar" onclick="confirmarApagar(<?= $c['id'] ?>)">🗑️ Apagar</button>
            </td>
        </tr>
        <tr>
            <td colspan="8"><div class="estilo"><strong> Descrição:</strong> <?= nl2br(htmlspecialchars($c['descricao'])) ?></div></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php }?>
</div>
</body>
</html>
