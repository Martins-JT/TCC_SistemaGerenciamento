<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
include_once('conexao.php');
if (!isset($_SESSION['usuario']))
{
    header('Location: ../index.html');
    exit;  
}
$id = $_POST['id'] ?? '';
$remover_carrinho = $_POST['id_carrinho_off'] ?? '';
$idoferta_vitrine = $_POST['idoferta_vitrine'] ?? '';



$estado_vitrine = $conexao->prepare("SELECT exibir_vitrine FROM ofertas where id_oferta = ?");
$estado_vitrine->bind_param('i', $remover_carrinho);
$estado_vitrine->execute();
$estado_vitrine->bind_result($status_vitrine);
$estado_vitrine->fetch();
$estado_vitrine->close();

if ($id){
$oferta_status = 0;
$atualiza_statusoferta = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?");
$atualiza_statusoferta->bind_param('ii', $oferta_status, $id);
$atualiza_statusoferta->execute();
$atualiza_statusoferta->close();

$carrinho = 1;
$update = $conexao->prepare("UPDATE ofertas set carrinho = ? where id_oferta = ?");
$update->bind_param('ii', $carrinho, $id);
$update->execute();
$update->close();
}

if ($remover_carrinho && !$status_vitrine) // 
{
$oferta_status = 1;
$oferta_on = $conexao->prepare("UPDATE ofertas set status = ? where id_oferta = ?");
$oferta_on->bind_param('ii', $oferta_status, $remover_carrinho);
$oferta_on->execute();
$oferta_on->close();

$carrinho = 0;
$update = $conexao->prepare("UPDATE ofertas set carrinho = ? where id_oferta = ?");
$update->bind_param('ii', $carrinho, $remover_carrinho);
$update->execute();
$update->close();

}

if ($remover_carrinho && $status_vitrine){
$carrinho = 0;
$update = $conexao->prepare("UPDATE ofertas set carrinho = ? where id_oferta = ?");
$update->bind_param('ii', $carrinho, $remover_carrinho);
$update->execute();
$update->close();
}

/* if ($id && $status_vitrine)
{
$vitrine_status = 0;
$atualiza_status_vitrine = $conexao->prepare("UPDATE ofertas set exibir_vitrine = ? where id_oferta = ?");
$atualiza_status_vitrine->bind_param('ii', $vitrine_status, $id);
$atualiza_status_vitrine->execute();
$atualiza_status_vitrine->close();
} */

mysqli_close($conexao);
if ($_SESSION['permissao'] == 4){
header('Location: ../arquivos_site/paginas/adminhome.php');
exit;
}
header('Location: ../arquivos_site/paginas/fornecedor.php');
exit;
}
else
{
    header('Location: ../index.html');
    exit;
}
?>