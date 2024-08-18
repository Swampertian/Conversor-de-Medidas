<?php
require_once '../classes/calcular_area.php';

$calc = new Calculadora();
$result = null;
$medida = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numA = floatval($_POST['numA']);
    $numB = floatval($_POST['numB']);
    $opt = $_POST['tipo'];
    $medida = $_POST['med'];

    if ($opt == "retangulo") {
        $result = $calc->CalcAreaRetangulo($numA, $numB);
    } else if ($opt == "triangulo") {
        $result = $calc->CalcAreaTriangulo($numA, $numB);
    } else if ($opt == "circulo") {
        $result = $calc->CalcAreaCirculo($numA);
    }

    $medida .= "²";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/calculadora.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <title>Calculadora de Áreas</title>
</head>
<body>
    <div class="container">
        <form method="post">
            <h1>Calculadora de Áreas</h1>
            <div class="form-group">
                <label for="tipo">Forma Geométrica:</label>
                <select name="tipo" id="tipo">
                    <option value="retangulo">Retângulo</option>
                    <option value="triangulo">Triângulo</option>
                    <option value="circulo">Círculo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="med">Unidade:</label>
                <select name="med" id="med">
                    <option value="m">Metros</option>
                    <option value="cm">Centímetros</option>
                    <option value="km">Quilômetros</option>
                </select>
            </div>
            <div class="form-group">
                <label id="labelA" for="numA">Medida A:</label>
                <input type="number" name="numA" id="numA" step="any">
            </div>
            <div id="numB-group" class="form-group">
                <label id="labelB" for="numB">Medida B:</label>
                <input type="number" name="numB" id="numB" step="any">
            </div>
            <button type="submit">Calcular</button>
        </form>
        <?php if ($result !== null): ?>
            <h2>Resultado: <?= $result . $medida ?></h2>
        <?php endif; ?>
    </div>
</body>
</html>
