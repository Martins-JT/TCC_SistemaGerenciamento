<?php
include_once('sidebar_admin.php');
include_once('../../arquivos_php/conexao.php');


/* $_SESSION['datas'] = $_POST['datas'];
$ultimo_id = $_POST['produto_id1']; 
$_SESSION['ultimo_id']; 
$id = $_SESSION['ultimo_id']; */
$conexao = new mysqli('localhost','root','','sistema_gerenciamento_db');
$sql = "SELECT o.id_oferta, f.nome_empresa, f.foto, p.produto, 
p.caracteristica, p.peso_unidade, p.estoque,
p.descricao, p.categoria, o.data_inicio, o.dias, p.valor, o.status
from ofertas o
inner join produtos p
on p.id_produto = o.id_produto
inner join fornecedores f
on f.id = o.id_fornecedor
ORDER BY o.id_oferta ASC";

$stmt = $conexao->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();



/* $id = 1;
$dados_oferta = $conexao->prepare("SELECT fornecedores.foto 
FROM fornecedores
INNER JOIN ofertas
ON fornecedores.id = ofertas.id_fornecedor
where ofertas.id_oferta = ?");
$dados_oferta->bind_param('i', $id);
$dados_oferta->execute();


$dados_oferta->bind_result($foto);

$dados_oferta->fetch();
$dados_oferta->close(); */

$stmt->close();
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
    <div class="container"> <!-- Abertura div container -->
    aa
    aa 
    aa 
  aaaaaaaaaaaaa 
    </div><!-- Fechamento div container -->
</div><!-- Fechamento div area(primeira) -->

   
<div class="area1" id="area2"> <!-- Abertura da div area2(segunda área da home) -->
    <div class="container2"> <!-- Abertura div container2 -->
    <?php
   while($linha = $result->fetch_assoc()) { // Usar $result aqui, não $resultado
    if ($linha['status']){
    $dataInicio = $linha['data_inicio'] ?? null;
    $diasSelecionados = $linha['dias'] ?? null;
    
    if ($linha['valor'] != 0 && $linha['estoque'] != 0)
    {
      $estoque = intval($linha['estoque']);
    $valor = $linha['valor'];
    $final = $estoque * $valor;
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
    <span class="#"> Unidades(V): <?php echo $linha['estoque']; ?> </span>
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
        <span class="#"> Unidades(V): <?php echo $linha['estoque']; ?> </span>
        <span class="#"> Descricao: <?php echo $linha['descricao']; ?> </span>
        <span class="#"> Categoria: <?php echo $linha['categoria']; ?> </span>
        <span class="#"> Valor: R$ <?php echo $linha['valor']; ?> </span>
         <span class="#"> Valor final estimado: R$ <?php echo $final; ?> </span>
        <span class="duracao2 contador" 
      data-data-inicio="<?php echo htmlspecialchars($linha['data_inicio']); ?>" 
      data-dias="<?php echo (int)$linha['dias']; ?>"
      data-id="<?php echo $linha['id_oferta']; ?>">
</span>

        <form action="../../arquivos_php/confirmar.php" method="post">
        <button type="submit" id="btnconfirmar" title="Aceitar Oferta"> Confirmar </button>
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        </form>

        <form id="form-remocao-<?php echo $linha['id_oferta']; ?>" action="remover_oferta.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        </form>

        <form action="../../arquivos_php/excluir.php" method="post">
        <input type="hidden" name="id" value="<?php echo $linha['id_oferta']; ?>">
        <button type="submit" id="btncancelar" onclick="fecharConteudo('<?php echo $linha['id_oferta']; ?>')"> Rejeitar </button>
        </form>
      </div>
    
    </div><!-- FECHAMENTO DIV DO CONTÉUDO INTERNO -->
  </div><!-- FECHAMENTO DIV DO CONTROLE DE CONTEÚDO -->
  <script>
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
    <?php
    }
   }
?>
  

    </div><!-- Fechamento div container2 -->
</div><!-- Fechamento div area2(segunda) -->


<div class="area1" id="area3"> <!-- Abertura da div area3(terceira área da home) -->
    <div class="container3"> <!-- Abertura div container3 -->
    a

    </div><!-- Fechamento div container3 -->
</div><!-- Fechamento div area3(terceira) -->

<div class="area1" id="area4"> <!-- Abertura da div area4(quarta área da home) -->
    <div class="container4"> <!-- Abertura div container4 -->
    a

    </div><!-- Fechamento div container4 -->
</div><!-- Fechamento div area4(quarta) -->


</div> <!-- Fechamento div areas -->
</div><!-- Fechamento div home -->

</body>
</html>