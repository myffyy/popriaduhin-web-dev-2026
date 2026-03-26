<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ЛР-4: Пользовательские функции и таблицы, Попрядухин Евгений 241-352</title>
    <style>
        body { font-family: sans-serif; margin: 2em; }
        table { border-collapse: collapse; margin-bottom: 20px; width: 60%; }
        td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        h1, h2 { color: #333366; }
        hr { margin: 20px 0; }
    </style>
</head>
<body>

<?php

function getTR($rowData, $columnCount) {
    if (trim($rowData) === '') {
        return '';
    }

    $cells = explode('*', $rowData);
    $html = '<tr>';
    
    for ($i = 0; $i < $columnCount; $i++) {
        $cellContent = isset($cells[$i]) ? htmlspecialchars(trim($cells[$i])) : '';
        $html .= '<td>' . $cellContent . '</td>';
    }
    
    $html .= '</tr>';
    return $html;
}

function outTable($structure, $tableNumber, $columnCount) {
    echo "<h2>Таблица №$tableNumber</h2>";

    if (trim($structure) === '') {
        echo "В таблице нет строк<br><br>";
        return;
    }

    $rows = explode('#', $structure);

    $tableContent = '';
    foreach ($rows as $rowString) {
        $tableContent .= getTR($rowString, $columnCount);
    }

    if ($tableContent === '') {
        echo "В таблице нет строк с ячейками<br><br>";
    } else {
        echo '<table>' . $tableContent . '</table>';
    }
}

echo "<h1>Лабораторная работа № А-4: Пользовательские функции</h1>";

$numberOfColumns = 5;

echo "<p>Заданное число колонок для всех таблиц: <strong>$numberOfColumns</strong></p><hr>";

if ($numberOfColumns <= 0) {
    echo "Неправильное число колонок";
} else {
    $structures = [
        'Фрукт*Цвет*Вкус#Яблоко*Красный*Сладкий#Банан*Желтый*Сладкий#Лайм*Зеленый*Кислый',
        'Имя*Фамилия*Город*Возраст*Хобби#Иван*Иванов*Москва*30*Футбол#Петр*Петров*СПб*25*Чтение#Анна*Сидорова*Брянск*28*Плавание',
        'Один*Два*Три*Четыре*Пять*Шесть*Семь',
        'Только одна строка*с двумя ячейками',
        '',
        '#Начало с разделителя',
        'Конец с разделителя#',
        'Двойной##разделитель',
        '*',
        'Просто текст без разделителей колонок',
        'Последняя*таблица#с*двумя#строками'
    ];

    foreach ($structures as $index => $structure) {
        outTable($structure, $index + 1, $numberOfColumns);
    }
}

?>

</body>
</html>
