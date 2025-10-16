<?php
session_start();
if ($_SESSION['permissoes'] == 'admin')
{
    session_abort();
    include_once('sidebar_admin.php');
}
else{
session_abort();
include_once('sidebar.php');
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- <link rel="stylesheet" href="ofertas.css"> -->
</head>
<body>
<?php
/*     include_once('conexao.php'); */
    $conexao = mysqli_connect('localhost', 'root', '', 'sistema_gerenciamento_db');
    $sql = $conexao->prepare("SELECT id, nome_empresa, email, cnpj, interesses, telefone, rua, numero, cidade, 
    estado, cep, foto FROM FORNECEDORES where id = ?");
    $sql->bind_param('i', $_SESSION['id']);
    $sql->execute();
    $resultado = $sql->get_result();
    if (mysqli_num_rows($resultado) > 0) {
    while($dados = mysqli_fetch_assoc($resultado))
    {
      
       $interesse = $dados['interesses'];
       $array_interesse = explode(",", $interesse);
       
   
    
    /* print_r($array_interesse); */


    /* $array_interesse = explode(",", $interesse); */
    /* 
    
    explode(string $delimitador, string $string, int $limite = PHP_INT_MAX): array

    $delimitador: o caractere (ou sequência de caracteres) usado para dividir a string.

$string: a string original que será dividida.

$limite (opcional): número máximo de elementos no array resultante.

    */
    ?>
<div class="centro"><!-- ABERTURA DIV CENTRO -->
    <form action="../../arquivos_php/alterar.php" method="post" enctype="multipart/form-data">
    <div class="conteudo_pagina"><!-- ABERTURA DIV CONTEUDO_PAGINA -->
        <div class="container_perfil"><!-- ABERTURA DIV CONTAINER_PERFIL -->
                <div class="foto_perfil">
                <img src="../../arquivos_php/<?php echo $dados['foto']; ?>" id="preview" >
                <input type="file" name="imagem" accept="image/*" id="arquivoinput" style="display: none;">
                </div>

            <div class="coluna1"><!-- ABERTURA DIV COLUNA1 -->
                <label for="nome">Nome: </label>
                <input type="text" name="nome" id="nome" value="<?php echo $dados['nome_empresa']; ?>" readonly>

                <label for="cnpj">Cnpj: </label>
                <input type="text" name="" id="cnpj" value="<?php echo $dados['cnpj']; ?>" readonly>

                <label for="telefone">Telefone: </label>
                <input type="text" name="telefone" id="telefone" value="<?php echo $dados['telefone']; ?>" readonly>

            </div><!-- FECHAMENTO DIV COLUNA1 -->

            <div class="coluna2"><!-- ABERTURA DIV COLUNA 2 -->
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" autocomplete="email" value="<?php echo $dados['email']; ?>" readonly>

                <label for="rua"> Rua: </label>
                <input type="text" name="rua" id="rua" value="<?php echo $dados['rua']; ?>" readonly>

                <label for="numero">Numero: </label>
                <input type="text" name="numero" id="numero" value="<?php echo $dados['numero']; ?>" readonly>
            
            </div><!-- FECHAMENTO DIV COLUNA 2 -->

            <div class="coluna3"><!-- ABERTURA DIV COLUNA 3 -->
                <label for="cidade">Cidade: </label>
                <input type="text" name="cidade" id="cidade" value="<?php echo $dados['cidade']; ?>" readonly>

                <label for="estado">Estado: </label>
                <input type="text" name="estado" id="estado" value="<?php echo $dados['estado']; ?>" readonly>

                <label for="cep"> Cep: </label>
                <input type="text" name="cep" id="cep" value="<?php echo $dados['cep']; ?>" readonly>

            
            </div><!-- FECHAMENTO DIV COLUNA 3 -->

            

        </div><!-- FECHAMENTO DIV CONTAINER_PERFIL -->
        
        <div class="coluna_areas"><!-- ABERTURA DIV COLUNA AREAS -->
                <div class="coluna1_interesses"><!-- ABERTURA COLUNA1_INTERESSES -->
                    <div class="item-checkbox">
                        Alvenaria
                        <input type="checkbox" name="areas_interesse[]" value="alvenaria" <?php echo in_array('alvenaria', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                    <div class="item-checkbox">
                        Acabamento
                        <input type="checkbox" name="areas_interesse[]" value="acabamento" <?php echo in_array('acabamento', $array_interesse) ? 'checked' : ''; ?> > 
                    </div>
                    <div class="item-checkbox">
                        Pintura
                        <input type="checkbox" name="areas_interesse[]" value="pintura" <?php echo in_array('pintura', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                    <div class="item-checkbox">
                        Carpintaria
                        <input type="checkbox" name="areas_interesse[]" value="carpintaria" <?php echo in_array('carpintaria', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                </div> <!-- FECHAMENTO COLUNA1_INTERESSES -->

                <div class="coluna2_interesses"><!-- ABERTURA COLUNA2_INTERESSES -->
                    <div class="item-checkbox">
                        Hidráulica
                        <input type="checkbox" name="areas_interesse[]" value="hidraulica" <?php echo in_array('hidraulica', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                    <div class="item-checkbox">
                        Fundações
                        <input type="checkbox" name="areas_interesse[]" value="fundacoes" <?php echo in_array('fundacoes', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                    <div class="item-checkbox">
                        Drywall
                        <input type="checkbox" name="areas_interesse[]" value="drywall" <?php echo in_array('drywall', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                    <div class="item-checkbox">
                        Eletrica
                        <input type="checkbox" name="areas_interesse[]" value="eletrica" <?php echo in_array('eletrica', $array_interesse) ? 'checked' : ''; ?> >
                    </div>
                </div><!-- FECHAMENTO COLUNA2_INTERESSES -->

                <div class="coluna3_interesses"><!-- ABERTURA COLUNA3_INTERESSES -->
                <div class="item-checkbox">
                    Estruturas Metálicas
                    <input type="checkbox" name="areas_interesse[]" value="estruturas" <?php echo in_array('estruturas', $array_interesse) ? 'checked' : ''; ?> >
                </div>
                <div class="item-checkbox">
                    Impermeabilização
                    <input type="checkbox" name="areas_interesse[]" value="impermeabilizacao" <?php echo in_array('impermeabilizacao', $array_interesse) ? 'checked' : ''; ?> >
                </div>
                </div><!-- FECHAMENTO COLUNA3_INTERESSES -->
            
            </div><!-- FECHAMENTO DIV COLUNA AREAS-->
            <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
            <div class="botoes">
            <button type="button" id="btnalterar" onclick="conferirDados()">Alterar</button>
            <?php
             }} else {
    echo "Nenhum resultado encontrado.";
}
            ?>
            </div>
    </div><!-- FECHAMENTO DIV CONTEUDO_PAGINA -->
    <div class="controle_conteudo" id="detalhes-conteudo" onclick="fecharaoclicarfora(event)">
<div class="conteudo">
    
    Você tem certeza que deseja alterar os dados?
    <div id="line"></div>
    <div class="botoes">
    <button type="submit" id="btnconfirmar"> Alterar </button>
    <button type="button" id="btncancelar" onclick="fecharConteudo()"> Rejeitar </button>
    </div>
</div>
</div>
    </form>
</div><!-- FECHAMENTO DIV CENTRO -->


</body>
<script>
    function conferirDados() {
  document.getElementById('detalhes-conteudo').style.display = 'flex';
}

function fecharConteudo() {
  document.getElementById('detalhes-conteudo').style.display = 'none';
}

function fecharaoclicarfora(event) {
  const dados = document.getElementById("detalhes-conteudo");
  const conteudo = dados.querySelector(".conteudo");
  if (!conteudo.contains(event.target)) {
    dados.style.display = "none";
  }
}
const input = document.getElementById('arquivoinput');
const preview = document.getElementById('preview');

let imagemOriginalSrc = preview.src;
let ultimaImagemSelecionada = null;

// Abre seletor ao clicar na imagem
preview.addEventListener('click', () => {
    input.click();
});

// Lida com seleção de imagem
input.addEventListener('change', function () {
    const arquivo = this.files[0];

    if (arquivo) {
        ultimaImagemSelecionada = arquivo;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(arquivo);
    } else {
        // Usuário clicou em cancelar
        preview.src = ultimaImagemSelecionada ? preview.src : imagemOriginalSrc;
    }
});

// Antes de enviar o formulário, garante que o input tenha o último arquivo
document.querySelector('form').addEventListener('submit', function () {
    if (!input.files.length && ultimaImagemSelecionada) {
        const dt = new DataTransfer();
        dt.items.add(ultimaImagemSelecionada);
        input.files = dt.files;
    }
});


</script>
<!--  <label for="Eletrica">Eletrica</label>
            <input type="checkbox" name="areas_interesse[]" value="eletrica" <?php /* echo in_array('eletrica', $array_interesse) ? 'checked' : '';  */?> > -->
</html>