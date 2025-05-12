<?php
include('conexao.php');

$termo = isset($_GET['termo']) ? trim($_GET['termo']) : '';
$sql = "SELECT * FROM pecas";
if ($termo !== '') {
    $sql .= " WHERE codigo LIKE ? OR descricao LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeTermo = "%$termo%";
    $stmt->bind_param("ss", $likeTermo, $likeTermo);
} else {
    $stmt = $conn->prepare($sql);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Peças</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #e9ecf3;
            font-family: 'Segoe UI', sans-serif;
        }

        header {
            background-color: #001f3f;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 24px;
            margin: 0;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown button {
            background-color: #003366;
            color: white;
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            margin: 40px auto;
            max-width: 900px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #003d80;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #003366;
            color: white;
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Seu Sistema de Peças</h1>
        <div class="dropdown">
            <button>Menu</button>
            <div class="dropdown-content">
                <a href="cadastrar_peca.php">Cadastrar Peça</a>
                <a href="alterar_senha.php">Alterar Senha</a>
                <a href="login.php">Sair</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Pesquisar Peças</h2>
        <form method="GET">
            <input type="text" name="termo" placeholder="Digite código ou descrição..." value="<?php echo htmlspecialchars($termo); ?>">
            <button type="submit">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Unidades</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['codigo']); ?></td>
                        <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                        <td><?php echo htmlspecialchars($row['unidades']); ?></td>
                        <td>R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> Seu Nome ou Empresa. Todos os direitos reservados.
    </footer>
</body>
</html>
