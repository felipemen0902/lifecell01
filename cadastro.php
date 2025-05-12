<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Upload da foto
    $foto = $_FILES['foto']['name'];
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $uploadDir = "uploads/";

    // Cria o diretório, se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fotoPath = $uploadDir . basename($foto);
    if (move_uploaded_file($fotoTmp, $fotoPath)) {
        $sql = "INSERT INTO usuarios (email, senha, foto) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $senha, $fotoPath);

        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            if ($stmt->errno == 1062) {
                echo "Este e-mail já está cadastrado.";
            } else {
                echo "Erro ao cadastrar: " . $stmt->error;
            }
        }

        $stmt->close();
    } else {
        echo "Erro ao enviar a foto.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuário</h2>
        <form action="cadastro.php" method="POST" enctype="multipart/form-data">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Senha</label>
            <input type="password" name="senha" required>

            <label>Foto de Perfil</label>
            <input type="file" name="foto" accept="image/*" required>

            <button type="submit">Cadastrar</button>
            <a href="login.php">Ja tem uma conta?</a>
        </form>
    </div>
</body>
</html>
