<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (!isset($_SESSION['usuario']))
{
    header('Location: ../index.html');
    exit;  
}
include_once('conexao.php');
session_start();

$conexao->begin_transaction();
$id = $_POST['id'];
$valortotal_compra = $_POST['valortotal_compra'];
$carrinho = 0;
$preco_oferta = $_POST['precooferta'];
if (empty($id) || empty($valortotal_compra)){
    header('Location: ../arquivos_site/paginas/adminhome.php');
    exit;
}

$count = count($id);
$comprador = $_SESSION['id'];

$update = $conexao->prepare("UPDATE ofertas set carrinho = ? where id_oferta = ?");
$update_vitrine = $conexao->prepare("UPDATE ofertas set exibir_vitrine = ? where id_oferta = ?");
$dados_oferta = $conexao->prepare("SELECT id_fornecedor, id_produto, dias, exibir_vitrine FROM ofertas where id_oferta = ?");
$stmt = $conexao->prepare("INSERT INTO contratos(fornecedor_id, produto_id, comprador, id_oferta, data_criacao, 
validade, valor_oferta, valor_final) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
try {
for($i = 0; $i < $count; $i++)/* foreach($id as $id[$i]) */
{
$valor_oferta = $preco_oferta[$i];


$dados_oferta->bind_param('i', $id[$i]);
$dados_oferta->execute();

$dados_oferta->store_result();
$dados_oferta->bind_result($id_fornecedor, $id_produto, $dias, $status_vitrine);
$dados_oferta->fetch();

$dados_oferta->free_result();

if($status_vitrine)
{
$status_vitrine = 0;
$update_vitrine->bind_param('ii', $status_vitrine, $id[$i]);
$update_vitrine->execute();
}



$data_criacao = date('Y-m-d');
$data = new DateTime($data_criacao);
$data->modify('+' . $dias . ' days');
$data_validade = $data->format('Y-m-d');




$stmt->bind_param("iiiissdd", $id_fornecedor, $id_produto, $comprador, $id[$i], $data_criacao, $data_validade, 
$valor_oferta, $valortotal_compra);
$stmt->execute();

$update->bind_param('ii', $carrinho, $id[$i]);
$update->execute();

$ANR = "a";
     
       
            $sql = $conexao->prepare("update notificacoes set ANR_aprovado = ? where oferta = ?");
            $sql->bind_param("si", $ANR, $id[$i]);
            $sql->execute();     
            $sql->close();



}
// Commit só depois que tudo ocorreu bem
$conexao->commit();



}  catch (Exception $e) {
    $conexao->rollback(); // algo deu errado
    error_log("Erro: " . $e->getMessage());
}finally {
    // Fecha os statements e conexão sempre, deu erro ou não
    $dados_oferta->close();
    $update->close();
    $update_vitrine->close();
    $stmt->close();
    $conexao->close();
}
if ($_SESSION['permissao'] == 4){
header('Location: ../arquivos_site/paginas/adminhome.php');
exit;
}
header('Location: ../arquivos_site/paginas/fornecedor.php');
exit;
}else {
    header('Location: ../index.html');
    exit;
}

?>