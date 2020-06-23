<?php
/* @var $this yii\web\View */
?>
<h1>sheet/sheet</h1>

<?php
print_r($table);
echo "<hr><br>";
foreach ($table as $kr => $row) :
    echo "<hr>|| Строка $kr ||";
    foreach ($row as $kc => $col) :
        echo ' ' . $col . ' |';
    endforeach;
    echo '|';
endforeach;
echo "<br><hr>";
?>