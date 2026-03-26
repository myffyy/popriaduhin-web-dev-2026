<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР А-2 | Попрядухин Е.Р. | 241-352</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <img src="images/Logo_Polytech_rus_main.jpg" alt="Логотип Университета">
        <div>
            <h1>Лабораторная работа № А-2</h1>
            <div class="user-info">
                <p>Выполнил: Попрядухин Евгений Романович</p>
                <p>Группа: 241-352</p>
                <p>Вариант: 10</p>
            </div>
        </div>
    </header>

    <main>
        <?php
        $type = strtoupper($_GET['type'] ?? 'A');

        $layout_names = [
            'A' => 'Простая верстка текстом',
            'B' => 'Маркированный список',
            'C' => 'Нумерованный список',
            'D' => 'Табличная верстка',
            'E' => 'Блочная верстка',
        ];

        $start_value = -16;
        $encounting = 17;
        $step = 2;
        $min_value = -100;
        $max_value = 100;

        $results = [];
        $function_values = [];

        for ($i = 0, $x = $start_value; $i < $encounting; $i++, $x += $step) {
            $f = 0;
            if ($x <= 10) {
                if ($x == 0) {
                    $f = 'error';
                } else {
                    $f = 3 / $x + $x / 3 - 5;
                }
            } elseif ($x < 20) {
                $f = ($x - 7) * ($x / 8);
            } else { // x >= 20
                $f = 3 * $x + 2;
            }

            if ($f !== 'error') {
                $f = round($f, 3);
                if ($f < $min_value || $f > $max_value) {
                    $results[] = ['x' => $x, 'f' => $f]; 
                    break;
                }
                $function_values[] = $f;
            }
            $results[] = ['x' => $x, 'f' => $f];
        }

        echo '<div class="layout-switcher">';
        echo '<form method="get">';
        echo '<label for="type">Выберите тип верстки: </label>';
        echo '<select name="type" id="type" onchange="this.form.submit()">';
        $types = ['A', 'B', 'C', 'D', 'E'];
        foreach ($types as $t) {
            $selected = ($t == $type) ? 'selected' : '';
            echo "<option value='$t' $selected>$t</option>";
        }
        echo '</select>';
        echo '</form>';
        echo '</div>';

        switch ($type) {
            case 'B':
                echo '<ul>';
                foreach ($results as $res) {
                    echo "<li>f({$res['x']}) = {$res['f']}</li>";
                }
                echo '</ul>';
                break;
            case 'C':
                echo '<ol>';
                foreach ($results as $res) {
                    echo "<li>f({$res['x']}) = {$res['f']}</li>";
                }
                echo '</ol>';
                break;
            case 'D':
                echo '<table class="results-table">';
                echo '<tr><th>#</th><th>Аргумент (x)</th><th>Значение (f(x))</th></tr>';
                foreach ($results as $j => $res) {
                    echo "<tr><td>".($j+1)."</td><td>{$res['x']}</td><td>{$res['f']}</td></tr>";
                }
                echo '</table>';
                break;
            case 'E':
                echo '<div class="results-blocks">';
                foreach ($results as $res) {
                    echo "<div>f({$res['x']}) = {$res['f']}</div>";
                }
                echo '</div>';
                break;
            case 'A':
            default:
                foreach ($results as $res) {
                    echo "f({$res['x']}) = {$res['f']}<br>";
                }
                break;
        }

        if (!empty($function_values)) {
            $sum = array_sum($function_values);
            $min = min($function_values);
            $max = max($function_values);
            $avg = $sum / count($function_values);

            echo '<div class="aggregates">';
            echo '<h3>Сводная информация</h3>';
            echo "<p>Сумма всех значений функции: " . round($sum, 3) . "</p>";
            echo "<p>Минимальное значение функции: " . round($min, 3) . "</p>";
            echo "<p>Максимальное значение функции: " . round($max, 3) . "</p>";
            echo "<p>Среднее арифметическое: " . round($avg, 3) . "</p>";
            echo '</div>';
        }
        ?>
    </main>

            <footer>
                <p>Тип верстки: <?php echo htmlspecialchars($type) . ': ' . htmlspecialchars($layout_names[$type] ?? 'Неизвестный'); ?></p>
            </footer>
</body>
</html>
