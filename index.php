<?php
if( isset( $_POST['A'] ) ) // если из формы были переданы данные
{
    // обработчик переданных из формы данных
    $A = $_POST['A'];
    $B = $_POST['B'];
    $C = $_POST['C'];

    // Заменяем запятую на точку для корректной работы с дробями
    $A = str_replace(',', '.', $A);
    $B = str_replace(',', '.', $B);
    $C = str_replace(',', '.', $C);

    $A = floatval($A);
    $B = floatval($B);
    $C = floatval($C);

    $user_result = str_replace(',', '.', $_POST['result']);

    if( $_POST['TASK'] == 'mean' ) // если вычисляется среднее арифметическое
    {
        $result = round( ($_POST['A']+$_POST['B']+$_POST['C'])/3, 2 );
        $task_name = 'СРЕДНЕЕ АРИФМЕТИЧЕСКОЕ';
    }
    else if( $_POST['TASK'] == 'triangle_area' ) // площадь треугольника (формула Герона)
    {
        $p = ($A+$B+$C)/2;
        $val = $p*($p-$A)*($p-$B)*($p-$C);
        $result = ($val > 0) ? round( sqrt($val), 2 ) : 0;
        $task_name = 'ПЛОЩАДЬ ТРЕУГОЛЬНИКА (формула Герона)';
    }
    else if( $_POST['TASK'] == 'perimetr' ) // если вычисляется периметр
    {
        $result = $A+$B+$C;
        $task_name = 'ПЕРИМЕТР ТРЕУГОЛЬНИКА';
    }
    else if( $_POST['TASK'] == 'volume' ) // объём параллелепипеда
    {
        $result = round($A*$B*$C, 2);
        $task_name = 'ОБЪЁМ ПАРАЛЛЕЛЕПИПЕДА';
    }
    else if( $_POST['TASK'] == 'sum_squares' ) // сумма квадратов
    {
        $result = round($A*$A + $B*$B + $C*$C, 2);
        $task_name = 'СУММА КВАДРАТОВ';
    }
    else if( $_POST['TASK'] == 'hypotenuse' ) // гипотенуза
    {
        $result = round(sqrt($A*$A + $B*$B), 2);
        $task_name = 'ГИПОТЕНУЗА (A и B — катеты)';
    }
}
?><!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Тест математических знаний</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleMail(cb) {
            var obj = document.getElementById('mail_block');
            if( cb.checked )
                obj.style.display = 'block';
            else
                obj.style.display = 'none';
        }
    </script>
</head>
<body>

<h1>Тест математических знаний</h1>

<?php
if( isset($result) ) // если форма была обработана
{
    // подготавливаем содержимое отчета
    $out_text = 'ФИО: '.$_POST['FIO'].'<br>';
    $out_text .= 'Группа: '.$_POST['GROUP'].'<br>';

    if($_POST['ABOUT']) $out_text .= '<br>'.$_POST['ABOUT'].'<br>';

    $out_text .= '<br>Решаемая задача: '.$task_name.'<br>';
    $out_text .= 'Входные данные: A='.$A.', B='.$B.', C='.$C.'<br>';

    if($user_result === '') {
        $out_text .= 'Задача самостоятельно решена не была.<br>';
    } else {
        $out_text .= 'Предполагаемый результат: '.$_POST['result'].'<br>';
    }

    $out_text .= 'Вычисленный программой результат: '.$result.'<br><br>';

    if($user_result !== '' && $result === floatval($user_result))
        $out_text .= '<br><b>ТЕСТ ПРОЙДЕН</b><br>';
    else
        $out_text .= '<br><b>ОШИБКА: ТЕСТ НЕ ПРОЙДЕН!</b><br>';

    // Выводим отчёт в зависимости от выбранной версии
    if($_POST['VERSION'] == 'print') {
        // Версия для печати — простой вид
        echo '<div class="result-container">';
        echo $out_text;
        echo '</div>';
    } else {
        // Версия для просмотра в браузере
        echo '<div class="result-container">';
        echo $out_text;

        // Отправка по почте
        if( array_key_exists('send_mail', $_POST) ) // если нужно отправить результаты
        {
            $sent = mail( $_POST['MAIL'], 'Результат тестирования',
                str_replace('<br>', "\r\n", $out_text),
                "From: auto@mami.ru\r\n"."Content-Type: text/plain; charset=utf-8\r\n" );

            if($sent)
                echo 'Результаты теста были автоматически отправлены на e-mail '.$_POST['MAIL'].'<br>';
            else
                echo 'Ошибка: не удалось отправить письмо. Проверьте настройки почтового сервера.<br>';
        }

        // Кнопка "Повторить тест" — ссылка с GET-параметрами для ФИО и группы
        echo '<a href="?F='.$_POST['FIO'].'&G='.$_POST['GROUP'].
             '" id="back_button">Повторить тест</a>';
        echo '</div>';
    }
}
else // если форма не обработана (данные не переданы в PHP)
{
    // Генерируем случайные значения от 0 до 100 (с дробной частью)
    $init_A = mt_rand(0, 10000) / 100;
    $init_B = mt_rand(0, 10000) / 100;
    $init_C = mt_rand(0, 10000) / 100;

    // Проверяем GET-параметры (при повторном тестировании)
    $init_FIO = isset($_GET['F']) ? $_GET['F'] : '';
    $init_GROUP = isset($_GET['G']) ? $_GET['G'] : '';

    echo '<div class="form-container">';
    echo '<form name="form" method="post" action="/">';

    echo '<label>ФИО:</label>';
    echo '<input type="text" name="FIO" value="'.$init_FIO.'">';

    echo '<label>Номер группы:</label>';
    echo '<input type="text" name="GROUP" value="'.$init_GROUP.'">';

    echo '<label>Немного о себе:</label>';
    echo '<textarea name="ABOUT" rows="3"></textarea>';

    echo '<label>Задача:</label>';
    echo '<select name="TASK">';
    echo '<option value="triangle_area">Площадь треугольника</option>';
    echo '<option value="perimetr">Периметр треугольника</option>';
    echo '<option value="volume">Объём параллелепипеда</option>';
    echo '<option value="mean">Среднее арифметическое</option>';
    echo '<option value="sum_squares">Сумма квадратов</option>';
    echo '<option value="hypotenuse">Гипотенуза (A и B — катеты)</option>';
    echo '</select>';

    echo '<label>Значение A:</label>';
    echo '<input type="text" name="A" value="'.$init_A.'">';

    echo '<label>Значение B:</label>';
    echo '<input type="text" name="B" value="'.$init_B.'">';

    echo '<label>Значение C:</label>';
    echo '<input type="text" name="C" value="'.$init_C.'">';

    echo '<label>Ваш ответ:</label>';
    echo '<input type="text" name="result">';

    echo '<div class="checkbox-row">';
    echo '<input type="checkbox" name="send_mail" onClick="toggleMail(this)"> ';
    echo '<label>Отправить результат теста по e-mail</label>';
    echo '</div>';

    echo '<div id="mail_block">';
    echo '<label>Ваш e-mail:</label>';
    echo '<input type="text" name="MAIL">';
    echo '</div>';

    echo '<label>Версия вывода:</label>';
    echo '<select name="VERSION">';
    echo '<option value="browser">Версия для просмотра в браузере</option>';
    echo '<option value="print">Версия для печати</option>';
    echo '</select>';

    echo '<input type="submit" value="Проверить">';

    echo '</form>';
    echo '</div>';
}
?>

</body>
</html>
