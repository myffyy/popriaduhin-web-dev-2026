<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?php echo $title; ?></h1>
        <nav>
            <ul>
                <li>
                    <a href="<?php
                        $name = 'Главная';
                        $link = 'index.php';
                        echo $link;
                    ?>"<?php
                        if ($current_page === 'index.php') {
                            echo ' class="selected_menu"';
                        }
                    ?>>
                        <?php echo $name; ?>
                    </a>
                </li>
                <li>
                     <a href="<?php
                        $name = 'Страница 2';
                        $link = 'page2.php';
                        echo $link;
                    ?>"<?php
                        if ($current_page === 'page2.php') {
                            echo ' class="selected_menu"';
                        }
                    ?>>
                        <?php echo $name; ?>
                    </a>
                </li>
                <li>
                     <a href="<?php
                        $name = 'Страница 3';
                        $link = 'page3.php';
                        echo $link;
                    ?>"<?php
                        if ($current_page === 'page3.php') {
                            echo ' class="selected_menu"';
                        }
                    ?>>
                        <?php echo $name; ?>
                    </a>
                </li>
            </ul>
        </nav>    </header>
    <main>
