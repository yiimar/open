<?php
/* @var $this yii\web\View */
?>
<h1>sheet/row</h1>
<?php
print_r($table);
echo "<hr><br>";
foreach ($table as $kc => $col) :
    echo ' ' . $col . ' |';
endforeach;
echo '|';
echo "<br><hr>";
?>