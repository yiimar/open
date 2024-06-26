<?php

use app\controllers\BaseController;
use app\models\Client;

/* @var $this BaseController */
/* @var $model Client */

$this->breadcrumbs= [
	'Остатки на счетах',
];


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#client-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Clients</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#', ['class'=>'search-button']); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',compact('model')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', [
	'id'=>'client-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=> [
		'id',
		'sid',
		'fio',
		'account.id',
		'account.summa',
    ],
]); ?>
