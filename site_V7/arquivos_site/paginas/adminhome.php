<?php
include_once('sidebar_admin.php');



/* $_SESSION['datas'] = $_POST['datas'];
$ultimo_id = $_POST['produto_id1']; 
$_SESSION['ultimo_id']; 
$id = $_SESSION['ultimo_id']; */
$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');
$sql = "SELECT o.id_oferta, f.nome_empresa, f.foto, p.produto, 
p.caracteristica, p.peso_unidade, p.estoque,
p.descricao, p.categoria, o.data_inicio, o.dias, p.valor, o.status, p.id_produto, 
p.marca, p.unidade_medida, o.exibir_vitrine, o.carrinho
from ofertas o
inner join produtos p
on p.id_produto = o.id_produto
inner join fornecedores f
on f.id = o.id_fornecedor
ORDER BY o.id_oferta ASC";

$stmt = $conexao->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();



$sql3 = "SELECT f.nome_empresa
from ofertas o
inner join fornecedores f
on f.id = o.id_fornecedor
group by f.nome_empresa";

$stmt3 = $conexao->prepare($sql3);

$stmt3->execute();

$result3 = $stmt3->get_result();





$produtos = [];

while ($linhaa = mysqli_fetch_assoc($result))
{
  $produtos[] = $linhaa;
}

/* variáveis utilizadas na página abaixo */
$valortotal_compra = 0;
$idofertas_carrinho = [];
$valor_oferta = [];

$stmt->close();
$stmt3->close();
mysqli_close($conexao);


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/homeadmin.css">
    <link rel="stylesheet" href="../css/ofertas.css">
    
</head>
<body>
<div class="home"><!-- Abertura div home (controle de espaço) -->
<div class="areas">
<div class="area1" id="area"> <!-- Abertura da div area(primeira área da home) -->
        
        <select name="" id="nomeselecionado" onchange="Teste()">
          <option value="">Selecione</option>
          <?php
          
          while($dados = $result3->fetch_assoc())
          {
            $testando = $dados['nome_empresa'];
            ?>
            <option value="<?php echo $testando; ?>"><?php echo $testando; ?></option>
            <?php
           $usuario_selecionado = '<span id="valorteste"> a</span>';
       
          } 
          ?>
        </select>
      <div class="container"> <!-- Abertura div container -->
        
       <?php
       
      
       
    // Usar $result aqui, não $resultado
    
    foreach ($produtos as $linha){
    if ($linha['exibir_vitrine'] && !$linha['carrinho']){
    $dataInicio = $linha['data_inicio'] ?? null;
    $diasSelecionados = $linha['dias'] ?? null;
    
      if ($linha['valor'] != 0 && $linha['estoque'] != 0)
      {
      $estoque = intval($linha['estoque']);
      $valor = $linha['valor'];
      $valor_final = $estoque * $valor;
      $valor_final_formatado = number_format($valor_final, 2, ',', '.');
    
     }
?>
<div class="centro"><!-- ABERTURA DIV CENTRO -->
    
  <div class="ofertas testar"><!-- ABERTURA DIV OFERTAS -->
      <div class="perfil"><!-- ABERTURA DIV PERFIL -->
        <span class="#"> <img src="../../arquivos_php/<?php echo $linha['foto']; ?>" width="40px" height="40px"> </span> 
        <span class="#"> <?php echo $linha['nome_empresa']; ?> </span> 
      </div><!-- FECHAMENTO DIV PERFIL -->
        <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
          <span class="#"> Produto: <?php echo $linha['produto']; ?> </span>
          <span class="#"> Marca: <?php echo $linha['caracteristica']; ?> </span>
          <span class="#"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
          <span class="#"> Estoque: <?php echo $linha['estoque']; ?> </span>
          <span class="duracao"> Dias Utéis: <?php echo $linha['dias']; ?> </span>
          <button type="button" id="botao" onclick="conferirDados('<?php echo $linha['id_oferta']; ?>')"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg> </button>
        </div><!-- FECHAMENTO DIV PRODUTOS -->
  </div><!-- FECHAMENTO DIV OFERTAS -->
</div><!-- FECHAMENTO DIV CENTRO --> 


  <div class="controle_conteudo" id="detalhes-conteudo-<?php echo $linha['id_oferta']; ?>" onclick="fecharaoclicarfora(event, '<?php echo $linha['id_oferta']; ?>')"><!-- POSICIONAMENTO/CONFIGURAÇÃO DO CONTEÚDO (ABERTURA DIV CONTROLE_CONTEUDO)-->
    <div class="conteudo"><!-- ABERTURA DIV DO CONTEÚDO INTERNO -->
      <div class="perfil">
        <span class="#"> <img src="../../arquivos_php/<?php echo $linha['foto'];?>" width="40px"; height="40px";> </span> 
        <span class="#"> <?php echo $linha['nome_empresa']; ?> </span>
      </div>
        
      <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
        <span class="#"> Produto: <?php echo $linha['produto']; ?> </span>
        <span class="#"> Marca: <?php echo $linha['caracteristica']; ?> </span>
        <span class="#"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
        <span class="#"> Estoque: <?php echo $linha['estoque']; ?> </span>
        <span class="#"> Descricao: <?php echo $linha['descricao']; ?> </span>
        <span class="#"> Categoria: <?php echo $linha['categoria']; ?> </span>
        <span class="#"> Marca: <?php echo $linha['marca']; ?> </span>
        <span class="#"> Medida: <?php echo $linha['unidade_medida']; ?> </span>
        <span class="#"> Valor: R$ <?php echo $linha['valor']; ?> </span>
        <span class="#"> Valor final estimado: R$ <?php echo $valor_final_formatado; ?> </span>
        <span class="duracao2 contador" 
          data-data-inicio="<?php echo htmlspecialchars($linha['data_inicio']); ?>" 
          data-dias="<?php echo (int)$linha['dias']; ?>"
          data-id="<?php echo $linha['id_oferta']; ?>">
        </span>
        <form action="../../arquivos_php/movimentacao_carrinho.php" method="post">
        <button type="submit" id="btncarrinho" title="Enviar Para o Carrinho"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25q0-.075.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg></button>
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        </form>
        <form action="../../arquivos_php/confirmar.php" method="post">
        <button type="submit" id="btnconfirmar" title="Aceitar Oferta"> Confirmar </button>
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        <input type="hidden" name="valor_final" value="<?php echo $valor_final; ?>">
        </form>

        <form id="form-remocao-<?php echo $linha['id_oferta']; ?>" action="remover_oferta.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        </form>

        <form action="../../arquivos_php/excluir.php" method="post">
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        <input type="hidden" name="id_produto" value="<?php echo $linha['id_produto']; ?>">
        <button type="submit" id="btncancelar" onclick="fecharConteudo('<?php echo $linha['id_oferta']; ?>')"> Rejeitar </button>
        </form>
      </div> <!-- FECHAMENTO DIV PRODUTOS -->
    
      </div><!-- FECHAMENTO DIV DO CONTÉUDO INTERNO -->
    </div><!-- FECHAMENTO DIV DO CONTROLE DE CONTEÚDO -->
   <?php
    }
   }
?>
      </div><!-- Fechamento div container -->
</div><!-- Fechamento div area(primeira) -->

   
<div class="area1" id="area2"> <!-- Abertura da div area2(segunda área da home) -->
    <div class="container2"> <!-- Abertura div container2 -->
    <?php
    foreach ($produtos as $linha){// Usar $result aqui, não $resultado
    if ($linha['status'] && !$linha['exibir_vitrine'] && !$linha['carrinho']){
    $dataInicio = $linha['data_inicio'] ?? null;
    $diasSelecionados = $linha['dias'] ?? null;
    
      if ($linha['valor'] != 0 && $linha['estoque'] != 0)
      {
      $estoque = intval($linha['estoque']);
      $valor = $linha['valor'];
      $valor_final = $estoque * $valor;
      $valor_final_formatado = number_format($valor_final, 2, ',', '.');
    
     }
?>
<div class="centro"><!-- ABERTURA DIV CENTRO -->
    
  <div class="ofertas"><!-- ABERTURA DIV OFERTAS -->
      <div class="perfil"><!-- ABERTURA DIV PERFIL -->
        <span class="#"> <img src="../../arquivos_php/<?php echo $linha['foto']; ?>" width="40px" height="40px"> </span> 
        <span class="#"> <?php echo $linha['nome_empresa']; ?> </span>
      </div><!-- FECHAMENTO DIV PERFIL -->
        <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
          <span class="#"> Produto: <?php echo $linha['produto']; ?> </span>
          <span class="#"> Marca: <?php echo $linha['caracteristica']; ?> </span>
          <span class="#"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
          <span class="#"> Estoque: <?php echo $linha['estoque']; ?> </span>
          <span class="duracao"> Dias Utéis: <?php echo $linha['dias']; ?> </span>
          <button type="button" id="botao" onclick="conferirDados('<?php echo $linha['id_oferta']; ?>')"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg> </button>
        </div><!-- FECHAMENTO DIV PRODUTOS -->
  </div><!-- FECHAMENTO DIV OFERTAS -->
</div><!-- FECHAMENTO DIV CENTRO --> 


  <div class="controle_conteudo" id="detalhes-conteudo-<?php echo $linha['id_oferta']; ?>" onclick="fecharaoclicarfora(event, '<?php echo $linha['id_oferta']; ?>')"><!-- POSICIONAMENTO/CONFIGURAÇÃO DO CONTEÚDO (ABERTURA DIV CONTROLE_CONTEUDO)-->
    <div class="conteudo"><!-- ABERTURA DIV DO CONTEÚDO INTERNO -->
      <div class="perfil">
        <span class="#"> <img src="../../arquivos_php/<?php echo $linha['foto'];?>" width="40px"; height="40px";> </span> 
        <span class="#"> <?php echo $linha['nome_empresa']; ?> </span>
      </div>
        
      <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
        <span class="#"> Produto: <?php echo $linha['produto']; ?> </span>
        <span class="#"> Marca: <?php echo $linha['caracteristica']; ?> </span>
        <span class="#"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
        <span class="#"> Estoque: <?php echo $linha['estoque']; ?> </span>
        <span class="#"> Descricao: <?php echo $linha['descricao']; ?> </span>
        <span class="#"> Categoria: <?php echo $linha['categoria']; ?> </span>
        <span class="#"> Marca: <?php echo $linha['marca']; ?> </span>
        <span class="#"> Medida: <?php echo $linha['unidade_medida']; ?> </span>
        <span class="#"> Valor: R$ <?php echo $linha['valor']; ?> </span>
        <span class="#"> Valor final estimado: R$ <?php echo $valor_final_formatado; ?> </span>
        <span class="duracao2 contador" 
          data-data-inicio="<?php echo htmlspecialchars($linha['data_inicio']); ?>" 
          data-dias="<?php echo (int)$linha['dias']; ?>"
          data-id="<?php echo $linha['id_oferta']; ?>">
        </span>
        <form action="../../arquivos_php/movimentacao_carrinho.php" method="post">
        <button type="submit" id="btncarrinho" title="Enviar Para o Carrinho"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25q0-.075.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg></button>
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        </form>
        <form action="../../arquivos_php/confirmar.php" method="post">
        <button type="submit" id="btnconfirmar" title="Aceitar Oferta"> Confirmar </button>
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        <input type="hidden" name="valor_final" value="<?php echo $valor_final; ?>">
        </form>

        <form id="form-remocao-<?php echo $linha['id_oferta']; ?>" action="remover_oferta.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        </form>

        <form action="../../arquivos_php/excluir.php" method="post">
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        <input type="hidden" name="id_produto" value="<?php echo $linha['id_produto']; ?>">
        <button type="submit" id="btncancelar" onclick="fecharConteudo('<?php echo $linha['id_oferta']; ?>')"> Rejeitar </button>
        </form>
      </div> <!-- FECHAMENTO DIV PRODUTOS -->
    
      </div><!-- FECHAMENTO DIV DO CONTÉUDO INTERNO -->
    </div><!-- FECHAMENTO DIV DO CONTROLE DE CONTEÚDO -->
  
    <?php
    }
   }
?>
  

    </div><!-- Fechamento div container2 -->
</div><!-- Fechamento div area2(segunda) -->


<div class="area1" id="area3"> <!-- Abertura da div area3(terceira área da home) -->
  
    <div class="container3"> <!-- Abertura div container3 -->
     
     <?php
    foreach ($produtos as $linha){// Usar $result aqui, não $resultado
    if ($linha['carrinho']){
    $dataInicio = $linha['data_inicio'] ?? null;
    $diasSelecionados = $linha['dias'] ?? null;
    
      if ($linha['valor'] != 0 && $linha['estoque'] != 0)
      {
      $estoque = intval($linha['estoque']);
      $valor = $linha['valor'];
      $valor_final = $estoque * $valor;
      $valortotal_compra += $valor_final;
      $valortotal_compra_formatado =  number_format($valortotal_compra, 2, ',', '.');
      $valor_final_formatado = number_format($valor_final, 2, ',', '.');
    
     }
?>
<div class="centro"><!-- ABERTURA DIV CENTRO -->
    
  <div class="ofertas"><!-- ABERTURA DIV OFERTAS -->
      <div class="perfil"><!-- ABERTURA DIV PERFIL -->
        <span class="#"> <img src="../../arquivos_php/<?php echo $linha['foto']; ?>" width="40px" height="40px"> </span> 
        <span class="#"> <?php echo $linha['nome_empresa']; ?> </span>
      </div><!-- FECHAMENTO DIV PERFIL -->
        <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
          <?php $idofertas_carrinho[] = $linha['id_oferta']; $valor_oferta[] = $valor_final;?>
          <span class="#"> Produto: <?php echo $linha['produto']; ?> </span>
          <span class="#"> Marca: <?php echo $linha['caracteristica']; ?> </span>
          <span class="#"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
          <span class="#"> Estoque: <?php echo $linha['estoque']; ?> </span>
          <span class="duracao"> Dias Utéis: <?php echo $linha['dias']; ?> </span>
          <button type="button" id="botao" onclick="conferirDados('<?php echo $linha['id_oferta']; ?>')"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg> </button>
          <form action="../../arquivos_php/movimentacao_carrinho.php" method="post">
        <input type="hidden" name="id_carrinho_off" value="<?php echo $linha['id_oferta']; ?>">
        <button type="submit" id="btncancel"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10s10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59L9.41 8L8 9.41L10.59 12L8 14.59L9.41 16L12 13.41L14.59 16L16 14.59L13.41 12L16 9.41z"/></svg> </button>
        </form>
        </div><!-- FECHAMENTO DIV PRODUTOS -->
  </div><!-- FECHAMENTO DIV OFERTAS -->
</div><!-- FECHAMENTO DIV CENTRO --> 


  <div class="controle_conteudo" id="detalhes-conteudo-<?php echo $linha['id_oferta']; ?>" onclick="fecharaoclicarfora(event, '<?php echo $linha['id_oferta']; ?>')"><!-- POSICIONAMENTO/CONFIGURAÇÃO DO CONTEÚDO (ABERTURA DIV CONTROLE_CONTEUDO)-->
    <div class="conteudo"><!-- ABERTURA DIV DO CONTEÚDO INTERNO -->
      <div class="perfil">
        <span class="#"> <img src="../../arquivos_php/<?php echo $linha['foto'];?>" width="40px"; height="40px";> </span> 
        <span class="#"> <?php echo $linha['nome_empresa']; ?> </span>
      </div>
        
      <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
        <span class="#"> Produto: <?php echo $linha['produto']; ?> </span>
        <span class="#"> Marca: <?php echo $linha['caracteristica']; ?> </span>
        <span class="#"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
        <span class="#"> Estoque: <?php echo $linha['estoque']; ?> </span>
        <span class="#"> Descricao: <?php echo $linha['descricao']; ?> </span>
        <span class="#"> Categoria: <?php echo $linha['categoria']; ?> </span>
        <span class="#"> Marca: <?php echo $linha['marca']; ?> </span>
        <span class="#"> Medida: <?php echo $linha['unidade_medida']; ?> </span>
        <span class="#"> Valor: R$ <?php echo $linha['valor']; ?> </span>
        <span class="#"> Valor final estimado: R$ <?php echo $valor_final_formatado; ?> </span>
        <span class="duracao2 contador" 
          data-data-inicio="<?php echo htmlspecialchars($linha['data_inicio']); ?>" 
          data-dias="<?php echo (int)$linha['dias']; ?>"
          data-id="<?php echo $linha['id_oferta']; ?>">
        </span>
        
      </div> <!-- FECHAMENTO DIV PRODUTOS -->
    
      </div><!-- FECHAMENTO DIV DO CONTÉUDO INTERNO -->
    </div><!-- FECHAMENTO DIV DO CONTROLE DE CONTEÚDO -->
  
      <?php
       }
    }
      
      ?>
  
    </div><!-- Fechamento div container3 -->
    <div class="valor_car">
        
        <?php 
        if ($valortotal_compra == 0) 
        echo "R$ ".$valortotal_compra; 
        else echo "R$ ".$valortotal_compra_formatado; 
        ?>
        <form action="../../arquivos_php/carrinho_compras.php" method="post">
       <?php $count = count($idofertas_carrinho); for($i = 0; $i < $count; $i++){ ?>
    
        
        <input type="hidden" name="id[]" value="<?php echo $idofertas_carrinho[$i]; ?>">
        <input type="hidden" name="precooferta[]" value="<?php echo $valor_oferta[$i]; ?>">
        
        
        <?php
          }
        
         /*  print_r($idofertas_carrinho);
          print_r($valor_oferta); */
          ?>
          
          <input type="hidden" name="valortotal_compra" value="<?php echo $valortotal_compra; ?>">
        <button type="submit" id="btnaceitar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
        viewBox="0 0 24 24"><path fill="currentColor" 
        d="M19.78 2.2L24 6.42L8.44 22L0 13.55l4.22-4.22l4.22 4.22zm0 2.8L8.44 16.36l-4.22-4.17l-1.41 1.36l5.63 5.62L21.19 6.42z"/></svg></button>

        </form>
      </div>
</div><!-- Fechamento div area3(terceira) -->

<div class="area1" id="area4"> <!-- Abertura da div area4(quarta área da home) -->
    <div class="container4"> <!-- Abertura div container4 -->
    a

    </div><!-- Fechamento div container4 -->
</div><!-- Fechamento div area4(quarta) -->


</div> <!-- Fechamento div areas -->
</div><!-- Fechamento div home -->

<script>
/* function Teste() {
  const valorSelecionado = document.getElementById('nomeselecionado').value;
  const elementos = document.getElementsByClassName('testar');

  for (let i = 0; i < elementos.length; i++) {
    const elemento = elementos[i];

    // Pega o texto do primeiro <h3> dentro de cada bloco
    const nomeEmpresa = elemento.querySelector('h3')?.innerText.trim();
    console.log(`Comparando: "${nomeEmpresa}" com "${valorSelecionado}"`);

    /* if (!nomeEmpresa)
    return display:flex; 
    if (nomeEmpresa === valorSelecionado) {
      elemento.style.display = "flex"; 
    } else {
      elemento.style.display = "none";
    }
  }
} */




    function conferirDados(id) {
  document.getElementById('detalhes-conteudo-' + id).style.display = 'flex';
}

    function fecharConteudo(id) {
  document.getElementById('detalhes-conteudo-' + id).style.display = 'none';
}

    function fecharaoclicarfora(event, id) {
  const modal = document.getElementById("detalhes-conteudo-" + id);
  const conteudo = modal.querySelector(".conteudo");
  if (!conteudo.contains(event.target)) {
    modal.style.display = "none";
  }
}



 document.querySelectorAll('.contador').forEach(span => {
  const dataInicio = span.getAttribute('data-data-inicio');
  const diasSelecionados = parseInt(span.getAttribute('data-dias'), 10);
  const idOferta = span.getAttribute('data-id');
  if (dataInicio && diasSelecionados) {
    const inicio = new Date(dataInicio);
    const futuro = new Date(inicio.getTime() + diasSelecionados * 24 * 60 * 60 * 1000);

    const intervalo = setInterval(() => {
      const agora = new Date();
      const diferenca = futuro - agora;

      if (diferenca <= 0) {
          clearInterval(intervalo);
          /* span.textContent = "Tempo finalizado!"; */
         
          let form = document.getElementById('form-remocao-' + idOferta);
          if (form) {
          form.submit();
        }
          return;
        }

      const segundosTotais = Math.floor(diferenca / 1000);
      const dias = Math.floor(segundosTotais / 86400);
      const horas = Math.floor((segundosTotais % 86400) / 3600);
      const minutos = Math.floor((segundosTotais % 3600) / 60);
      const segundos = segundosTotais % 60;

      span.textContent = `Faltam ${dias}d ${horas}h ${minutos}m ${segundos}s`;
    }, 1000);
  } else {
    span.textContent = "Selecione um número de dias e envie o formulário para iniciar o contador.";
  }
});

    
  </script>
</body>
</html>