<?php

namespace app\modules\import\controllers;

use Yii;
use app\modules\contract\components\DController;
use app\modules\import\components\PssService;
use yii\filters\VerbFilter;

/**
 * По-сути, тестовый контроллер, демонстрирующий работу основных методов импорта
 * Здесь:
 *      $name - имя таблички (листа таблтчки) в файле импорта
 *
 * @author yiimar
 */
class SheetController extends DController
{
    public $name = 'Реестр договоров';

    /**
     * Путь к файлу импорта
     * @var type ыекштп
     */
    public $path;

    public function init()
    {
        ini_set('max_execution_time', 480);
        ini_set('memory_limit','2048M');

        // import file path
        $this->path = \app\modules\contract\components\ContractHelper::getImportPath() . 'EXPORT.XLSX';
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

    /**
     * Получение чанка по индексам колонок
     * @return type View
     */
    public function actionColumn()
    {
        $columnIndexes = [
            0, 4, 7, 10
        ];
        $chunk = PssService::getListChunkByIndexColumns($this->path, $this->name, $columnIndexes);
        return $this->render('column', compact('chunk'));
    }

    /**
     * Получение чанка по наименованиям колонок
     * @return type View
     */
    public function actionTitle()
    {
        $columnTitles = [
            'БЕ', 'Номер карточки договора', 'Вид договора', 'Описание типа договора',
        ];
        $chunk = PssService::getListChunkByTitleColumns($this->path, $this->name, $columnTitles);
        return $this->render('column', compact('chunk'));
    }

    /**
     * Получение названий листов (sheetNameList) и информации по ним (sheetInfo)
     * @return type
     */
    public function actionIndex()
    {
        $list = PssService::getSheetNameList($this->path);
        $info = PssService::getSheetInfo($this->path);
        return $this->render('index', compact('list', 'info'));
    }

    /**
     * Получение строки заголовков листа
     * @return type
     */
    public function actionRow()
    {
        $table = PssService::getTitleRow($this->path, $this->name);
        return $this->render('row', compact('table'));
    }

    /**
     * Получение массива данных листа
     * @return type
     */
    public function actionSheet()
    {
        $table = PssService::getTable($this->path, $this->name);

        return $this->render('sheet', compact('table'));
    }
}
