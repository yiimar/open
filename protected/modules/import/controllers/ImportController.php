<?php

namespace app\modules\import\controllers;

use app\modules\contract\components\ContractHelper;
use app\modules\import\parsers\books\ContractWorkerParser;
use app\modules\import\parsers\books\WorkerParser;
use app\modules\import\parsers\books\WorkerTorParser;
use app\modules\import\parsers\RamkaParser;
use app\modules\import\parsers\SpecaParser;

class ImportController extends \yii\web\Controller
{
    public function actionBook()
    {
        return $this->render('book');
    }

    public function actionIndex()
    {
        $path = ContractHelper::getImportPath() . 'Реестр14-04.xlsx';
        $name2 = 'Реестр подрядчиков из ФОС';
        $name1 = 'Реестр договоров';

        $parser = new WorkerParser($path, $name2);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. Teams, Contractor, =Worker' . "<br>";

        $parser = new WorkerTorParser($path, $name2);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. TOR, =WorkerTor' . "<br>";

        $parser = new RamkaParser($path, $name1);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. Ramka' . "<br>";

        $parser = new SpecaParser($path, $name1);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. Speca' . "<br>";

        $parser = new ContractWorkerParser($path, $name2);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. SpecaWorker' . "<br>";

    }

    public function actionModel()
    {
        return $this->render('model');
    }

    public function actionRamka()
    {
        return $this->render('ramka');
    }

    public function actionSpeca()
    {
        return $this->render('speca');
    }

}
