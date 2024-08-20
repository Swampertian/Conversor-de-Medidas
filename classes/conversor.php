<?php
session_start(); // Inicia a sessão

require_once '../classes/Historico.php'; // Inclui a classe Historico

function converterUnidades($valor, $tipo_medida, $unidadeOrigem, $unidadeDestino) {
    // Matriz de fatores de conversão
    $fatoresConversao = [
        'Comprimento' => [
            'Quilômetro' => [
                'Quilômetro' => 1.0,
                'Metro' => 1000.0,
                'Centímetro' => 100000.0,
                'Milímetro' => 1000000.0
            ],
            'Metro' => [
                'Quilômetro' => 0.001,
                'Metro' => 1.0,
                'Centímetro' => 100.0,
                'Milímetro' => 1000.0
            ],
            'Centímetro' => [
                'Quilômetro' => 0.00001,
                'Metro' => 0.01,
                'Centímetro' => 1.0,
                'Milímetro' => 10.0
            ],
            'Milímetro' => [
                'Quilômetro' => 0.000001,
                'Metro' => 0.001,
                'Centímetro' => 0.1,
                'Milímetro' => 1.0
            ]
        ],
        'Volume' => [
            'Litro' => [
                'Litro' => 1.0,
                'Mililitro' => 1000.0,
                'Metro cúbico' => 0.001
            ],
            'Mililitro' => [
                'Litro' => 0.001,
                'Mililitro' => 1.0,
                'Metro cúbico' => 0.000001
            ],
            'Metro cúbico' => [
                'Litro' => 1000.0,
                'Mililitro' => 1000000.0,
                'Metro cúbico' => 1.0
            ]
        ],
        'Massa' => [
            'Quilograma' => [
                'Quilograma' => 1.0,
                'Grama' => 1000.0,
                'Miligramas' => 1000000.0,
                'Tonelada' => 0.001
            ],
            'Grama' => [
                'Quilograma' => 0.001,
                'Grama' => 1.0,
                'Miligramas' => 1000.0,
                'Tonelada' => 0.000001
            ],
            'Miligramas' => [
                'Quilograma' => 0.000001,
                'Grama' => 0.001,
                'Miligramas' => 1.0,
                'Tonelada' => 0.000000001
            ],
            'Tonelada' => [
                'Quilograma' => 1000.0,
                'Grama' => 1000000.0,
                'Miligramas' => 1000000000.0,
                'Tonelada' => 1.0
            ]
        ]
    ];

    // Verifica se a conversão é possível
    foreach ($fatoresConversao as $tipo => $unidades) {
        if (isset($unidades[$unidadeOrigem][$unidadeDestino])) {
            return $valor * $unidades[$unidadeOrigem][$unidadeDestino];
        }
    }
    return "Conversão não disponível.";
}

$unidades = [
    'Comprimento' => ['Quilômetro', 'Metro', 'Centímetro', 'Milímetro'],
    'Volume' => ['Litro', 'Mililitro', 'Metro cúbico'],
    'Massa' => ['Quilograma', 'Grama', 'Miligramas', 'Tonelada']
];

$tipo_selecionado = $_POST['tipo_medida'] ?? 'Comprimento';
$unidades_origem = $unidades[$tipo_selecionado];
$unidades_destino = $unidades[$tipo_selecionado];

$valor = $_POST['valor'] ?? ''; // Armazena o valor submetido anteriormente, se existir
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['valor']) && is_numeric($_POST['valor'])) {
        $valor = (float)$_POST['valor'];
        $tipoMedida = $_POST['tipo_medida'] ?? 'Comprimento';
        $unidadeOrigem = $_POST['unidade_origem'] ?? 'Metro';
        $unidadeDestino = $_POST['unidade_destino'] ?? 'Centímetro';
    
        $resultado = converterUnidades($valor, $tipoMedida, $unidadeOrigem, $unidadeDestino);

        // Adiciona o resultado ao histórico apenas se for diferente do anterior
        if ($resultado !== null && $resultado !== $_SESSION['resultado']) {
            $historico = new Historico();
            $historico->adicionarHistorico("Convertido $valor $unidadeOrigem para $resultado $unidadeDestino");
        }

        // Armazena o resultado e outras informações na sessão
        $_SESSION['resultado'] = $resultado;
        $_SESSION['valor'] = $valor;
        $_SESSION['tipo_medida'] = $tipoMedida;
        $_SESSION['unidade_origem'] = $unidadeOrigem;
        $_SESSION['unidade_destino'] = $unidadeDestino;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Conversor de Unidades</title>
<link rel="stylesheet" href="../public/style.css">
</head>
<body>
<div class="container">
    <form method="POST">
        <!-- Tipo de Medida -->
        <div class="tipo_medida">
            <label for="tipo_medida">Escolha o tipo de medida:</label>
            <select name="tipo_medida" id="tipo_medida" onchange="this.form.submit()">
                <?php foreach ($unidades as $tipo => $lista_unidades): ?>
                    <option value="<?= htmlspecialchars($tipo) ?>" <?= htmlspecialchars($tipo) == htmlspecialchars($tipo_selecionado) ? 'selected' : '' ?>><?= htmlspecialchars($tipo) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    
        <label for="valor">Digite um valor:</label>
        <input type="number" name="valor" id="valor" value="<?= htmlspecialchars($valor) ?>" placeholder="Digite um valor!" required>

        <!-- Painel de Unidades -->
        <div class="painel_unidades-container">
            <!-- Unidade de Origem -->
            <div class="painel_unidade">
                <label for="unidade_origem">Escolha a unidade de origem:</label>
                <select name="unidade_origem" id="unidade_origem">
                    <?php foreach ($unidades_origem as $unidade): ?>
                        <option value="<?= htmlspecialchars($unidade) ?>" <?= htmlspecialchars($unidade) == htmlspecialchars($_POST['unidade_origem'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($unidade) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Unidade de Destino -->
            <div class="painel_unidade">
                <label for="unidade_destino">Escolha a unidade de destino:</label>
                <select name="unidade_destino" id="unidade_destino">
                    <?php foreach ($unidades_destino as $unidade): ?>
                        <option value="<?= htmlspecialchars($unidade) ?>" <?= htmlspecialchars($unidade) == htmlspecialchars($_POST['unidade_destino'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($unidade) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <input type="submit" value="Converter">
    </form>

    <?php if ($resultado !== ''): ?>
    <div>
        <p>Resultado: <?= htmlspecialchars($resultado) ?></p>
    </div>
    <?php endif; ?>

    <!-- Botão Home com margem superior -->
    <a href="../public/index.php" class="btn" style="display: inline-block; margin-top: 15px;">Home</a>
</div>
</body>
</html>