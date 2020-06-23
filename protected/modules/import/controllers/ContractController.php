<?php

namespace app\modules\import\controllers;

use app\modules\contract\components\ContractHelper;
use app\modules\contract\components\DController;
use app\modules\import\parsers\MainParser;
use app\modules\import\parsers\RamkaParser;
use app\modules\import\parsers\SpecaParser;
use yii\filters\VerbFilter;

class ContractController extends DController
{
    public $path;
    public $name;

    public function init()
    {
        $this->path = ContractHelper::getImportPath() . 'Реестр14-04.xlsx';
        $this->name = 'Реестр договоров';

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionBook()
    {
        return $this->render('book');
    }

    public function actionSpeca()
    {
        $parser = new SpecaParser($this->path, $this->name);
        $result = $parser->insertRecords();
        $table  = $parser->result;
        return $this->render('speca', compact('result', 'table'));
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRamka()
    {
        $parser = new RamkaParser($this->path, $this->name);
        $result = $parser->insertRecords();
        $table  = $parser->result;
        return $this->render('ramka', compact('result', 'table'));
    }

    public function actionMain()
    {
        $parser = new MainParser($this->path, $this->name);
//        var_dump($parser->config->class); exit('rrr');
        $result = $parser->insertRecords();
        $table  = $parser->result;
        return $this->render('main', compact('result', 'table'));
    }

}
