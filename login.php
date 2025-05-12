<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o e-mail existe no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        // Verificar se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_foto'] = $usuario['foto'];

            // Redireciona para a interface
            header('Location: interface.php');
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit">Entrar</button>
        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </form>
</div>

</body>
</html>
