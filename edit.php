<?php
$mysqli = mysqli_connect('localhost', 'root', '', 'friends');

if( mysqli_connect_errno() ) // если при подключении к серверу произошла ошибка
{
    // выводим сообщение и принудительно останавливаем PHP-программу
    echo 'Ошибка подключения к БД: '.mysqli_connect_error();
    exit();
}

// если были переданы данные для изменения записи в таблице
if( isset($_POST['button']) && $_POST['button']=== 'Изменить запись')
{
    // формируем и выполняем SQL-запрос на изменение записи с указанным id
    $sql_res=mysqli_query($mysqli, 'UPDATE friends SET surname="'.
        htmlspecialchars($_POST['surname']).'", name="'.
        htmlspecialchars($_POST['name']).'", patronymic="'.
        htmlspecialchars($_POST['patronymic']).'", gender="'.
        htmlspecialchars($_POST['gender']).'", birthday="'.
        htmlspecialchars($_POST['birthday']).'", telephone="'.
        htmlspecialchars($_POST['telephone']).'", address="'.
        htmlspecialchars($_POST['address']).'", email="'.
        htmlspecialchars($_POST['email']).'", comment="'.
        htmlspecialchars($_POST['comment']).'"'.
        ' WHERE id='.(int)$_POST['id']);

    echo 'Данные изменены';     // и выводим сообщение об изменении данных
    $_GET['id']=$_POST['id']; // эмулируем переход по ссылке на изменяемую запись
}

$currentROW=array();           // информация о текущей записи пока нет
if( isset($_GET['id']) )       // если id текущей записи передано
{
    // выполняем поиск записи по ее id
    $sql_res=mysqli_query($mysqli,
        'SELECT * FROM friends WHERE id='.(int)$_GET['id'].' LIMIT 0, 1');
    $currentROW=mysqli_fetch_assoc($sql_res); // информация сохраняется
}

if( !$currentROW )    // если информации о текущей записи нет или она некорректна
{
    // берем первую запись из таблицы и делаем ее текущей
    $sql_res=mysqli_query($mysqli, 'SELECT * FROM friends ORDER BY surname, name LIMIT 0, 1');
    $currentROW=mysqli_fetch_assoc($sql_res);
}

// формируем и выполняем запрос для получения требуемых полей всех записей таблицы
$sql_res=mysqli_query($mysqli, 'SELECT id, surname, name FROM friends ORDER BY surname, name');

if( !mysqli_errno($mysqli) )      // если запрос успешно выполнен
{
    echo '<div id="edit_links">';
    while( $row=mysqli_fetch_assoc($sql_res) ) // перебираем все записи выборки
    {
        // если текущая запись еще не найдена и ее id не передан
        // или передан и совпадает с проверяемой записью
        if( $currentROW && $currentROW['id']==$row['id'] )
        {
            // значит в цикле сейчас текущая запись
            echo '<div>'.$row['surname'].' '.$row['name'].'</div>';   // и выводим ее в списке
        }
        else      // если проверяемая в цикле запись не текущая
            // формируем ссылку на нее
            echo '<a href="?p=edit&id='.$row['id'].'">'.$row['surname'].' '.$row['name'].'</a>';
    }
    echo '</div>';

    if( $currentROW ) // если есть текущая запись, т.е. если в таблице есть записи
    {
        // формируем HTML-код формы
        echo '<form name="form_edit" method="post" action="?p=edit&id='.$currentROW['id'].'">';
        echo '<label for="surname">Фамилия</label>';
        echo '<input type="text" name="surname" id="surname" placeholder="Фамилия" value="'.$currentROW['surname'].'">';
        echo '<label for="name">Имя</label>';
        echo '<input type="text" name="name" id="name" placeholder="Имя" value="'.$currentROW['name'].'">';
        echo '<label for="patronymic">Отчество</label>';
        echo '<input type="text" name="patronymic" id="patronymic" placeholder="Отчество" value="'.$currentROW['patronymic'].'">';
        echo '<label for="gender">Пол</label>';
        echo '<select name="gender" id="gender">';
        echo '<option value="">-- Пол --</option>';
        echo '<option value="М"'.($currentROW['gender']=='М' ? ' selected' : '').'>М</option>';
        echo '<option value="Ж"'.($currentROW['gender']=='Ж' ? ' selected' : '').'>Ж</option>';
        echo '</select>';
        echo '<label for="birthday">Дата рождения</label>';
        echo '<input type="date" name="birthday" id="birthday" value="'.$currentROW['birthday'].'">';
        echo '<label for="telephone">Телефон</label>';
        echo '<input type="text" name="telephone" id="telephone" placeholder="Телефон" value="'.$currentROW['telephone'].'">';
        echo '<label for="address">Адрес</label>';
        echo '<input type="text" name="address" id="address" placeholder="Адрес" value="'.$currentROW['address'].'">';
        echo '<label for="email">E-mail</label>';
        echo '<input type="email" name="email" id="email" placeholder="E-mail" value="'.$currentROW['email'].'">';
        echo '<label for="comment">Комментарий</label>';
        echo '<textarea name="comment" placeholder="Комментарий">'.$currentROW['comment'].'</textarea>';
        echo '<input type="hidden" name="id" value="'.$currentROW['id'].'">';
        echo '<input type="submit" name="button" value="Изменить запись">';
        echo '</form>';
    }
    else echo 'Записей пока нет';
}
else                              // если запрос не может быть выполнен
    echo 'Ошибка базы данных';     // выводим сообщение об ошибке
?>
