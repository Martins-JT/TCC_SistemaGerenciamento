
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/requisicoes.css">
    <link rel="stylesheet" href="../css/areasstyle.css">
    <style>

.fNotifica{

padding:100px;
margin-left:30px;
min-height:100%;

max-width:100%;
background-color: #d1d1d1;
& img
{
    width:2%;
    height:2%;
}
}
.usuario
{
display:flex;
}
.dados{
display:flex;
flex-direction:column ;
}
.notificacao
{
border: 1px solid #ccc;
 padding: 8px;
  border-radius: 8px; 
  background-color: white;
   color: #856404; font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1);

}
.notificacao .h3
{
margin: 0; font-size: 18px;
}

.titulo
{
display: flex; align-items: center; gap: 12px; margin-bottom: 12px;
}

.mobilidade
{
    display:flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height:70vh;
}
    </style>
</head>

<body>
<?php
include_once("sidebar.php");
$usuario = $_SESSION["empresa"];
$id = $_SESSION["id"];
$foto = $_SESSION["foto"];
$email = $_SESSION['usuario'];
?>

<div class="fNotifica">
    <div class="usuario">
<?php 
echo "<img src=../../arquivos_php/"."$foto".  ">";
echo "<div class="."dados".">";
echo "<p>Seja bem vindo, ".'<b>'."$email"."</b>".'</p>';
echo"empresa: $usuario"."<br>"."<br>"."</div>";?></div>
<?php





include_once('../../arquivos_php/conexao.php');
session_start();


if($_SESSION['permissoes'] == 'admin'){
    session_abort();
include_once('sidebar_admin.php');}
else{
    session_abort();
   include_once('sidebar.php'); 
}

$conexao = new mysqli('localhost', 'root', '', 'sistema_gerenciamento_db');
    $sql = "SELECT COUNT(*) FROM notificacoes where fornecedor = ?";
    $stmt = $conexao->prepare($sql);
    $stmt -> bind_param('i',$id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

        if($count > 0)
        {

            $sql1 = $conexao->prepare("SELECT n.fornecedor, f.NOME_EMPRESA, o.id_oferta, p.produto, p.caracteristica, n.estado, n.data_inicio, n.identificador, n.situacao FROM notificacoes n
                inner join produtos p
                on n.produto = p.id_produto
                inner join ofertas o
                on n.oferta = o.id_oferta
                inner join fornecedores f
                on n.fornecedor = f.id
                where n.fornecedor != ? and n.identificador = 1");
            $sql1->bind_param('i', $id);
            $sql1->execute();
            
            $resultado = $sql1->get_result();

            while($row =$resultado->fetch_assoc())
            {
                    $identi = $row['identificador'];
                    $situ = $row['situacao'];

                
                    echo '
            <div class="notificacao" ">

                <div class="titulo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#856404" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                            </svg>
                            <h3>NOVA REQUISIÇÃO!</h3>
                </div>

                <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                    Prezado(a) <strong>' . $_SESSION["empresa"]. '</strong>,<br><br>
                    A empresa:<strong>'.$row["NOME_EMPRESA"].'</strong><br>
                    Faz uma REQUISIÇÃO do produto: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
                    Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        Sua oferta está em revisão.
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#777474" d="M7 17h7v-2H7zm0-4h10v-2H7zm0-4h10V7H7zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm0-2h14V5H5zM5 5v14z"/></svg>
                    </span>
                </div>

            </div>';
                
            }










$sql = $conexao->prepare("SELECT  n.fornecedor, f.NOME_EMPRESA, o.id_oferta, p.produto, p.caracteristica, n.estado, n.data_inicio, n.identificador, n.situacao FROM notificacoes n
inner join produtos p
on n.produto = p.id_produto
inner join ofertas o
on n.oferta = o.id_oferta
inner join fornecedores f
on n.fornecedor = f.id
where fornecedor = ?");
$sql->bind_param('i', $id);
$sql->execute();
$resultado = $sql->get_result();


while($row = $resultado->fetch_assoc())
{
 //variaveis usadas como parâmetro.
$aprovacao = $row["estado"];
$estado = $row["situacao"];

  if($aprovacao == 0 && $estado == 0)
  {
            echo '
            <div class="notificacao" ">

                <div class="titulo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#856404" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                    </svg>
                    <h3>OFERTA EM REVISÃO!</h3>
                </div>

                <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                    Prezado(a) <strong>' . $row["NOME_EMPRESA"] . '</strong>,<br><br>
                    Sua oferta: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
                    Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        Sua oferta está em revisão.
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#777474" d="M7 17h7v-2H7zm0-4h10v-2H7zm0-4h10V7H7zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm0-2h14V5H5zM5 5v14z"/></svg>
                    </span>
                </div>

            </div>';


  }
  else if($aprovacao == 0 && $estado == 1)
  {
        echo '
<div class="notificacao" ">

    <div class="titulo">
       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
       </svg>
            <h3>OFERTA REJEITADA!!</h3>
    </div>

    <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
        Prezado(a) <strong>' . $row["NOME_EMPRESA"] . '</strong>,<br><br>
        Sua oferta: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
        Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
        <span style="display: inline-flex; align-items: center; gap: 8px;">
            infelizmente sua oferta foi rejeitada.
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"/>
                <path fill="#F44336" d="M18.3 5.7l-1.4-1.4-5.9 5.9-5.9-5.9-1.4 1.4 5.9 5.9-5.9 5.9 1.4 1.4 5.9-5.9 5.9 5.9 1.4-1.4-5.9-5.9z"/>
            </svg>
        </span>
    </div>

</div>';

  }
  else if ($aprovacao == 1 && $estado == 1){






    echo '<div class="notificacao" ">

                <div class="titulo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#856404" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                    </svg>
                    <h3>OFERTA APROVADA!</h3>
                </div>

                <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                    Prezado(a) <strong>' . $row["NOME_EMPRESA"] . '</strong>,<br><br>
                    Sua oferta: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
                    Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        Sua oferta foi aprovada.
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
      <path fill="none" d="M0 0h24v24H0z"/>
      <path d="M9 16.2l-4.4-4.4 1.4-1.4 3 3 7.4-7.4 1.4 1.4z" fill="#4CAF50"/>
    </svg>
                    </span>
                </div>

            </div>';

  }
 
   
 
  
}

    

}
else{
  echo  '<div class="mobilidade">'."VOCÊ NÃO TEM NENHUMA NOTIFICAÇÃO!".'</div>';
}
?>
</div>


</body>
</html>
