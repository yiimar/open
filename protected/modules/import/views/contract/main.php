<?php
/* @var $this yii\web\View */
?>
<h1>contract/test</h1>

<p>
    <?php
    foreach ($result as $row) {
        echo '||';
        foreach ($row as $column) {
            echo ' ' . $column . ' |';
        }
        echo "|<br>";
    };
    //    print_r($result);
    ?>
</p>
<p>
    <?php
    $i=0;
    foreach ($table as $row) {
        echo "|$i|";
        foreach ($row as $column) {
            echo ' ' . print_r($column) . ' |';
        }
        echo "|<br>";
        $i++;
    }
    ?>
</p>