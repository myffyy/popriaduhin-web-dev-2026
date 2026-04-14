<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Записная книжка</h1>
<?php
require 'menu.php';   // главное меню
// модули с контентом страницы
if( $_GET['p'] == 'viewer' )
{
    include 'viewer.php'; // подключаем модуль с библиотекой функций

    // если в параметрах не указана текущая страница - выводим самую первую
    if( !isset($_GET['pg']) || $_GET['pg']<0 ) $_GET['pg']=0;

    // если в параметрах не указан тип сортировки или он недопустим
    if(!isset($_GET['sort']) || ($_GET['sort']!='byid' && $_GET['sort']!='fam' &&
        $_GET['sort']!='birth'))
        $_GET['sort']='byid'; // устанавливаем сортировку по умолчанию

    // формируем контент страницы с помощью функции и выводим его
    echo getFriendsList($_GET['sort'], $_GET['pg']);
}
else // подключаем другие модули с контентом страницы
if( file_exists($_GET['p'].'.php') ) { include $_GET['p'].'.php'; }
?>
</body>
</html>
