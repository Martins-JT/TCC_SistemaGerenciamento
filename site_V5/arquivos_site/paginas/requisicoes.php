<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/requisicoes.css">
    <link rel="stylesheet" href="../css/areasstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="../javascript/script.js"></script>
</head>
<body>
<?php

include_once('sidebar.php');
include_once('../../arquivos_php/conexao.php');

$conexao = new mysqli("localhost", "root", "", "sistema_gerenciamento_db");

$sql = "SELECT id_produto, produto, caracteristica, peso_unidade, estoque, descricao, categoria, valor FROM produtos where id_fornecedor = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $_SESSION['id']);

$stmt->execute();

$resultado = $stmt->get_result();

$produtos = [];
while ($dados = $resultado->fetch_assoc())
{
    $produtos[] = $dados;
}

$stmt->close();
$conexao->close();


?>
<div class="requisicao">
        <div class="areas">
    <div class="area1" id="area">

       <p><span class="identificar2">Vitrine Virtual</span></p>

        <div class="container1">
             <button class="btn-edit" title="Editar" onclick="editarInformacoes()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 19h1.425L16.2 9.225L14.775 7.8L5 17.575zm-2 2v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM19 6.4L17.6 5zm-3.525 2.125l-.7-.725L16.2 9.225z"/></svg></button>
           <!-- quando ele clicar aqui esses 2 informs precisam ficar none, e os informs para edição aparecer no lugar deles-->
             <div class="informs-1 informs-info">
        <strong>Produtos: <span id="produto"></span> </strong> 
       <strong>Estoque disponível: <span id="quantidade"></span></strong> 
      <strong>Marca: <span id="marca"></span> </strong>  
       
        </div>
        
        <div class="informs-2 informs-info">
       <strong>Categoria: <span id="categoria"></span> </strong>  
        <strong> Peso Unitário: <span id="peso"></span></strong> 
        <strong>Descrição: <span id="descricao"></span> </strong> 
        </div>

        <div class="informs-3 informs-info">
       <strong>Garantia: <span id="garantia"></span></strong> 
       
       <p class="posicao"><strong>Última atualização:</strong> <span id="ultimaAtualizacao">Sem Atualizações</span></p>
        </div>

        
            <form action="" method="post" class="form-edit" id="form-edit">
 <div class="informs-edit">
     <div class="column2">
       <label for="produtoInput">Produto:</label>
        <input type="text" id="produtoInput" placeholder="Digite o nome do produto">
        <label for="quantidadeInput">Estoque Disponível:</label>
        <input type="number" id="quantidadeInput" placeholder="ex: 150">
       
        
        
    </div>

       <div class="column2">
        <label for="medida-selecionada">Medida:</label>
                                    <select name="medida" id="medida-selecionada">
                                        <option value="" >Selecione uma medida</option>
                                        <option value="metros"> Metros </option>
                                        <option value="unidade">Unidades</option>
                                        <option value="volume">Volume</option>
                                        <option value="kg">KG</option>
                                        

                                    </select>
        <label for="marcaproduto">Marca:</label>
        <input type="text" id="marcaproduto" placeholder="Marca do produto">
    </div>
        <div class="column3">
        <label for="categoriaproduto">Categoria:</label>
        <input type="text" id="categoriaproduto" placeholder="ex: cimento">

        <label for="pesoproduto">Peso unitário:</label>
        <input type="text" id="pesoproduto" placeholder="ex: 50kg.">

        </div>

        <div class="column4">
        <label for="descricaoproduto">Descrição:</label>
        <input type="text" id="descricaoproduto" placeholder="Utilizado em estruturas">

        <label for="garantiaproduto">Garantia:</label>
        <input type="text" id="garantiaproduto" placeholder="ex: 3 meses.">

        </div>
        
        <button type="button" onclick="salvarEdit()" id="btn-salvar">Salvar</button>
        <button type="button" onclick="cancelarEdit()" id="btn-cancel">Cancelar</button>

</div>


</form>


        </div>

        
 
    </div>
    
    <div class="area1" id="area2">
   
            <p><span class="identificar2">Ofertas</span></p>
         <form action="../../arquivos_php/ofertas.php" method="post">
        
       <div class="container">
        
        <div class="texts">
           
            Lista de produtos:
            <select name="produto_id1" id="produtoSelect" onchange="preencherCampos()" required>

                <option value="">Selecione um Produto</option>
            <?php
             foreach ($produtos as $produto) {
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
                      
                       
                            Quantidade:
                            <input type="text" name="estoque" id="estoque" readonly>
                            
                           
                                Descrição:
                                <input type="text" name="descricao" id="descricao1" readonly>
                                </div>

                                <div class="texts-3">
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
                                  
                                   
                                        Categoria:
                                        <input type="text" name="categoria" id="categoriaa" readonly>
                                        
                                        Valor:
                                        <input type="text" name="valor" id="valor" >
                                            <!-- a3
                                            <input type="text" name=""> -->
                                            <input type="hidden" name="produto_id" id="produto_id">
                                            <button type="submit" id="botao"> Enviar </button>    
                                            </div>
                                            
                                     
                            </div>
                             
    </form>

    </div>


    <div class="area1" id="area3">
        <p><span class="identificar2">Em produção</span></p>
    Area 3
    
    </div>
  
      
    <div class="area1" id="area4">
<p><span class="identificar2">Novos Produtos</span></p>
 
        <form action="../../arquivos_php/novoproduto.php" method="post">
            
         <div class="container2">
       
            
        <div id="espaco1">
        <label for="novoproduto">Produto:</label>
        <input type="text" name="novoproduto" id="novoproduto" required placeholder="Ex: Nome do produto">

        <label for="Ncaracteristica">Característica:</label>
        <input type="text" name="Ncaracteristica" id="Ncaracteristica" required placeholder="Ex: Secagem rápida">
       
        <label for="novo_peso">Peso:</label>
        <input type="text" name="novo_peso" id="novo_peso" required placeholder="Ex: 20kg.">
        
        </div>
        <div id="espaco2">

        <label for="unidades">Quantidade:</label>
        <input type="text" name="unidades" id="unidades" required placeholder="Ex: 200 sacos">

        <label for="desc">Descrição:</label>
        <input type="text" name="desc" id="desc" required placeholder="Ex: Alta resistência">

        <label for="nova_categoria"> Categoria: </label>
        <input type="text" name="nova_categoria" id="nova_categoria" required placeholder="Ex: Material de construção">

       
        </div>

        <div id="espaco3">

        
        <label for="novo_valor"> Valor: </label>
        <input type="text" name="novo_valor" id="novo_valor" required placeholder="Ex: 420,55">
       
        </div>
           <button type="submit" id="botao"> Enviar </button>
           
</form>

 
        </div>


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

            /* // Definir o valor do campo oculto com o ID do produto
            document.getElementById('produto_id').value = idProduto; */
            
            if (produto) {
                
                document.getElementById('produto1').value = produto.produto;
                document.getElementById('caracteristica').value = produto.caracteristica;
                document.getElementById('peso_unidade').value = produto.peso_unidade;
                document.getElementById('estoque').value = produto.estoque;
                document.getElementById('descricao1').value = produto.descricao;
                document.getElementById('categoriaa').value = produto.categoria;
                document.getElementById('valor').value = produto.valor;
            } else {
                // Limpar os campos caso o id não seja válido
            
                document.getElementById('produto1').value = '';
                document.getElementById('caracteristica').value = '';
                document.getElementById('peso_unidade').value = '';
                document.getElementById('estoque').value = '';
                document.getElementById('descricao1').value = '';
                document.getElementById('categoriaa').value = '';
                document.getElementById('valor').value = '';
            }
        }
    </script>
 

</body>
</html>
