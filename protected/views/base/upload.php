<?php

use app\controllers\BaseController;
use app\models\forms\UploadForm;

/* @var $this BaseController */
/* @var $model UploadForm */
/* @var $form \CActiveForm */

$this->pageTitle = \CHtml::encode('Загрузка XSLX');
$this->breadcrumbs= [
	$this->pageTitle,
];
?>

<h1><?= $this->pageTitle ?></h1>

    <div class="form">
        <?php $form=$this->beginWidget(\CActiveForm::class, [
            'id'=>'upload-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => ['enctype' => 'multipart/form-data',],
        ]); ?>
            <?= $form->errorSummary($model); ?>
                <div class="row">
                    <?= $form->fileField($model, 'file'); ?><br>
                    <?= $form->error($model,     'file'); ?>
                </div>
                <div class="row buttons">
                    <?= \CHtml::submitButton(\CHtml::encode('Загрузить')); ?>
                </div>
        <?php $this->endWidget(); ?>
    </div>