<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
    $_SESSION['iteration'] = 0;
}

$_SESSION['iteration']++;

function isnum($x)
{
    $x = (string)$x;

    if ($x === '') {
        return false;
    }

    if ($x[0] === '+' || $x[0] === '-') {
        if (strlen($x) === 1) {
            return false;
        }
        $x = substr($x, 1);
    }

    if ($x === '0') {
        return true;
    }

    if ($x[0] === '.') {
        return false;
    }

    if ($x[0] === '0' && strlen($x) > 1 && $x[1] !== '.') {
        return false;
    }

    if ($x[strlen($x) - 1] === '.') {
        return false;
    }

    for ($i = 0, $point_count = false; $i < strlen($x); $i++) {
        if (
            $x[$i] !== '0' && $x[$i] !== '1' && $x[$i] !== '2' &&
            $x[$i] !== '3' && $x[$i] !== '4' && $x[$i] !== '5' &&
            $x[$i] !== '6' && $x[$i] !== '7' && $x[$i] !== '8' &&
            $x[$i] !== '9' && $x[$i] !== '.'
        ) {
            return false;
        }

        if ($x[$i] === '.') {
            if ($point_count) {
                return false;
            }
            $point_count = true;
        }
    }

    return true;
}

function calculate($val)
{
    $val = (string)$val;

    if ($val === '') {
        return 'Выражение не задано!';
    }

    if (isnum($val)) {
        return $val;
    }

    for ($i = strlen($val) - 1; $i > 0; $i--) {
        if ($val[$i] === '+' || $val[$i] === '-') {
            $prev = $val[$i - 1];
            if ($prev === '+' || $prev === '-' || $prev === '*' || $prev === '/' || $prev === ':') {
                continue;
            }

            $left = calculate(substr($val, 0, $i));
            if (!isnum($left)) {
                return $left;
            }

            $right = calculate(substr($val, $i + 1));
            if (!isnum($right)) {
                return $right;
            }

            if ($val[$i] === '+') {
                return (string)($left + $right);
            }

            return (string)($left - $right);
        }
    }

    for ($i = strlen($val) - 1; $i > 0; $i--) {
        if ($val[$i] === '*' || $val[$i] === '/' || $val[$i] === ':') {
            $prev = $val[$i - 1];
            if ($prev === '+' || $prev === '-' || $prev === '*' || $prev === '/' || $prev === ':') {
                continue;
            }

            $left = calculate(substr($val, 0, $i));
            if (!isnum($left)) {
                return $left;
            }

            $right = calculate(substr($val, $i + 1));
            if (!isnum($right)) {
                return $right;
            }

            if ($val[$i] === '*') {
                return (string)($left * $right);
            }

            if ((float)$right == 0.0) {
                return 'Деление на ноль!';
            }

            return (string)($left / $right);
        }
    }

    return 'Недопустимые символы в выражении';
}

function SqValidator($val)
{
    $open = 0;

    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] === '(') {
            $open++;
        } elseif ($val[$i] === ')') {
            $open--;
            if ($open < 0) {
                return false;
            }
        }
    }

    return $open === 0;
}

function calculateSq($val)
{
    $val = (string)$val;

    if ($val === '') {
        return 'Выражение не задано!';
    }

    if (!SqValidator($val)) {
        return 'Неправильная расстановка скобок!';
    }

    $start = strpos($val, '(');

    if ($start === false) {
        return calculate($val);
    }

    if ($start > 0) {
        $prev = $val[$start - 1];
        if (($prev >= '0' && $prev <= '9') || $prev === ')' || $prev === '.') {
            return 'Недопустимые символы в выражении';
        }
    }

    $end = $start + 1;
    $open = 1;

    while ($open && $end < strlen($val)) {
        if ($val[$end] === '(') {
            $open++;
        } elseif ($val[$end] === ')') {
            $open--;
        }
        $end++;
    }

    if ($open !== 0) {
        return 'Неправильная расстановка скобок!';
    }

    if ($end < strlen($val)) {
        $next = $val[$end];
        if (($next >= '0' && $next <= '9') || $next === '(' || $next === '.') {
            return 'Недопустимые символы в выражении';
        }
    }

    $inner = substr($val, $start + 1, $end - $start - 2);
    $inner_result = calculateSq($inner);

    if (!isnum($inner_result)) {
        return $inner_result;
    }

    $new_val = substr($val, 0, $start) . $inner_result . substr($val, $end);

    return calculateSq($new_val);
}

$result = null;
$show_result = false;
$store_history = false;
$expression = '';

if (isset($_POST['val'])) {
    $expression = $_POST['val'];
    $result = calculateSq($expression);
    $show_result = true;
    $store_history = isset($_POST['iteration']) && ($_POST['iteration'] + 1 == $_SESSION['iteration']);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Калькулятор</h1>
        <p class="lead">Выражение может содержать числа, операции <code>+</code>, <code>-</code>, <code>*</code>, <code>/</code>, <code>:</code>, а также скобки.</p>

        <?php if ($show_result): ?>
            <div class="message">
                <?php
                if (isnum($result)) {
                    echo 'Значение выражения: ' . htmlspecialchars((string)$result, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                } else {
                    echo 'Ошибка вычисления выражения: ' . htmlspecialchars((string)$result, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                }
                ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="val">Выражение</label>
            <input type="text" id="val" name="val" value="<?php echo htmlspecialchars($expression, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" autocomplete="off">
            <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
            <button type="submit">Вычислить</button>
        </form>

        <footer>
            <div class="history-title">История вычислений</div>
            <?php
            if (count($_SESSION['history']) === 0) {
                echo '<div class="history-item">Пока пусто.</div>';
            } else {
                for ($i = 0; $i < count($_SESSION['history']); $i++) {
                    echo '<div class="history-item">' . htmlspecialchars($_SESSION['history'][$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</div>';
                }
            }

            if ($store_history) {
                $_SESSION['history'][] = $expression . ' = ' . $result;
            }
            ?>
        </footer>
    </div>
</div>
</body>
</html>
