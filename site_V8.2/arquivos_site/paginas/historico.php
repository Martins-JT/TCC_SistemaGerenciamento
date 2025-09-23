<?php
include_once('../../arquivos_php/conexao.php');
session_start();


if($_SESSION['permissoes'] == 'admin'){
    session_abort();
include_once('sidebar_admin.php');}
else{
    session_abort();
   include_once('sidebar.php'); 
}

$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');

// Estabelece a conexão com o banco de dados


if (mysqli_connect_error()) {
    echo "Falha ao conectar ao MySQL: " . mysqli_connect_error();
    exit();
}

$id = $_SESSION['id'];
// Nova consulta SQL para buscar dados de contratos com ofertas aceitas


$dados_historico = $conexao->prepare("
    SELECT 
        c.ID contrato_id,
        f.NOME_EMPRESA,   
        c.DATA_CRIACAO,
        p.valor,
        c.valor_final,
        p.produto, 
        p.caracteristica,
        p.peso_unidade, 
        p.estoque, 
        p.descricao AS produto_descricao,
        p.valor, 
        p.marca, 
        p.unidade_medida
    FROM CONTRATOS c
    JOIN PRODUTOS p ON c.PRODUTO_ID = p.id_produto
    JOIN FORNECEDORES f ON c.FORNECEDOR_ID = f.ID
    where c.fornecedor_id = ?
    ORDER BY c.DATA_CRIACAO DESC");
$dados_historico->bind_param("i", $id);
$dados_historico->execute();
$result = $dados_historico->get_result();


$contratos = [];
if ($result) {
    while ($contrato = mysqli_fetch_assoc($result)) {
        $contratos[] = $contrato;
    }
} else {
    echo "Erro na consulta: " . mysqli_error($conexao);
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Ofertas Aceitas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/historico.css">
    
    <script>
        const contratosData = <?= json_encode($contratos); ?>;
    </script>
    <script src="../javascript/modal.js" defer></script>
</head>

<body>
    <div class="main-content">
        <div class="container mt-5">

            <table class="tabela-historico">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Valor Contratado</th>
                        <th>Data do Contrato</th>
                        <th>Detalhes do Contrato</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if (!empty($contratos)) : ?>
                        <?php foreach ($contratos as $key => $contrato) : ?>
                            <tr>
                                <td><?= htmlspecialchars($contrato['produto']) ?></td>
                                <td>R$ <?= number_format($contrato['valor_final'], 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime($contrato['DATA_CRIACAO'])) ?></td>
                                <td>
                                    <button class="btn-visualizar" data-contrato-index="<?= $key ?>">Visualizar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4">Nenhuma oferta aceita encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modal-produto" class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Contrato</h5>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-fechar">Fechar</button>
            </div>
        </div>
    </div>
</body>
</html>