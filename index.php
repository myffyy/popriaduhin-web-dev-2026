<?php
$title = 'Главная страница';
$current_page = 'index.php';
require 'header.php';
?>

<div class="content">
    <h2>Содержимое главной страницы</h2>
    <p>Это текст для основной страницы сайта. Здесь может быть любое описание.</p>

    <h3>Динамически загружаемое изображение</h3>
    <p>В зависимости от текущей секунды (четная или нечетная) загружается одно из двух изображений.</p>
    <?php
    echo '<img src="photos/photo' . (date('s') % 2 + 1) . '.jpg" alt="Динамическое изображение" class="dynamic-image">';
    ?>

    <h3>Таблица с динамическими данными</h3>
    <p>Первая строка таблицы полностью формируется PHP, а во второй строке — только содержимое ячеек.</p>
    <table>
        <thead>
            <?php
            echo '<tr><th>Заголовок 1</th><th>Заголовок 2</th><th>Заголовок 3</th></tr>';
            ?>
        </thead>
        <tbody>
            <tr>
                <td><?php echo "Данные 1"; ?></td>
                <td><?php echo "Данные 2"; ?></td>
                <td><?php echo "Данные 3"; ?></td>
            </tr>
            <tr>
                <td>Статичные данные 1</td>
                <td><?php echo date('H:i:s'); ?></td>
                <td><?php echo rand(100, 200); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
require 'footer.php';
?>
