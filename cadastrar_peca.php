<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexao.php';

    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $unidades = $_POST['unidades'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO pecas (codigo, descricao, unidades, valor) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssid", $codigo, $descricao, $unidades, $valor);
    if ($stmt->execute()) {
        echo "Peça cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar a peça!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Peça</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Cadastrar Peça</h2>
    <form action="cadastrar_peca.php" method="POST">
        <div class="input-group">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" required>
        </div>
        <div class="input-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required></textarea>
        </div>
        <div class="input-group">
            <label for="unidades">Unidades</label>
            <input type="number" id="unidades" name="unidades" required>
        </div>
        <div class="input-group">
            <label for="valor">Valor</label>
            <input type="text" id="valor" name="valor" required>
        </div>
        <button type="submit">Cadastrar Peça</button>
        <a href="interface.php">Pesquisa estoque</a>
    </form>
</div>

</body>
</html>
