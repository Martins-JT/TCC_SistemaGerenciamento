<?php
// PHP e lógica no topo do arquivo
include_once('sidebar.php');

// Estabelece a conexão com o banco de dados
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'sistema_gerenciamento_db';
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (mysqli_connect_error()) {
    echo "Falha ao conectar ao MySQL: " . mysqli_connect_error();
    exit();
}

// Nova consulta SQL para buscar dados de contratos com ofertas aceitas
$query = "
    SELECT 
        c.ID AS contrato_id,
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
        p.unidade_medida, 
        o.status
    FROM CONTRATOS c
    JOIN PRODUTOS p ON c.PRODUTO_ID = p.id_produto
    JOIN FORNECEDORES f ON c.FORNECEDOR_ID = f.ID
    JOIN OFERTAS o ON c.ID_OFERTA = o.id_oferta
    ORDER BY c.DATA_CRIACAO DESC";

$result = mysqli_query($conexao, $query);

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
                        <th>Ações</th>
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