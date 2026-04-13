<?php
session_start(); // Запускаем сессию

// Инициализируем счетчик в сессии, если он еще не создан
if (!isset($_SESSION['total_count'])) {
    $_SESSION['total_count'] = 0;
}

// Инициализируем переменные для текущего запроса
$store = '';

// Проверяем, была ли нажата кнопка (передан параметр 'key').
if (isset($_GET['key'])) {
    $store = ($_GET['store'] ?? '') . $_GET['key'];
    $_SESSION['total_count']++;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа № А-3 | Попрядухин Евгений 241-352</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="calculator">
    <div class="result" title="<?php echo htmlspecialchars($store); ?>">
        <?php echo htmlspecialchars($store); ?>
    </div>

    <div class="buttons">
        <?php
        // Создаем кнопки для цифр от 1 до 9 и 0
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        foreach ($numbers as $num) {
            // Формируем GET-параметры для следующего запроса
            $params = http_build_query([
                'key' => $num,
                'store' => $store,
            ]);
            echo "<a href=\"?$params\">$num</a>";
        }
        ?>
        
        <a href="/" class="reset-button">СБРОС</a>
    </div>

    <div class="footer">
        Общее число нажатий: <?php echo $_SESSION['total_count']; ?>
    </div>
</div>

</body>
</html>
