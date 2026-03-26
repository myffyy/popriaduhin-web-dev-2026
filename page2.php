<?php
$title = 'Страница 2';
$current_page = 'page2.php';
require 'header.php';
?>

<div class="content">
    <h2>Содержимое второй страницы</h2>
    <p>Это текст для второй страницы сайта. Здесь также может быть любое описание.</p>

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
            echo '<tr><th>Атрибут 1</th><th>Атрибут 2</th><th>Атрибут 3</th></tr>';
            ?>
        </thead>
        <tbody>
            <tr>
                <td><?php echo "Значение A"; ?></td>
                <td><?php echo "Значение B"; ?></td>
                <td><?php echo "Значение C"; ?></td>
            </tr>
            <tr>
                <td>Статичное значение</td>
                <td><?php echo date('d/m/Y'); ?></td>
                <td><?php echo rand(301, 400); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
require 'footer.php';
?>
