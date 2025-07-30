<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/upload" method="POST" enctype="multipart/form-data">
  <label for="profile-picture">Escolha sua foto de perfil:</label>
  <input type="file" id="profile-picture" name="profile-picture" accept="image/*" required>
  <button type="submit">Enviar</button>
</form>

</body>
</html>

<?php
echo $_POST[$id];

?>