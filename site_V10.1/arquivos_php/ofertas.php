<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
session_start();
include_once('conexao.php');
if (!isset($_SESSION['usuario']))
{
    header('Location: ../index.html');
    exit;  
}

$dias = $_POST['dias'];
$id = $_SESSION['id'];
$id_produto = $_POST['produto_id'];
$valor = str_replace(',', '.', $_POST['valor']);
date_default_timezone_set('America/Sao_Paulo');
$data_inicio = date('Y-m-d H:i:s');
$status = 1;
$identificador = 0;


$dados_recebidos = $conexao->prepare("SELECT exibir_vitrine FROM produtos where id_produto = ?");
$dados_recebidos->bind_param('i', $id_produto);
$dados_recebidos->execute();
$dados_recebidos->bind_result($vitrine_status);

$dados_recebidos->fetch();
$dados_recebidos->close();


$status = 0;
$update = $conexao->prepare("UPDATE produtos set estado_produto = ? where id_produto = ?");
$update->bind_param('ii', $status, $id_produto);
$update->execute();
$update->close();

if ($_SESSION['permissao'] == 4)
$identificador = 1;


$sql = "INSERT INTO ofertas(id_fornecedor, id_produto,
data_inicio, dias, status, exibir_vitrine, identificador) 
VALUES(?, ?, ?, ?, ?, ?, ?)";
$status = 1;
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iisiiii", $id, $id_produto,
$data_inicio, $dias, $status, $vitrine_status, $identificador);
$stmt->execute(); 
$stmt->close();

//inserção na tabela notificações
$sql = "SELECT o.id_fornecedor,  o.id_oferta, o.id_produto, p.marca,
o.data_inicio, o.dias, o.identificador, f.email from ofertas o  
inner join produtos p on 
o.id_produto = p.id_produto
inner join fornecedores f on
o.id_fornecedor = f.id
where data_inicio = ? and identificador = ?
 ";
 $stmt1 = $conexao->prepare($sql);
 $stmt1->bind_param('si',$data_inicio,$identificador);
 $stmt1->execute();
$resultado = $stmt1->get_result();



if($dados = $resultado->fetch_assoc()){
   
$fornecedor = $dados['id_fornecedor'];
$oferta = $dados['id_oferta'];
$produto = $dados['id_produto'];
$data_inicio = $dados['data_inicio'];

}

if ($_SESSION['permissao'] == 4){
$identificador = 1;
$destino = 0;
}else
$destino = 1;

     
       
            $sql = $conexao->prepare("INSERT INTO notificacoes(fornecedor, oferta, identificador, destinatario) values (?,?,?,?)");
            $sql->bind_param("iisi", $fornecedor, $oferta, $identificador, $destino);
            $sql->execute();     
            $sql->close();
      

 $stmt1->close();


mysqli_close($conexao);
if ($_SESSION['permissao'] == 4)
    {
    header('location: ../arquivos_site/paginas/requisicoes.php');
    exit;    
    }
header('location: ../arquivos_site/paginas/ofertas_fornecedor.php');
exit;
}
else{
    header('Location: ../index.html');
    exit;
}
?>