<?php
$mysqli = mysqli_connect('localhost', 'root', '', 'friends');

if( mysqli_connect_errno() )
{
    echo 'Ошибка подключения к БД: '.mysqli_connect_error();
    exit();
}

// если были переданы данные для удаления записи
if( isset($_GET['del']) )
{
    // получаем фамилию удаляемой записи для сообщения
    $sql_res = mysqli_query($mysqli, 'SELECT surname FROM friends WHERE id='.(int)$_GET['del'].' LIMIT 0, 1');
    $delRow = mysqli_fetch_assoc($sql_res);
    $delSurname = $delRow ? $delRow['surname'] : '';

    // формируем и выполняем SQL-запрос на удаление записи
    $sql_res = mysqli_query($mysqli, 'DELETE FROM friends WHERE id='.(int)$_GET['del']);

    if( !mysqli_errno($mysqli) && mysqli_affected_rows($mysqli) > 0 )
        echo '<div class="ok">Запись с фамилией '.$delSurname.' удалена</div>';
    else
        echo '<div class="error">Ошибка удаления записи</div>';
}

// формируем и выполняем запрос для получения всех записей
$sql_res = mysqli_query($mysqli, 'SELECT id, surname, name, patronymic FROM friends ORDER BY surname, name');

if( !mysqli_errno($mysqli) )
{
    echo '<div id="edit_links">';
    while( $row = mysqli_fetch_assoc($sql_res) )
    {
        // выводим фамилию и инициалы
        $initials = mb_substr($row['name'], 0, 1, 'UTF-8').'. '.mb_substr($row['patronymic'], 0, 1, 'UTF-8').'.';
        echo '<a href="?p=delete&del='.$row['id'].'">'.$row['surname'].' '.$initials.'</a> ';
    }
    echo '</div>';
}
else
    echo 'Ошибка базы данных';
?>
