<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
// функция ВЫВОДИТ ЧИСЛО КАК ССЫЛКУ
function outNumAsLink( $x )
{
    if( $x<=9 )
        return '<a href="?content='.$x.'">'.$x.'</a>';
    else
        return $x;
}

// функция ВЫВОДИТ СТОЛБЕЦ ТАБЛИЦЫ УМНОЖЕНИЯ
function outRow ( $n )
{
    for($i=2; $i<=9; $i++) // цикл со счетчиком от 2 до 9
    {
        echo outNumAsLink($n).'x'.outNumAsLink($i).'='.
             outNumAsLink($i*$n).'<br>';
    }
}

// функция ВЫВОДИТ ТАБЛИЦУ УМНОЖЕНИЯ В ТАБЛИЧНОЙ ФОРМЕ
function outTableForm()
{
    echo '<table class="mult-table">';
    // если параметр content не был передан в программу
    if( !isset($_GET['content']) )
    {
        // выводим всю таблицу: 8 столбцов
        for($i=2; $i<=9; $i++)
        {
            echo '<tr>';
            for($j=2; $j<=9; $j++)
            {
                echo '<td>';
                echo outNumAsLink($i).'x'.outNumAsLink($j).'='.outNumAsLink($i*$j);
                echo '</td>';
            }
            echo '</tr>';
        }
    }
    else
    {
        // выводим один столбец
        $n = $_GET['content'];
        for($j=2; $j<=9; $j++)
        {
            echo '<tr><td>';
            echo outNumAsLink($n).'x'.outNumAsLink($j).'='.outNumAsLink($n*$j);
            echo '</td></tr>';
        }
    }
    echo '</table>';
}

// функция ВЫВОДИТ ТАБЛИЦУ УМНОЖЕНИЯ В БЛОЧНОЙ ФОРМЕ
function outDivForm()
{
    // если параметр content не был передан в программу
    if( !isset($_GET['content']) )
    {
        for($i=2; $i<10; $i++) // цикл со счетчиком от 2 до 9
        {
            echo '<div class="ttRow">'; // оформляем таблицу в блочной форме
            outRow( $i ); // вызовем функцию, формирующую содержание столбца
            echo '</div>';
        }
    }
    else
    {
        echo '<div class="ttSingleRow">'; // оформляем таблицу в блочной форме
        outRow( $_GET['content'] ); // выводим выбранный в меню столбец
        echo '</div>';
    }
}
?>

<!-- ГЛАВНОЕ МЕНЮ -->
<div id="main_menu"><?php
    // ссылка ТАБЛИЧНАЯ ФОРМА
    echo '<a href="?html_type=TABLE';
    if( isset($_GET['content']) )
        echo '&content='.$_GET['content'];
    echo '"';
    if( array_key_exists('html_type', $_GET) && $_GET['html_type']== 'TABLE' )
        echo ' class="selected"';
    echo '>Табличная верстка</a>';

    // ссылка БЛОЧНАЯ ФОРМА
    echo '<a href="?html_type=DIV';
    if( isset($_GET['content']) )
        echo '&content='.$_GET['content'];
    echo '"';
    if( array_key_exists('html_type', $_GET) && $_GET['html_type']== 'DIV' )
        echo ' class="selected"';
    echo '>Блочная верстка</a>';
?></div>

<div class="content-wrapper">

<!-- ОСНОВНОЕ МЕНЮ -->
<div id="product_menu"><?php
    // формируем базу ссылок с сохранением html_type
    $link_base = '?';
    if( isset($_GET['html_type']) )
        $link_base = '?html_type='.$_GET['html_type'].'&';

    echo '<a href="'.$link_base.'"';
    if( !isset($_GET['content']) )
        echo ' class="selected"';
    echo '>Вся таблица умножения</a>';

    for( $i=2; $i<=9; $i++ ) // цикл со счетчиком от 2 до 9 включительно
    {
        echo '<a href="'.$link_base.'content='.$i.'"';
        if( isset($_GET['content']) && $_GET['content']==$i )
            echo ' class="selected"';
        echo '>Таблица умножения на '.$i.'</a>';
    }
?></div>

<!-- ТАБЛИЦА УМНОЖЕНИЯ -->
<div id="multiplication_table">
<?php
    if (!isset($_GET['html_type']) || $_GET['html_type']== 'TABLE' )
        outTableForm();
    else
        outDivForm();
?>
</div>

</div>

<!-- ИНФОРМАЦИЯ О ТАБЛИЦЕ УМНОЖЕНИЯ (подвал) -->
<div id="footer"><?php
    if( !isset($_GET['html_type']) || $_GET['html_type']== 'TABLE' )
        $s='Табличная верстка. ';
    else
        $s='Блочная верстка. ';

    if( !isset($_GET['content']) )
        $s.='Таблица умножения полностью. ';
    else
        $s.='Столбец таблицы умножения на '.$_GET['content'].'. ';

    date_default_timezone_set('Europe/Moscow');
    echo $s.date('d.m.Y H:i:s');
?></div>

</body>
</html>
