<form name="form_add" method="post" action="?p=add">
    <label for="surname">Фамилия</label>
    <input type="text" name="surname" id="surname" placeholder="Фамилия">
    <label for="name">Имя</label>
    <input type="text" name="name" id="name" placeholder="Имя">
    <label for="patronymic">Отчество</label>
    <input type="text" name="patronymic" id="patronymic" placeholder="Отчество">
    <label for="gender">Пол</label>
    <select name="gender" id="gender">
        <option value="">-- Пол --</option>
        <option value="М">М</option>
        <option value="Ж">Ж</option>
    </select>
    <label for="birthday">Дата рождения</label>
    <input type="date" name="birthday" id="birthday" placeholder="Дата рождения">
    <label for="telephone">Телефон</label>
    <input type="text" name="telephone" id="telephone" placeholder="Телефон">
    <label for="address">Адрес</label>
    <input type="text" name="address" id="address" placeholder="Адрес">
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" placeholder="E-mail">
    <label for="comment">Комментарий</label>
    <textarea name="comment" placeholder="Краткий комментарий"></textarea>
    <input type="submit" name="button" value="Добавить запись">
</form><?php
    // если были переданы данные для добавления в БД
    if( isset($_POST['button']) && $_POST['button']=== 'Добавить запись')
    {
        $mysqli = mysqli_connect('localhost', 'root', '', 'friends');

        if( mysqli_connect_errno() ) // проверяем корректность подключения
            echo 'Ошибка подключения к БД: '.mysqli_connect_error();
        else
        {
            // формируем и выполняем SQL-запрос для добавления записи
            $sql_res=mysqli_query($mysqli, 'INSERT INTO friends (surname, name, patronymic, gender, birthday, telephone, address, email, comment) VALUES ("'.
                htmlspecialchars($_POST['surname']).'", "'.
                htmlspecialchars($_POST['name']).'", "'.
                htmlspecialchars($_POST['patronymic']).'", "'.
                htmlspecialchars($_POST['gender']).'", "'.
                htmlspecialchars($_POST['birthday']).'", "'.
                htmlspecialchars($_POST['telephone']).'", "'.
                htmlspecialchars($_POST['address']).'", "'.
                htmlspecialchars($_POST['email']).'", "'.
                htmlspecialchars($_POST['comment']).'")');
            // если при выполнении запроса произошла ошибка - выводим сообщение
            if( mysqli_errno($mysqli) )
                echo '<div class="error">Запись не добавлена</div>';
            else // если все прошло нормально - выводим сообщение
                echo '<div class="ok">Запись добавлена</div>';
        }
    }
?>
