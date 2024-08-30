<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Renda Passiva Mensal</title>
</head>
<body>

<h2>Calculadora de Renda Passiva Mensal</h2>

<form method="post">
    <label for="montante_inicial">Montante Inicial (R$):</label><br>
    <input type="number" step="0.01" id="montante_inicial" name="montante_inicial" required><br><br>

    <label for="aporte_mensal">Aporte Mensal (R$):</label><br>
    <input type="number" step="0.01" id="aporte_mensal" name="aporte_mensal"><br><br>

    <label for="juros_anual">Taxa de Juros Anual (%):</label><br>
    <input type="number" step="0.01" id="juros_anual" name="juros_anual" required><br><br>

    <label for="acrescimo_anual">Acréscimo Anual nos Aportes (%):</label><br>
    <input type="number" step="0.01" id="acrescimo_anual" name="acrescimo_anual"><br><br>

    <label for="renda_passiva_desejada">Renda Passiva Mensal Desejada (R$):</label><br>
    <input type="number" step="0.01" id="renda_passiva_desejada" name="renda_passiva_desejada" required><br><br>

    <input type="submit" value="Calcular">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os valores do formulário, com valores padrão caso não sejam fornecidos
    $montante_inicial = (float)$_POST['montante_inicial'];
    $aporte_mensal = isset($_POST['aporte_mensal']) ? (float)$_POST['aporte_mensal'] : 0;
    $juros_anual = (float)$_POST['juros_anual'] / 100; // Convertendo para decimal
    $acrescimo_anual = isset($_POST['acrescimo_anual']) ? (float)$_POST['acrescimo_anual'] / 100 : 0;
    $renda_passiva_desejada = (float)$_POST['renda_passiva_desejada'];

    // Função para calcular o tempo até atingir a renda passiva desejada (mensal)
    function calcular_tempo_ate_renda_passiva($montante_inicial, $aporte_mensal, $juros_anual, $acrescimo_anual, $renda_passiva_desejada) {
        $montante = $montante_inicial;
        $anos = 0;

        while (true) {
            $montante += $aporte_mensal * 12; // Aporte anual
            $montante *= (1 + $juros_anual); // Aplicação do juros anual
            $aporte_mensal *= (1 + $acrescimo_anual); // Ajuste do aporte mensal com acréscimo anual
            $anos++;
            $renda_passiva_mensal = $montante * ($juros_anual / 12); // Calcula a renda passiva mensal
            if ($renda_passiva_mensal >= $renda_passiva_desejada) {
                break;
            }
        }

        return array($anos, $montante);
    }

    // Calcula o tempo necessário para atingir a renda passiva mensal desejada
    list($tempo_para_renda_passiva, $montante_final) = calcular_tempo_ate_renda_passiva($montante_inicial, $aporte_mensal, $juros_anual, $acrescimo_anual, $renda_passiva_desejada);

    // Exibe os resultados
    echo "<h3>Resultados:</h3>";
    echo "<p>Montante Inicial: <strong>R$ " . number_format($montante_inicial, 2, ',', '.') . "</strong></p>";
    echo "<p>Aporte Mensal: <strong>R$ " . number_format($aporte_mensal, 2, ',', '.') . "</strong></p>";
    echo "<p>Taxa de Juros Anual: <strong>" . number_format($juros_anual * 100, 2, ',', '.') . "%</strong></p>";
    echo "<p>Acréscimo Anual nos Aportes: <strong>" . number_format($acrescimo_anual * 100, 2, ',', '.') . "%</strong></p>";
    echo "<p>Renda Passiva Mensal Desejada: <strong>R$ " . number_format($renda_passiva_desejada, 2, ',', '.') . "</strong></p>";
    echo "<p>Valor aportado ao final do período: <strong>R$ " . number_format(($aporte_mensal * 12 * $tempo_para_renda_passiva) + $montante_inicial , 2, ',', '.') . "</strong></p>";
    echo "<p>Tempo para atingir a renda passiva mensal desejada: <strong>$tempo_para_renda_passiva anos</strong></p>";
    echo "<p>Montante final acumulado: <strong>R$ " . number_format($montante_final, 2, ',', '.') . "</strong></p>";
}
?>

</body>
</html>