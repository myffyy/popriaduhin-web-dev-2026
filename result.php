<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анализа</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
        }
        .src_text {
            color: #2e7d32;
            font-style: italic;
            margin: 20px 0;
            padding: 10px;
            background-color: #e8f5e9;
            border-radius: 5px;
        }
        .src_error {
            color: red;
            font-style: italic;
            margin: 20px 0;
        }
        table {
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1976d2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>
    <h1>Результат анализа</h1>
<?php

// функция подсчёта вхождений каждого символа (без различия регистров)
function test_symbs( $text )
{
    $symbs=array(); // массив символов текста
    $l_text=strtolower( $text ); // переводим текст в нижний регистр

    // последовательно перебираем все символы текста
    for($i=0; $i<strlen($l_text); $i++)
    {
        if( isset($symbs[$l_text[$i]]) ) // если символ есть в массиве
            $symbs[$l_text[$i]]++; // увеличиваем счетчик повторов
        else // иначе
            $symbs[$l_text[$i]]=1; // добавляем символ в массив
    }
    return $symbs; // возвращаем массив с числом вхождений символов в тексте
}

function test_it( $text )
{
    // количество символов в тексте определяется функцией размера текста
    echo '<table>';
    echo '<tr><th>Параметр</th><th>Значение</th></tr>';
    echo '<tr><td>Количество символов (включая пробелы)</td><td>'.strlen($text).'</td></tr>';

    // определяем ассоциированный массив с цифрами
    $cifra=array( '0'=>true, '1'=>true, '2'=>true, '3'=>true, '4'=>true,
                  '5'=>true, '6'=>true, '7'=>true, '8'=>true, '9'=>true );

    // определяем ассоциированный массив с буквами (строчные)
    $lower_letters=array();
    // латинские строчные
    for($c=ord('a'); $c<=ord('z'); $c++) $lower_letters[chr($c)]=true;
    // кириллические строчные (cp1251: 224-255 = а-я)
    for($c=224; $c<=255; $c++) $lower_letters[chr($c)]=true;
    $lower_letters[chr(184)]=true; // ё в cp1251

    // определяем ассоциированный массив с буквами (заглавные)
    $upper_letters=array();
    // латинские заглавные
    for($c=ord('A'); $c<=ord('Z'); $c++) $upper_letters[chr($c)]=true;
    // кириллические заглавные (cp1251: 192-223 = А-Я)
    for($c=192; $c<=223; $c++) $upper_letters[chr($c)]=true;
    $upper_letters[chr(168)]=true; // Ё в cp1251

    // знаки препинания
    $punctuation=array('.'=>true, ','=>true, '!'=>true, '?'=>true,
                       ':'=>true, ';'=>true, '-'=>true, '('=>true,
                       ')'=>true, '"'=>true, '\''=>true, '«'=>true,
                       '»'=>true, '…'=>true);

    // вводим переменные для хранения информации о:
    $cifra_amount=0;    // количество цифр в тексте
    $word_amount=0;     // количество слов в тексте
    $letter_amount=0;   // количество букв
    $lower_amount=0;    // количество строчных букв
    $upper_amount=0;    // количество заглавных букв
    $punct_amount=0;    // количество знаков препинания
    $word='';           // текущее слово
    $words=array();     // список всех слов

    for($i=0; $i<strlen($text); $i++) // перебираем все символы текста
    {
        if( array_key_exists($text[$i], $cifra) ) // если встретилась цифра
            $cifra_amount++; // увеличиваем счетчик цифр

        if( array_key_exists($text[$i], $lower_letters) ) // строчная буква
        {
            $letter_amount++;
            $lower_amount++;
        }

        if( array_key_exists($text[$i], $upper_letters) ) // заглавная буква
        {
            $letter_amount++;
            $upper_amount++;
        }

        if( array_key_exists($text[$i], $punctuation) ) // знак препинания
            $punct_amount++;

        // если в тексте встретился пробел, знак препинания или текст закончился
        if( $text[$i]==' ' || array_key_exists($text[$i], $punctuation) || $i==strlen($text)-1 )
        {
            // если последний символ — не пробел и не знак препинания, добавляем его к слову
            if( $i==strlen($text)-1 && $text[$i]!=' ' && !array_key_exists($text[$i], $punctuation) )
                $word.=$text[$i];

            if( $word ) // если есть текущее слово
            {
                // приводим слово к нижнему регистру для корректного подсчёта
                $lword = strtolower($word);
                // если текущее слово сохранено в списке слов
                if( isset($words[$lword]) )
                    $words[ $lword ]++; // увеличиваем число его повторов
                else
                    $words[ $lword ]=1; // первый повтор слова
                $word=''; // сбрасываем текущее слово
            }
        }
        else // если слово продолжается
            $word.=$text[$i]; //добавляем в текущее слово новый символ
    }

    echo '<tr><td>Количество букв</td><td>'.$letter_amount.'</td></tr>';
    echo '<tr><td>Количество строчных букв</td><td>'.$lower_amount.'</td></tr>';
    echo '<tr><td>Количество заглавных букв</td><td>'.$upper_amount.'</td></tr>';
    echo '<tr><td>Количество знаков препинания</td><td>'.$punct_amount.'</td></tr>';
    echo '<tr><td>Количество цифр</td><td>'.$cifra_amount.'</td></tr>';
    echo '<tr><td>Количество слов</td><td>'.count($words).'</td></tr>';
    echo '</table>';

    // количество вхождений каждого символа
    $symbs = test_symbs( $text );
    ksort($symbs);
    echo '<h2>Вхождения символов</h2>';
    echo '<table>';
    echo '<tr><th>Символ</th><th>Количество</th></tr>';
    foreach($symbs as $key => $value)
    {
        // непосредственно перед выводом перекодируем строку обратно в UTF-8
        echo '<tr><td>'.htmlspecialchars(iconv("cp1251", "utf-8", $key)).'</td><td>'.$value.'</td></tr>';
    }
    echo '</table>';

    // список слов, отсортированный по алфавиту
    ksort($words);
    echo '<h2>Список слов</h2>';
    echo '<table>';
    echo '<tr><th>Слово</th><th>Количество</th></tr>';
    foreach($words as $key => $value)
    {
        echo '<tr><td>'.htmlspecialchars(iconv("cp1251", "utf-8", $key)).'</td><td>'.$value.'</td></tr>';
    }
    echo '</table>';
}

if( isset($_POST['data']) && $_POST['data'] ) // если передан текст для анализа
{
    echo '<div class="src_text">'.htmlspecialchars($_POST['data']).'</div>'; // выводим текст
    // перед анализом перекодируем текст из UTF-8 в CP1251
    test_it( iconv("utf-8", "cp1251", $_POST['data']) ); // анализируем текст
}
else // если текста нет или он пустой
    echo '<div class="src_error">Нет текста для анализа</div>'; // выводим ошибку
?>
    <br>
    <a href="index.html">Другой анализ</a>
</body>
</html>
