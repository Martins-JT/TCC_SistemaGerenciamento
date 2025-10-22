<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once('conexao.php');
if (!isset($_SESSION['usuario']))
{
    header('Location: ../index.html');
    exit;  
}
    $nome = $_POST['nome'];
    $id = $_POST['id'];
    $areasinteresse = $_POST['areas_interesse'] ?? [];
    $interesses = implode(',', $areasinteresse);

    $caminho_completo = null;

    if (empty($areasinteresse))
    {
        header('Location: ../arquivos_site/paginas/perfil.php');
    }

    // 🔎 Buscar imagem antiga no banco
    $busca = $conexao->prepare("SELECT foto FROM fornecedores WHERE id = ?");
    $busca->bind_param('i', $id);
    $busca->execute();
    $resultado = $busca->get_result();
    $foto_antiga = '';

    if ($resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $foto_antiga = $linha['foto'];
    }

    // 📤 Upload da nova imagem (se houver)
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
        $tamanho_maximo = 2 * 1024 * 1024; // 2 MB

        $arquivo_tmp = $_FILES['imagem']['tmp_name'];
        $arquivo_nome = basename($_FILES['imagem']['name']);
        $arquivo_tipo = mime_content_type($arquivo_tmp);
        $arquivo_tamanho = $_FILES['imagem']['size'];

        if (!in_array($arquivo_tipo, $tipos_permitidos)) {
            echo "Tipo de arquivo não permitido. Envie apenas JPG ou PNG.";
            exit;
        }

        if ($arquivo_tamanho > $tamanho_maximo) {
            echo "Arquivo muito grande. O limite é 2MB.";
            exit;
        }

        $extensao = pathinfo($arquivo_nome, PATHINFO_EXTENSION);
        $nome_unico = uniqid('img_', true) . '.' . $extensao;

        $pasta_destino = 'img/';
        $caminho_completo = $pasta_destino . $nome_unico;

        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }

        if (move_uploaded_file($arquivo_tmp, $caminho_completo)) {
            echo "Upload feito com sucesso! Caminho: " . $caminho_completo;

            // 🧹 Excluir imagem antiga se não for a padrão
            if (!empty($foto_antiga) && $foto_antiga !== 'usuario.png' && file_exists($foto_antiga)) {
                // A FOTO ANTIGA É A PADRÃO QUE NÃO SERÁ APAGADA
                unlink($foto_antiga);
            }
        } else {
            echo "Erro ao salvar o arquivo.";
            exit;
        }
    }

    // 💾 Atualiza o banco (com ou sem nova imagem)
    if ($caminho_completo) {
        $update = $conexao->prepare("UPDATE fornecedores SET interesses = ?, foto = ? WHERE id = ?");
        $update->bind_param('ssi', $interesses, $caminho_completo, $id);
    } else {
        $update = $conexao->prepare("UPDATE fornecedores SET interesses = ? WHERE id = ?");
        $update->bind_param('si', $interesses, $id);
    }

    $update->execute();
     
    header('Location: ../arquivos_site/paginas/perfil.php');
    exit;
} else {
    header('Location: ../index.html');
    exit;
    
}
?>
