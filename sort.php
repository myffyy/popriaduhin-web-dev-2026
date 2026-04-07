<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат сортировки</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php

// Функция проверки: аргумент НЕ число
function arg_is_not_Num( $arg )
{
    if( $arg==='' ) return true;    // передана пустая строка

    $start = 0;
    if( $arg[0] == '-' ) $start = 1; // допускаем отрицательные числа
    if( $start >= strlen($arg) ) return true; // только минус без цифр

    for($i=$start; $i<strlen($arg); $i++)    // цикл по всем символам аргумента
        if( $arg[$i]!='0' && $arg[$i]!='1' && $arg[$i]!='2' &&
            $arg[$i]!='3' && $arg[$i]!='4' && $arg[$i]!='5' &&
            $arg[$i]!='6' && $arg[$i]!='7' && $arg[$i]!='8' &&
            $arg[$i]!='9' ) // если встретилась не цифра
            return true; // возвращаем true

    return false;   // строка состоит из чисел
}

// Функция вывода массива
function printArray($arr)
{
    foreach($arr as $key => $val)
    {
        echo '<div class="arr_element">'.$key.': '.$val.'</div>';
    }
    echo '<div style="clear:both;"></div>';
}

// ======= АЛГОРИТМЫ СОРТИРОВКИ =======

// Сортировка выбором
function sorting_by_choice( $arr )
{
    $n = 0;
    for($i=0; $i<count($arr)-1; $i++)
    {
        $min=$i;
        for($j=$i+1; $j<count($arr); $j++)
            if( $arr[$j]<$arr[$i] ) $min=$j;

        if( $min > $i+1 )
        {
            $element = $arr[$i];
            $arr[$i]=$arr[$min];
            $arr[$min] = $element;
        }
        $n++;
        echo '<div class="iteration">Итерация '.$n.': ';
        printArray($arr);
        echo '</div>';
    }
    return $n;
}

// Пузырьковая сортировка
function BubbleSort($arr)
{
    $n = 0;
    for($j=0; $j<count($arr)-1; $j++)
    {
        for($i=0; $i<count($arr)-1-$j; $i++)
        {
            if( $arr[$i]>$arr[$i+1] )
            {
                $temp = $arr[$i];
                $arr[$i] = $arr[$i+1];
                $arr[$i+1] = $temp;
            }
            $n++;
            echo '<div class="iteration">Итерация '.$n.': ';
            printArray($arr);
            echo '</div>';
        }
    }
    return $n;
}

// Алгоритм Шелла
function ShellsSort($arr)
{
    $n = 0;
    for( $k=ceil(count($arr)/2); $k>=1; $k= ceil($k/2) )
    {
        for($i=$k; $i<count($arr); $i++)
        {
            $val = $arr[$i];
            $j = $i-$k;
            while( $j>=0 && $arr[$j]>$val )
            {
                $arr[$j+$k] = $arr[$j];
                $j-=$k;
            }
            $arr[$j+$k] = $val;
            $n++;
            echo '<div class="iteration">Итерация '.$n.': ';
            printArray($arr);
            echo '</div>';
        }
        if($k == 1) break;
    }
    return $n;
}

// Алгоритм садового гнома
function gnomeSort($arr)
{
    $n = 0;
    $i=1;
    $j=2;
    while( $i<count($arr) )
    {
        if( !$i || $arr[$i-1]<=$arr[$i] )
        {
            $i=$j;
            $j++;
        }
        else
        {
            $temp = $arr[$i];
            $arr[$i] = $arr[$i-1];
            $arr[$i-1] = $temp;
            $i--;
        }
        $n++;
        echo '<div class="iteration">Итерация '.$n.': ';
        printArray($arr);
        echo '</div>';
    }
    return $n;
}

// Быстрая сортировка
$quickSortIterations = 0;

function quickSort(&$arr, $left, $right)
{
    global $quickSortIterations;
    $l=$left;
    $r=$right;

    $point = $arr[ floor(($left+$right)/2) ];

    do
    {
        while( $arr[$l]<$point ) $l++;
        while( $arr[$r]>$point ) $r--;

        if( $l <= $r )
        {
            $temp=$arr[$l]; $arr[$l]=$arr[$r]; $arr[$r]=$temp;
            $l++;
            $r--;
        }
    } while( $l<=$r );

    $quickSortIterations++;
    echo '<div class="iteration">Итерация '.$quickSortIterations.': ';
    printArray($arr);
    echo '</div>';

    if( $r > $left )
        quickSort($arr, $left, $r);
    if( $l < $right )
        quickSort($arr, $l, $right);
}

function quickSortWrapper($arr)
{
    global $quickSortIterations;
    $quickSortIterations = 0;
    quickSort($arr, 0, count($arr)-1);
    return $quickSortIterations;
}

// ======= ОСНОВНАЯ ПРОГРАММА =======

if( !isset($_POST['element0']) )    // если данных нет
{
    echo '<h1>Массив не задан, сортировка невозможна</h1>';
    exit();
}

// Валидация: проверяем что все элементы — числа
for($i=0; $i<$_POST['arrLength']; $i++)
{
    if( arg_is_not_Num( $_POST['element'.$i] ) )
    {
        echo 'Элемент массива "'. $_POST['element'.$i].'" – не число';
        exit();
    }
}

// Определяем алгоритм
$algoritmNames = array(
    '0' => 'Сортировка выбором',
    '1' => 'Пузырьковый алгоритм',
    '2' => 'Алгоритм Шелла',
    '3' => 'Алгоритм садового гнома',
    '4' => 'Быстрая сортировка',
    '5' => 'Встроенная функция PHP (sort)'
);

$alg = $_POST['algoritm'];
echo '<h1>'.$algoritmNames[$alg].'</h1>';

// Формируем массив
$arr = array();
echo '<div class="result-section">Исходный массив<br>----------------------------<br>';
for($i=0; $i<$_POST['arrLength']; $i++)
{
    echo '<div class="arr_element">'.$i.': '.$_POST['element'.$i].'</div>';
    $arr[] = intval($_POST['element'.$i]);
}
echo '<div style="clear:both;"></div></div>';

echo '<br>----------------------------<br>Массив проверен, сортировка возможна';
echo '<br>----------------------------<br>';

// Засекаем время и сортируем
$time = microtime(true);

if( $alg==='0' )
    $n = sorting_by_choice( $arr );
elseif( $alg==='1' )
    $n = BubbleSort( $arr );
elseif( $alg==='2' )
    $n = ShellsSort( $arr );
elseif( $alg==='3' )
    $n = gnomeSort( $arr );
elseif( $alg==='4' )
    $n = quickSortWrapper( $arr );
elseif( $alg==='5' )
{
    sort($arr);
    $n = '—';
    echo '<div class="iteration">Результат: ';
    printArray($arr);
    echo '</div>';
}

$elapsed = microtime(true) - $time;

echo '<br>----------------------------<br>';
echo 'Сортировка завершена, проведено '.$n.' итераций. Сортировка заняла '.$elapsed.' секунд.';

?>
</body>
</html>
