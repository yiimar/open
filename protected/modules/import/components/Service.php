<?php


namespace app\modules\import\components;


use app\modules\contract\components\ContractHelper;
use app\modules\import\parsers\books\ContractWorkerParser;
use app\modules\import\parsers\books\WorkerParser;
use app\modules\import\parsers\books\WorkerTorParser;
use app\modules\import\parsers\RamkaParser;
use app\modules\import\parsers\SpecaParser;

/**
 * Service
 *
 * @author yiimar
 */
class Service
{
    public static function contractHandler($path, $name)
    {
        $parser = new RamkaParser($path, $name);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. Ramka' . "<br>";

        $parser = new SpecaParser($path, $name);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. Speca' . "<br>";
    }

    public static function workerHandler($path, $name)
    {
        $parser = new WorkerParser($path, $name);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. Teams, Contractor, =Worker' . "<br>";

        $parser = new WorkerTorParser($path, $name);
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. TOR, =WorkerTor' . "<br>";

        $parser = new ContractWorkerParser($path, $name );
        $result = $parser->insertRecords();
        echo 'Обработано ' . count($parser->result) . ' строк. SpecaWorker' . "<br>";
    }
}