<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сортировка массивов</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function setHTML(element, txt)
        {
            if(element.innerHTML)
                element.innerHTML = txt;
            else
            {
                var range = document.createRange();
                range.selectNodeContents(element);
                range.deleteContents();
                var fragment = range.createContextualFragment(txt);
                element.appendChild(fragment);
            }
        }

        function addElement(table_name, amount)
        {
            var t = document.getElementById(table_name);

            for(var i=0; i<amount; i++)
            {
                var index = t.rows.length;
                var row = t.insertRow(index);

                var celNum = row.insertCell(0);
                celNum.className = 'element_num';
                setHTML(celNum, index + ':');

                var cel = row.insertCell(1);
                cel.className = 'element_row';
                var celcontent = '<input type="text" name="element' + index + '">';
                setHTML(cel, celcontent);
            }
            document.getElementById('arrLength').value = t.rows.length;
        }

        function removeElement(table_name)
        {
            var t = document.getElementById(table_name);
            if(t.rows.length <= 1) return; // минимум 1 элемент
            t.deleteRow(t.rows.length - 1);
            document.getElementById('arrLength').value = t.rows.length;
        }
    </script>
</head>
<body>
    <h1>Сортировка массивов</h1>
    <form action="sort.php" method="POST" target="_blank">
        <table id="elements">
            <tr>
                <td class="element_num">0:</td>
                <td class="element_row"><input type="text" name="element0"></td>
            </tr>
        </table>

        <input type="hidden" id="arrLength" name="arrLength" value="1">

        <div class="controls">
            <label for="algoritm">Алгоритм сортировки:</label>
            <select name="algoritm" id="algoritm">
                <option value="0">Сортировка выбором</option>
                <option value="1">Пузырьковый алгоритм</option>
                <option value="2">Алгоритм Шелла</option>
                <option value="3">Алгоритм садового гнома</option>
                <option value="4">Быстрая сортировка</option>
                <option value="5">Встроенная функция PHP (sort)</option>
            </select>
        </div>

        <div class="buttons">
            <input type="button" value="Добавить еще один элемент"
                onClick="addElement('elements', 1);">
            <input type="button" value="Удалить последний элемент"
                onClick="removeElement('elements');">
            <input type="submit" value="Сортировать массив">
        </div>
    </form>
</body>
</html>
