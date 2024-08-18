<?php
session_start();

require_once '../classes/Historico.php';

$historico = new Historico();

$logs = $historico->getHistorico();

if (isset($_GET['remover'])) {
    $index = (int)$_GET['remover'];
    if ($index >= 0) {
        $historico->removerItem($index);
    }
    header('Location: historicoApp.php');
    exit();
}

if (isset($_GET['limpar'])) {
    $historico->limparHistorico();
    header('Location: historicoApp.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .historico-lista {
            list-style-type: none;
            padding: 0;
        }
        .historico-lista li {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            position: relative;
        }
        .historico-lista a {
            color: #ff4c4c;
            text-decoration: none;
        }
        .historico-lista a:hover {
            text-decoration: underline;
        }
        .historico-lista .remover-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            background-color: #ff4c4c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
        }
        .historico-lista .remover-btn:hover {
            background-color: #e03c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Histórico de Conversões</h1>

    <?php if (!empty($logs)): ?>
        <ul class="historico-lista">
            <?php foreach ($logs as $index => $log): ?>
                <li>
                    <?= htmlspecialchars($log) ?>
                    <a href="historicoApp.php?remover=<?= $index ?>" class="remover-btn" onclick="return confirm('Tem certeza que deseja remover este item?');">Remover</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Não há histórico.</p>
    <?php endif; ?>

    <a href="historicoApp.php?limpar=true" onclick="return confirm('Tem certeza que deseja limpar o histórico?');">Limpar Histórico</a>
</div>

</body>
</html>