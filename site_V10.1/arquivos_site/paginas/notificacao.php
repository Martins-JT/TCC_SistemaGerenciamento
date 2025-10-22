
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
display:flex;
flex-direction: column;
padding:125px;
margin-left:30px;
min-height:100%;

min-width:97%;
}
.usuario
{
display:flex;

background-color: rgb(17 24 39 );
color: whitesmoke;
max-width:450px;
height: 8vh;
gap: 10px;
padding: 10px;
border:solid 1px antiquewhite;
border-radius: 12px;
width: fit-content;  

justify-content: center;
align-items: center;
& img
{
    width:40px;
    height:40px;
    
    border-radius: 60px;
   
    object-fit: cover;
    border: 1px solid cadetblue;
cursor: pointer;


}
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
  background-color: rgb(17 24 39 / var(--tw-bg-opacity, 1));
   color: whitesmoke; 
   font-family: Arial, sans-serif;
    width: 1050px;
    height: 96px;
     margin: 20px auto;
     margin-right: 100%;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);

   overflow: hidden;
   transition: all 0.4s ease-in-out;
}
.notificacao .h3
{
margin: 0; font-size: 18px;

}

.titulo
{
    width: 1200px;
display: flex;
 align-items: center;
  gap: 12px;
   margin-bottom: 12px;

   font-family: "Atlassian Sans", ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Ubuntu, "Helvetica Neue", sans-serif;
   font-size: 16px;
}
.btn
{
    margin-left:57%;
    color:whitesmoke;
    cursor:pointer;
}
.seta {
  transition: transform 0.3s ease;
  
  margin-left: 6px;
}

.seta.ativa {
  transform: rotate(180deg);

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

session_start();
if($_SESSION['permissao'] == 4)
{
    session_abort();
    include_once('sidebar_admin.php');
}
else{
session_abort();
include_once("sidebar.php");
}
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
echo"empresa: $usuario"."</div>";?>
    
</div>




<?php

$destino = 0;
$identificador = 1;
if($_SESSION['permissao'] == 4){
$destino = 1;
$identificador = 0;
}
    $conexao = new mysqli("localhost","root","","sistema_gerenciamento_db");

$visto = "n";
    $sql = $conexao->prepare('SELECT COUNT(*) FROM NOTIFICACOES WHERE SN_visto = ? and destinatario = ? or FORNECEDOR  = ?');
    $sql -> bind_param("sii",$visto,$destino,$id);
    $sql->execute();
    $sql->bind_result($contador);
    $sql->fetch();
    $sql->close();
    if($contador > 0){

    






/*
            Se o usuario logado for admin  o identificador deve ser 0 e o contrario deve ser 1;

*/
$teste1 = $conexao->prepare("select  f.NOME_EMPRESA, p.produto,p.caracteristica, o.data_inicio, n.oferta

                            from notificacoes n 

                            inner join fornecedores f 
                            on f.id = n.fornecedor
                            inner join ofertas o 
                            on o.id_oferta = n.oferta
                            inner join produtos p
                            on o.id_produto = p.id_produto

                            where n.destinatario = ? and n.identificador = ? and SN_visto = 'n'
                            order by o.data_inicio");
    $teste1 ->bind_param('ii',$destino, $identificador);
    $teste1->execute();
    $dados = $teste1->get_result();
    $teste1->close();

while($row = $dados->fetch_assoc()){
  
      echo '
            <div class="notificacao" data-id-oferta="' . $row["oferta"] . '" id="noti"">

                            <div class="titulo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#edf2f5" viewBox="0 0 24 24">
                                            <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                                        </svg>
                                        <h3>NOVA REQUISIÇÃO!</h3> 
                                        <a href="#" class="btn" onclick="aumentaDiv(this)">Veja mais <svg class="seta" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 24 24">
    }
    <path d="M7 10l5 5 5-5z"/></a>
                            </div>

                        <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                            Prezado(a) <strong>' . $_SESSION["empresa"]. '</strong>,<br><br>
                   

                    <div class = "saibaMais" style = dysplay:none;>
                            A empresa:<strong>'.$row["NOME_EMPRESA"].'</strong><br>
                            Faz uma REQUISIÇÃO do produto: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
                            Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
                            
                    </div>
                    
                </div>
                          
            </div>';

}


    

  
//funciona daqui pra baixo
    $teste2 = $conexao->prepare("select  f.NOME_EMPRESA, p.produto,p.caracteristica, o.data_inicio, n.ANR_aprovado

                            from notificacoes n 

                            inner join fornecedores f
                            on f.id = n.fornecedor
                            inner join ofertas o 
                            on o.id_oferta = n.oferta
                            inner join produtos p
                            on o.id_produto = p.id_produto
        where n.fornecedor = ? and SN_visto = 'n'
        order by o.data_inicio desc");
    $teste2 ->bind_param('i',$id);
    $teste2->execute();
    $dados = $teste2->get_result();
    $teste2->close();

    while($row = $dados->fetch_assoc())
    {

            $estado = $row['ANR_aprovado'];
            
    
  if($estado == "n" )
        {
    
            echo '
            <div class="notificacao" id="noti" ">

                <div class="titulo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#856404" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                    </svg>
                    <h3>OFERTA EM REVISÃO!</h3>
                    <a href="#" class="btn" onclick="aumentaDiv(this)">Veja mais <svg class="seta" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 24 24">
                 <path d="M7 10l5 5 5-5z"/></a>
                </div>

               <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                    Prezado(a) <strong>' . $row["NOME_EMPRESA"] . '</strong>,<br><br>
                    <div class = "saibaMais" style = display:none;>
                    Sua oferta: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
                    Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        Sua oferta está em revisão.
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#777474" d="M7 17h7v-2H7zm0-4h10v-2H7zm0-4h10V7H7zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm0-2h14V5H5zM5 5v14z"/></svg><br>
                       
                    </span>
                </div>
                </div>
            </div>';

    
        }

        else if($estado == "r" )
        {
                        echo '
                <div class="notificacao" id="noti"">

                    <div class="titulo">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                       </svg>
                            <h3>OFERTA <font color="indianred">REJEITADA</font>!</h3>
                            <a href="#" class="btn" onclick="aumentaDiv(this)">Veja mais <svg class="seta" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"  viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5z"/></a>
                    </div>

                    <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                                    Prezado(a) <strong>' . $row["NOME_EMPRESA"] . '</strong>,<br><br>
                                    <div class = "saibaMais" style = display:none;>
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
                    </div>

                </div>';

  }
  else if ($estado == "a" ){
    echo '<div class="notificacao" id="noti"">

                <div class="titulo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-2 12H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/>
                    </svg>
                    <h3>OFERTA <font color="cadetblue">APROVADA</font>!</h3>
                    <a href="#" class="btn" onclick="aumentaDiv(this)">Veja mais <svg class="seta" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 24 24">
    <path d="M7 10l5 5 5-5z"/></a>
                </div>

                    
                <div class="mensagem" style="font-size: 16px; line-height: 1.5;">
                    Prezado(a) <strong>' . $row["NOME_EMPRESA"] . '</strong>,<br><br>
                    <div class = "saibaMais" style = display:none;>
                    Sua oferta: <strong>' . $row["produto"] . '</strong><br>'.'Caracteristica: '.'<strong>'. $row["caracteristica"] . '</strong><br>
                    Início em: <strong>' . $row["data_inicio"] . '</strong><br><br>
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        Sua oferta foi aprovada.
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
      <path fill="none" d="M0 0h24v24H0z"/>
      <path d="M9 16.2l-4.4-4.4 1.4-1.4 3 3 7.4-7.4 1.4 1.4z" fill="#4CAF50"/>
    </svg>
                    </span>
                </div></div>

            </div>';

        }}}
        else
        {
            echo  '<div class="mobilidade">'."VOCÊ NÃO TEM NENHUMA NOTIFICAÇÃO!".'</div>';
        }
        
               
    
    

?>
</div>
<script>function aumentaDiv(el) {
    const div = el.closest('.notificacao');
    const conteudo = div.querySelector(".saibaMais");
    const seta = el.querySelector(".seta");
    const isAberto = conteudo.style.display === "block";

    if (!isAberto) {
        div.style.height = "220px";
        conteudo.style.display = "block";
        seta.classList.add("ativa");
        el.childNodes[0].textContent = "Mostrar menos";
/*
        // Enviar atualização para o PHP via AJAX
        const idOferta = div.getAttribute("data-id-oferta");
        fetch('marcar_como_visto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'oferta=' + encodeURIComponent(idOferta)
        })
        .then(response => response.text())
        .then(data => {
            if (data !== "ok") {
                console.error("Erro ao marcar como visto:", data);
                console.log(idOferta);
            }
        })
        .catch(error => {
            console.error("Erro na requisição AJAX:", error);
        });
*/
    } else {
        div.style.height = "96px";
        conteudo.style.display = "none";
        seta.classList.remove("ativa");
        el.childNodes[0].textContent = "Veja mais";
    }
}


</script>
</body>

</html>
