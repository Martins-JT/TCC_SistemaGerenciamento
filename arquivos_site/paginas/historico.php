<?php
// PHP e lógica no topo do arquivo
include_once('sidebar.php');

$query = "
    SELECT p.id_produto, p.produto, p.valor, p.categoria, 
            f.NOME_EMPRESA, f.CNPJ, f.EMAIL, f.TELEFONE, f.RUA, f.NUMERO, 
            f.CIDADE, f.ESTADO, f.CEP, p.descricao
    FROM produtos p
    INNER JOIN fornecedores f ON p.id_fornecedor = f.ID
    WHERE p.estado_produto = 1 AND p.exibir_vitrine = 1";

$result = mysqli_query($conexao, $query);

// Armazena todos os dados do banco de dados em um array para uso no JavaScript
$produtos = [];
while ($produto = mysqli_fetch_assoc($result)) {
    $produtos[] = $produto;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Produtos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/historico.css">
    <link rel="stylesheet" href="../css/homeadmin.css">
    <link rel="stylesheet" href="../css/ofertas.css">
    <link rel="stylesheet" href="../css/areasstyle.css">

    <script>
        const produtosData = <?= json_encode($produtos); ?>;
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
                        <th>Valor</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $key => $produto) : ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['produto']) ?></td>
                            <td>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($produto['categoria']) ?></td>
                            <td>
                                <button class="btn-visualizar" data-product-index="<?= $key ?>">Visualizar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modal-produto" class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Produto</h5>
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