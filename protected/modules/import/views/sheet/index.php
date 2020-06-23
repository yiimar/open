<?php
/* @var $this yii\web\View */
?>
<h1>sheet/index</h1>

<?php
echo 'Sheet info' . "<br>";
foreach ($info as $sheet) {
    echo "<br>";
    echo 'Лист "' . $sheet['worksheetName'] . '":' ."<br>";
    echo 'Завершающий столбец: '. $sheet['lastColumnIndex'] . ' ' . $sheet['lastColumnLetter'] . ';' ."<br>";
    echo 'Всего столбцов: '     . $sheet['totalColumns'] . ';' ."<br>";
    echo 'Всего строк: '        . $sheet['totalRows'] . ';' ."<br>";
}
?>
<hr>
<?php
print_r($info);
echo 'Sheet list' . "<br>";
print_r($list);
?>
