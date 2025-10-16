<?php
$servidor = 'localhost';

$usuario = 'root';

$senha = '';

$banco = 'sistema_gerenciamento_db';

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

/* if (mysqli_connect_error())
{
    echo "problema na conexão".mysqli_connect_error();
}
else
{
echo "conectado";
} */
?>