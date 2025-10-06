<?php
include_once('../../arquivos_php/conexao.php');

$id = $_POST['id'];
echo $id;


  $sqlremove = "DELETE from ofertas where id_oferta = $id";
  
  $result2 = mysqli_query($conexao, $sqlremove);

  mysqli_close($conexao);

  header('location: adminhome.php');
  exit;


?>