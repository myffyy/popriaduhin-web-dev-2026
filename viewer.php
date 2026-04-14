<?php
function getFriendsList($type, $page)
{
    // осуществляем подключение к базе данных
    $mysqli = mysqli_connect('localhost', 'root', '', 'friends');

    if( mysqli_connect_errno() ) // проверяем корректность подключения
        return 'Ошибка подключения к БД: '.mysqli_connect_error();

    // формируем и выполняем SQL-запрос для определения числа записей
    $sql_res=mysqli_query($mysqli, 'SELECT COUNT(*) FROM friends');

    // проверяем корректность выполнения запроса и определяем его результат
    if( !mysqli_errno($mysqli) && $row=mysqli_fetch_row($sql_res) )
    {
        if( !$TOTAL=$row[0] )        // если в таблице нет записей
            return 'В таблице нет данных'; // возвращаем сообщение

        $PAGES = ceil($TOTAL/10); // вычисляем общее количество страниц

        if( $page>=$PAGES )    // если указана страница больше максимальной
            $page=$PAGES-1;     // будем выводить последнюю страницу

        // определяем сортировку
        if( $type == 'fam' )
            $order = 'ORDER BY surname, name';
        elseif( $type == 'birth' )
            $order = 'ORDER BY birthday';
        else
            $order = 'ORDER BY id';

        // формируем и выполняем SQL-запрос для выборки записей из БД
        $sql='SELECT * FROM friends '.$order.' LIMIT '.($page*10).', 10';
        $sql_res=mysqli_query($mysqli, $sql);

        $ret='<table>';         // строка с будущим контентом страницы
        $ret.='<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>E-mail</th><th>Комментарий</th></tr>';
        while( $row=mysqli_fetch_assoc($sql_res) )  // пока есть записи
        {
            // выводим каждую запись как строку таблицы
            $ret.='<tr><td>'.$row['surname'].'</td>
                       <td>'.$row['name'].'</td>
                       <td>'.$row['patronymic'].'</td>
                       <td>'.$row['gender'].'</td>
                       <td>'.$row['birthday'].'</td>
                       <td>'.$row['telephone'].'</td>
                       <td>'.$row['address'].'</td>
                       <td>'.$row['email'].'</td>
                       <td>'.$row['comment'].'</td></tr>';
        }
        $ret.='</table>'; // заканчиваем формирование таблицы с контентом

        if( $PAGES>1 )  // если страниц больше одной - добавляем пагинацию
        {
            $ret.='<div id="pages">';              // блок пагинации
            for($i=0; $i<$PAGES; $i++)            // цикл для всех страниц пагинации
            {   if( $i != $page )          // если не текущая страница
                    $ret.='<a href="?p=viewer&sort='.$type.'&pg='.$i.'">'.($i+1).'</a>';
                else                        // если текущая страница
                    $ret.='<span>'.($i+1).'</span>';
            }
            $ret.='</div>';
        }
        return $ret;           // возвращаем сформированный контент
    }
                            // если запрос выполнен некорректно
    return 'Неизвестная ошибка';   // возвращаем сообщение
}
?>
