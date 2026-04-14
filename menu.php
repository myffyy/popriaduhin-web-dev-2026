<div id="menu">
<?php
    // если нет параметра меню - добавляем его
    if( !isset($_GET['p']) ) $_GET['p']='viewer';

    // проверка допустимости значения параметра
    $allowed = array('viewer', 'add', 'edit', 'delete');
    if( !in_array($_GET['p'], $allowed) ) $_GET['p']='viewer';

    echo '<a href="?p=viewer"'; // первый пункт меню
    if( $_GET['p'] == 'viewer' ) // если он выбран
        echo ' class="selected"'; // выделяем его
    echo '>Просмотр</a>';

    echo '<a href="?p=add"'; // второй пункт меню
    if( $_GET['p'] == 'add' ) echo ' class="selected"';
    echo '>Добавление записи</a>';

    echo '<a href="?p=edit"'; // третий пункт меню
    if( $_GET['p'] == 'edit' ) echo ' class="selected"';
    echo '>Редактирование записи</a>';

    echo '<a href="?p=delete"'; // четвертый пункт меню
    if( $_GET['p'] == 'delete' ) echo ' class="selected"';
    echo '>Удаление записи</a>';

    if( $_GET['p'] == 'viewer' )     //если был выбран первый пункт меню
    {
        echo '<div id="submenu">';   // выводим подменю

        echo '<a href="?p=viewer&sort=byid"'; // первый пункт подменю
        if( !isset($_GET['sort']) || $_GET['sort'] == 'byid' )
            echo ' class="selected"';
        echo '>По-умолчанию</a>';

        echo '<a href="?p=viewer&sort=fam"';    // второй пункт подменю
        if( isset($_GET['sort']) && $_GET['sort'] == 'fam' )
            echo ' class="selected"';
        echo '>По фамилии</a>';

        echo '<a href="?p=viewer&sort=birth"';    // третий пункт подменю
        if( isset($_GET['sort']) && $_GET['sort'] == 'birth' )
            echo ' class="selected"';
        echo '>По дате рождения</a>';

        echo '</div>';              // конец подменю
    }
?>
</div>
