<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/requisicoes.css">
    <link rel="stylesheet" href="../css/areasstyle.css">
</head>
<body>
<?php
  include_once('sidebar_admin.php');
  include_once('../../arquivos_php/conexao.php');

$conexao = new mysqli("localhost", "root", "", "sistema_gerenciamento_db");

$sql = "SELECT id_produto, produto, caracteristica, peso_unidade, estoque, descricao, categoria, marca, unidade_medida, 
valor, estado_produto, exibir_vitrine FROM produtos where id_fornecedor = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $_SESSION['id']);

$stmt->execute();

$resultado = $stmt->get_result();

$produtos = [];
$produtos_vitrine = [];
while ($dados = $resultado->fetch_assoc()) {
    if (!$dados['exibir_vitrine'])
    {
        $produtos[] = $dados;
    }
    $produtos_vitrine[] = $dados;
    

}

$stmt->close();
$conexao->close();
?>
?>
  <div class="requisicao">
        <!-- Área 1: Vitrine Virtual -->
        <div class="areas">
            <div class="area1" id="area">
                <!-- Título da seção Vitrine Virtual -->
                <p><span class="identificar2">Vitrine Virtual</span></p>
                <form action="../../arquivos_php/ofertas.php" method="post">
                    <div class="container1">
                            <!-- Coluna 1 vitrine -->
                            <div class="column1">
                                Lista de produtos:
                            <select name="produto_id1" id="produtoSelect_vitrine" onchange="preencherCamposs()" required>
                                <option value="">Selecione um Produto</option>
                                <?php
                                foreach ($produtos_vitrine as $produto_vitrine) {
                                    if ($produto_vitrine['exibir_vitrine'] && $produto_vitrine['estado_produto'])
                                        echo "<option value='{$produto_vitrine['id_produto']}'>{$produto_vitrine['produto']}</option>";
                                }
                                ?>
                            </select>
                                <label for="garantia_vitrine">Característica:</label>
                                <input type="text" name="garantia_vitrine" id="garantia_vitrine" readonly>
                                <label for="peso_vitrine">Peso unitário:</label>
                                <input type="text" name="peso_vitrine" id="peso_vitrine" readonly>
                                
                            </div>
                            <!-- Coluna 2 vitrine -->
                            <div class="column2">
                                <label for="estoque_vitrine">Estoque:</label>
                                <input type="text" name="estoque_vitrine" id="estoque_vitrine" readonly>
                                <label for="descricao_vitrine">Descrição:</label>
                                <input type="text" name="descricao_vitrine" id="descricao_vitrine" readonly>
                                
                                <label for="categoria_vitrine">Categoria:</label>
                                <input type="text" name="categoria_vitrine" id="categoria_vitrine" readonly>
                            </div>
                            <!-- Coluna 3 vitrine-->
                            <div class="column3">
                                
                                <label for="valor">Valor:</label>
                                <input type="text" name="valor" id="valor_vitrine" readonly>

                                <label for="marca_vitrine">Marca:</label>
                                <input type="text" name="marca_vitrine" id="marca_vitrine" readonly>

                                <label for="medida_vitrine">Medida:</label>
                                <input type="text" name="medida_vitrine" id="medida_vitrine" readonly>
                            </div>

                            <div class="column4">
                                Dias disponíveis:
                                <select id="diasSelect" name="dias" required>
                                <option value="" placeholder="Selecione uma data">Selecione uma data</option>
                                <option value="1">1 dia</option>
                                <option value="2">2 dias</option>
                                <option value="3">3 dias</option>
                                <option value="4">4 dias</option>
                                <option value="5">5 dias</option>
                                <option value="6">6 dias</option>
                                <option value="7">7 dias</option>
                                </select>
                            </div>

                            <!-- Botões de salvar e cancelar 
                            <button type="button" onclick="salvarEdit()" id="btn-salvar">Salvar</button>
                            <button type="button" onclick="cancelarEdit()" id="btn-cancel">Cancelar</button>
                            -->
                            <input type="hidden" name="produto_id" id="produto_id_vitrine">
                            <button type="submit" id="botao"> Enviar </button>
                        </div> <!-- FECHAMENTO DIV CONTAINER1 -->
                </form>
            </div> <!-- FECHAMENTO DIV AREA -->

            <!-- Área 2: Ofertas -->
            <div class="area1" id="area2">
                <p><span class="identificar2">Requisição</span></p>
                <form action="../../arquivos_php/ofertas.php" method="post">
                    <div class="container">
                        <div class="texts">
                            Lista de produtos:
                            <select name="produto_id1" id="produtoSelect" onchange="preencherCampos()" required>
                                <option value="">Selecione um Produto</option>
                                <?php
                                foreach ($produtos as $produto) {
                                    if ($produto['estado_produto'] && !$produto['exibir_vitrine'])
                                        echo "<option value='{$produto['id_produto']}'>{$produto['produto']}</option>";
                                }
                                ?>
                            </select>
                            Produto:
                            <input type="text" name="produtoo" id="produto1" readonly>
                            Característica:
                            <input type="text" name="produtoo1" id="caracteristica" readonly>
                        </div>
                        <div class="texts-2">
                            Peso:
                            <input type="text" name="pesoU" id="peso_unidade" readonly>
                            Estoque:
                            <input type="text" name="estoque" id="estoque" readonly>
                            Descrição:
                            <input type="text" name="descricao" id="descricao1" readonly>
                        </div>

                        <div class="texts-3">
                            
                            Categoria:
                            <input type="text" name="categoria" id="categoriaa" readonly>
                            Valor:
                            <input type="text" name="valor" id="valor" readonly>
                            Marca:
                            <input type="text" name="marca_oferta" id="marca_oferta" readonly>
                        </div>

                        <div class="texts-4">
                            Dias disponíveis:
                            <select id="diasSelect" name="dias" required>
                                <option value="" placeholder="Selecione uma data">Selecione uma data</option>
                                <option value="1">1 dia</option>
                                <option value="2">2 dias</option>
                                <option value="3">3 dias</option>
                                <option value="4">4 dias</option>
                                <option value="5">5 dias</option>
                                <option value="6">6 dias</option>
                                <option value="7">7 dias</option>
                            </select>
                            Unidade_medida:
                            <input type="text" name="unidade_medida" id="unidade_medida" readonly>
                            <input type="hidden" name="produto_id" id="produto_id">
                            <button type="submit" id="botao"> Enviar </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Área 3: Em Produção
            <div class="area1" id="area3">
                <p><span class="identificar2">Em produção</span></p>
                Area 3
            </div> -->

            <!-- Área 4: Novos Produtos -->
            <div class="area1" id="area4">
                <p><span class="identificar2">Novos Produtos</span></p>
                <form action="../../arquivos_php/novoproduto.php" method="post">
                    <div class="container2">
                        <div id="espaco1">
                            <div class="controlecheck">
                            <label for="checkstyle" id="">Lista da Vitrine: </label>
                            <input type="checkbox" name="check_vitrine" id="checkstyle">
                            </div>
                            <label for="novoproduto">Produto:</label>
                            <input type="text" name="novoproduto" id="novoproduto" required placeholder="Ex: Nome do produto">
                            <label for="Ncaracteristica">Característica:</label>
                            <input type="text" name="Ncaracteristica" id="Ncaracteristica" required placeholder="Ex: Secagem rápida">
                            <label for="novo_peso">Peso:</label>
                            <input type="text" name="novo_peso" id="novo_peso" required placeholder="Ex: 20kg.">
                        </div>
                        <div id="espaco2">
                            <label for="unidades">Estoque:</label>
                            <input type="text" name="unidades" id="unidades" required placeholder="Ex: 200 sacos">
                            <label for="desc">Descrição:</label>
                            <input type="text" name="desc" id="desc" required placeholder="Ex: Alta resistência">
                            <label for="nova_categoria">Categoria:</label>
                            <input type="text" name="nova_categoria" id="nova_categoria" required placeholder="Ex: Material de construção">
                        </div>
                        <div id="espaco3">
                            <label for="novo_valor">Valor:</label>
                            <input type="text" name="novo_valor" id="novo_valor" required placeholder="Ex: 420,55">
                            <label for="nova_marca">Marca:</label>
                            <input type="text" name="nova_marca" id="nova_marca" required placeholder="Ex: ....">
                            <label for="nova_medida">Unidade_medida:</label>
                            <input type="text" name="nova_medida" id="nova_medida" required placeholder="Ex: ....">
                        </div>
                        <button type="submit" id="botao"> Enviar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Expor os dados do PHP para o JavaScript
        const produtos = <?php echo json_encode($produtos); ?>;
        
        // Função para preencher os campos ao selecionar um produto
        function preencherCampos() {
            const idProduto = document.getElementById('produtoSelect').value;
            // Atualiza o input hidden com o ID selecionado
            document.getElementById('produto_id').value = idProduto;
            // Buscar o produto com o id selecionado
            const produto = produtos.find(p => p.id_produto == idProduto);
           

            if (produto) {
                document.getElementById('produto1').value = produto.produto;
                document.getElementById('caracteristica').value = produto.caracteristica;
                document.getElementById('peso_unidade').value = produto.peso_unidade;
                document.getElementById('estoque').value = produto.estoque;
                document.getElementById('descricao1').value = produto.descricao;
                document.getElementById('categoriaa').value = produto.categoria;
                document.getElementById('valor').value = produto.valor;
                document.getElementById('marca_oferta').value = produto.marca;
                document.getElementById('unidade_medida').value = produto.unidade_medida;
            } else {
                // Limpar os campos caso o id não seja válido
                document.getElementById('produto1').value = '';
                document.getElementById('caracteristica').value = '';
                document.getElementById('peso_unidade').value = '';
                document.getElementById('estoque').value = '';
                document.getElementById('descricao1').value = '';
                document.getElementById('categoriaa').value = '';
                document.getElementById('valor').value = '';
                document.getElementById('marca_oferta').value = '';
                document.getElementById('unidade_medida').value = '';
            }

           
        }

        const vitrine_produtos = <?php echo json_encode($produtos_vitrine); ?>;
        /* console.log(vitrine_produtos); */
        function preencherCamposs() {
            const idProduto_vitrine = document.getElementById('produtoSelect_vitrine').value;
            // Atualiza o input hidden com o ID selecionado
            document.getElementById('produto_id_vitrine').value = idProduto_vitrine;
            // Buscar o produto com o id selecionado
            /* const produto = produtos.find(p => p.id_produto == idProduto); */
            const preencher_vitrine = vitrine_produtos.find(p => p.id_produto == idProduto_vitrine);

            if (preencher_vitrine) {
                document.getElementById('garantia_vitrine').value = preencher_vitrine.caracteristica;
                document.getElementById('peso_vitrine').value = preencher_vitrine.peso_unidade;
                document.getElementById('estoque_vitrine').value = preencher_vitrine.estoque;
                document.getElementById('descricao_vitrine').value = preencher_vitrine.descricao;
                document.getElementById('categoria_vitrine').value = preencher_vitrine.categoria;
                document.getElementById('valor_vitrine').value = preencher_vitrine.valor;
                document.getElementById('marca_vitrine').value = preencher_vitrine.marca;
                document.getElementById('medida_vitrine').value = preencher_vitrine.unidade_medida;
            } else {
                // Limpar os campos caso o id não seja válido
                document.getElementById('garantia_vitrine').value = '';
                document.getElementById('peso_vitrine').value = '';
                document.getElementById('estoque_vitrine').value = '';
                document.getElementById('descricao_vitrine').value = '';
                document.getElementById('categoria_vitrine').value = '';
                document.getElementById('valor_vitrine').value = '';
                document.getElementById('marca_vitrine').value = '';
                document.getElementById('medida_vitrine').value = '';
            }

           
        }
    </script>
</body>
</html>

