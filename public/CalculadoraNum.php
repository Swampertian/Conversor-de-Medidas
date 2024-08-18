<?php
require_once '../classes/calculadoraNum.php';

$operacao = isset($_POST['operacao']) ? $_POST['operacao'] : '';
$labelNumero1 = "Número 1:";
$labelNumero2 = "Número 2:";
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero1 = isset($_POST['numero1']) ? floatval($_POST['numero1']) : 0;
    $numero2 = isset($_POST['numero2']) ? floatval($_POST['numero2']) : null;

    $calculadora = new CalculadoraNum();
    $calculadora->setNumeros($numero1, $numero2);

    switch ($operacao) {
        case 'somar':
            $resultado = $calculadora->somar();
            break;
        case 'subtrair':
            $resultado = $calculadora->subtrair();
            break;
        case 'multiplicar':
            $resultado = $calculadora->multiplicar();
            break;
        case 'dividir':
            $resultado = $calculadora->dividir();
            break;
        case 'raiz':
            $resultado = $calculadora->raizQuadrada();
            $labelNumero2 = ''; // Não usar o segundo número
            break;
        case 'logaritmo':
            $labelNumero1 = "Base:";
            $labelNumero2 = "Logaritmando:";
            $resultado = $calculadora->logaritmo();
            break;
        default:
            $resultado = 'Operação inválida';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Numérica Básica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo-container">
        <img src="caminho/para/sua/logo.png" alt="Logo">
    </div>

    <div class="container">
        <h1>Calculadora Numérica</h1>
        <form method="POST" action="CalculadoraNum.php">
            <div id="numero1-container">
                <label for="numero1"><?= htmlspecialchars($labelNumero1) ?></label>
                <input type="number" step="any" name="numero1" id="numero1" required>
                <br><br>
            </div>

            <?php if ($operacao !== 'raiz'): ?>
            <div id="numero2-container">
                <label for="numero2"><?= htmlspecialchars($labelNumero2) ?></label>
                <input type="number" step="any" name="numero2" id="numero2" <?= $operacao !== 'raiz' ? 'required' : '' ?>>
                <br><br>
            </div>
            <?php endif; ?>

            <label for="operacao">Operação:</label>
            <select name="operacao" id="operacao" onchange="this.form.submit()">
                <option value="somar" <?= $operacao === 'somar' ? 'selected' : '' ?>>Somar</option>
                <option value="subtrair" <?= $operacao === 'subtrair' ? 'selected' : '' ?>>Subtrair</option>
                <option value="multiplicar" <?= $operacao === 'multiplicar' ? 'selected' : '' ?>>Multiplicar</option>
                <option value="dividir" <?= $operacao === 'dividir' ? 'selected' : '' ?>>Dividir</option>
                <option value="raiz" <?= $operacao === 'raiz' ? 'selected' : '' ?>>Raiz Quadrada</option>
                <option value="logaritmo" <?= $operacao === 'logaritmo' ? 'selected' : '' ?>>Logaritmo</option>
            </select>
            <br><br>

            <div class="buttons-container">
                <button type="submit" class="btn">Calcular</button>
            </div>
        </form>

        <?php if ($resultado !== ''): ?>
            <h2>Resultado: <?= htmlspecialchars($resultado) ?></h2>
        <?php endif; ?>
    </div>
</body>
</html>
