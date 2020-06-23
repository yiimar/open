<?php
/* @var $this yii\web\View */
?>
<h1>sheet/column</h1>

<?php
foreach ($chunk as $row) {
    echo "<hr><br>|";
    foreach ($row as $key => $value) {
        echo ' ' . $key . ' = ' . $value . ' |';
    }
}