<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?= request()->baseUrl; ?>/css/screen.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="<?= request()->baseUrl; ?>/css/print.css"  media="print">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?= request()->baseUrl; ?>/css/ie.css"     media="screen, projection">
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?= request()->baseUrl; ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?= request()->baseUrl; ?>/css/form.css">

        <title><?= e($this->pageTitle); ?></title>
    </head>

    <body>
        <div class="container" id="page">
            <div id="header">
                <div id="logo"><?= e(app()->name); ?></div>
            </div>
            <div id="mainmenu">
                <?php $this->widget('zii.widgets.CMenu', [
                    'items'=> [
                        ['label'=>'Остатки на счетах', 'url'=> ['/base/list']],
                        ['label'=>'Загрузить',         'url'=> ['/base/upload']],
                    ],
                ]); ?>
            </div>
            <?php if(isset($this->breadcrumbs)):?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', [
                    'links'=>$this->breadcrumbs,
                ]); ?>
            <?php endif?>

            <?= $content; ?>
            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?= date('Y'); ?> by Yiimar<br/>
                All Rights Reserved.<br/>
                <?= Yii::powered(); ?>
            </div><!-- footer -->
        </div><!-- page -->
    </body>
</html>