<?php
$title = 'Страница 3';
$current_page = 'page3.php';
require 'header.php';
?>

<div class="content">
    <h2>Содержимое третьей страницы</h2>
    <p>Это текст для третьей и последней страницы сайта.</p>

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
            echo '<tr><th>Категория 1</th><th>Категория 2</th><th>Категория 3</th></tr>';
            ?>
        </thead>
        <tbody>
            <tr>
                <td><?php echo "Элемент X"; ?></td>
                <td><?php echo "Элемент Y"; ?></td>
                <td><?php echo "Элемент Z"; ?></td>
            </tr>
            <tr>
                <td>Статичный элемент</td>
                <td><?php echo PHP_OS; ?></td>
                <td><?php echo rand(401, 500); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
require 'footer.php';
?>
