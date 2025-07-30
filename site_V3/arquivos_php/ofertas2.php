<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION["ultimo_id"]))
{
    echo "Nenhum id encontrado";
    exit();
}
$ultimo_id = $_POST['produto_id1'];
$_SESSION['ultimo_id'] = $ultimo_id;
$id = $_SESSION['ultimo_id'];
$conexao = new mysqli('localhost','root','','entrega');
$sql = "SELECT * FROM produtos WHERE id = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

echo $id;
$linha = mysqli_fetch_array($result);



    echo $linha['usuario'];
    echo $linha['produto1'];
    echo $linha['produto2'];
    echo $_SESSION['usuario'];
   






$stmt->close();
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../arquivos_site/css/ofertas.css">
    <title>Document</title>
</head>
<body>
<div class="centro"><!-- ABERTURA DIV CENTRO -->
<div class="ofertas"><!-- ABERTURA DIV OFERTAS -->
    <div class="perfil"><!-- ABERTURA DIV PERFIL -->
    <span class="foto"> <img src="<?php echo $_SESSION['foto'];?>" width="40px"; height="40px";> </span> 
    <span class="texto"> <?php echo $linha['usuario']; ?> </span>
    </div><!-- FECHAMENTO DIV PERFIL -->
    <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
    <span class="texto"> Produto: <?php echo $linha['produto1']; ?> </span>
    <span class="texto"> Marca: <?php echo $linha['produto2']; ?> </span>
    <span class="texto"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
    <span class="texto"> Unidades(V): <?php echo $linha['estoque']; ?> </span>
    <span class="duracao"> Dias Utéis: <?php echo $_SESSION['datas']; ?> </span>
    <button type="button" id="botao" onclick="conferirDados()"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg> </button>
    </div><!-- FECHAMENTO DIV PRODUTOS -->
</div><!-- FECHAMENTO DIV OFERTAS -->
</div><!-- FECHAMENTO DIV CENTRO --> 


  <div class="controle_conteudo" id="detalhes-conteudo" onclick="fecharaoclicarfora(event)"><!-- POSICIONAMENTO/CONFIGURAÇÃO DO CONTEÚDO (ABERTURA DIV CONTROLE_CONTEUDO)-->
    <div class="conteudo"><!-- ABERTURA DIV DO CONTEÚDO INTERNO -->
      <div class="perfil">
        <span class="foto"> <img src="<?php echo $_SESSION['foto'];?>" width="40px"; height="40px";> </span> 
        <span class="texto"> <?php echo $linha['usuario']; ?> </span>
      </div>

      <div class="produtos"> <!-- ABERTURA DIV PRODUTOS -->
        <span class="texto"> Produto: <?php echo $linha['produto1']; ?> </span>
        <span class="texto"> Marca: <?php echo $linha['produto2']; ?> </span>
        <span class="texto"> Peso: <?php echo $linha['peso_unidade']; ?> </span>
        <span class="texto"> Unidades(V): <?php echo $linha['estoque']; ?> </span>
        <span class="texto"> Descricao: <?php echo $linha['descricao']; ?> </span>
        <span class="texto"> Categoria: <?php echo $linha['categoria']; ?> </span>
        <span class="duracao2"> Dias Utéis: <?php echo $_SESSION['datas']; ?> </span>
        <button type="button" id="btnconfirmar"> Confirmar </button>
        <button type="button" id="btncancelar" onclick="fecharConteudo()"> Cancelar </button>
      </div>
    
    </div><!-- FECHAMENTO DIV DO CONTÉUDO INTERNO -->
  </div><!-- FECHAMENTO DIV DO CONTROLE DE CONTEÚDO -->
  <script>
    function conferirDados() {
      document.getElementById("detalhes-conteudo").style.display = "flex";
    }

    function fecharConteudo() {
      document.getElementById("detalhes-conteudo").style.display = "none";
    }

    function fecharaoclicarfora(event) {
      const modal = document.getElementById("detalhes-conteudo");
      const conteudo = document.querySelector(".conteudo");
      if (!conteudo.contains(event.target)) {
        fecharConteudo();
      }
    }
  </script>
</body>
</html>


















<!-- /* // Pega o ID da última inserção feita pelo usuário
if (!isset($_SESSION['ultimo_produto_id'])) {
    echo "Nenhum produto recente encontrado.";
    exit();
}

$id = $_SESSION['ultimo_produto_id'];
echo $id;
// Consulta o banco
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$linha = $resultado->fetch_assoc();

// Exibe os dados
if ($linha !== null) {
    echo "Usuário: " . $linha['usuario'] . "<br>";
    echo "Produto 1: " . $linha['produto1'] . "<br>";
    echo "Produto 2: " . $linha['produto2'] . "<br>";
} else {
    echo "Nenhum dado encontrado.";
} */

 -->