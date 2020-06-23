<?php

namespace app\modules\import\components;

use Yii;
use app\modules\import\transports\pss\PssHelper;
use app\modules\import\components\ConfigInterface;
use yii\helpers\VarDumper;

/**
 * Description of BaseParser
 *
 * @author yiimar
 */
abstract class BaseParser
{
    protected $path;
    protected $name;
    protected $sheet;
    public $sheetRow;
    public $config;
    public $record;
    public $result;

    public function __construct($path, $name)
    {
        $this->result = [];
        $this->path   = $path;
        $this->name   = $name;
        $this->sheet  = PssHelper::getTableWithTitles($path, $name);
        $this->getConfig();
    }

    /**
     * Обработка исходной таблички по сценарию
     * @return array
     */
    public function insertRecords($startRow = 0)
    {
        $result = [];
        for ($row = $startRow; $row < count($this->sheet); $row++) {//
            $this->sheetRow = $this->sheet[$row];
            if ($this->isValidRow()) {
                $this->initRecord();                                // row init
                foreach ($this->config->getScenario() as $action) { // & fill it
                    $method = 'make' . $action;
                    $res    = $this->$method();
                    $result[$row][$method] = $res;
                }
                if ($res) {
                    $this->saveRecord($row);
                }                            // & save
            }
        }
        return $this->result = $result;
    }

    protected function initRecord() : array
    {
        $this->record = [];
        return $this->record;
    }

    /**
     * Заполнение полей записи из строки таблицы при прямой соответствии значений
     * @param $row - номер обрабатываемой строки
     * @return bool
     */
    protected function makeItems()
    {
        $items = $this->config->getItems();
        foreach ($items as $rowIndex => $modelIndex) {
            $this->record[$rowIndex] = $this->sheetRow[$modelIndex];
        }
        return true;
    }

    /**
     * Перевод дат из формата Microsoft Excel в MySql
     * @param $row - номер обрабатываемой строки
     */
    protected function makeDates()
    {
        $items = $this->config->getDates();
        foreach ($items as $rowIndex => $modelIndex) {
            $primaryDate = ltrim($this->sheetRow[$rowIndex]);
            $this->record[$modelIndex] = is_numeric($primaryDate)
                ? PssService::makeDate($primaryDate)
                : null;
        }
        return true;
    }

    protected function makeAmounts()
    {
        $items = $this->config->getAmounts();
        foreach ($items as $rowIndex => $modelIndex) {
            $this->record[$modelIndex] = str_replace(',', '.', $this->sheetRow[$rowIndex]);
        }
    }

    protected function makeModels()
    {
        $models = $this->config->getModels();
        foreach ($models as $model) {
            if (!empty($value = $this->sheetRow[$model['sheet_column']])) {
                $class = $model['class'];
                $conditions = [];
                foreach ($model['search'] as $key => $val) {
                    $conditions[$key] = $this->sheetRow[$val];
                }
                $item = $class::find()
                    ->where($conditions)
                    ->one();
                if (!$item) {
                    switch ($model['factor']) {
                        case BaseConfig::MODEL_FACTOR_NEW:
                            $item = new $class();
                            foreach ($model['attributes'] as $attr => $val) {
                                $item->$attr = $this->sheetRow[$val];
                            }
                            if (property_exists($class, 'status')) {
                                $item->status = 1;
                            }
                            if (!$item->save()) {
                                throw new \Exception('Не удалось сохранить новую запись: ' . $value);
                            }
                            // Если нужно заполнить модель "попутно", без влияния на главный парсер с главной
                            if ($model['field'] !== '') {
                                $this->record[$model['field']] = $item->id;
                            }
                            break;
                        case BaseConfig::MODEL_FACTOR_THROU :
                            throw new \Exception('Не удалось найти запись в справочнике: ' . $value);
                            break;
                        case BaseConfig::MODEL_FACTOR_NOTHING :
                        default :
                    }
                } else {
                    if ($model['field'] !== '') {
                        $this->record[$model['field']] = $item->id;
                    }
                }
            }
        }
        if (!empty($model['require']) && empty($this->record[$model['field']])) {
            return false;
        }
        return true;
    }

    protected function makeOwners()
    {
         $owners = $this->config->getOwners();
         foreach ($owners as $owner) {
             if ($value = $this->sheetRow[$owner['sheet_column']]) {
                 $class = $owner['class'];
                 $item = $class::find()
                     ->where(['fos_code' => $value])
                     ->one();
                 if ($item) {
                     $this->record[$owner['table_column']] = $item->id;
                 }
             }
         }
         return true;
    }

    /**
     * Сохранение заполненной строки в таблице БД
     * @param bool $update необходимость обновления записи
     * @return bool
     */
    protected function saveRecord($row, $update = false)
    {
        $conditions = $this->searchCondition();
        $class = $this->config->getClass();
        $model = $class::find()
            ->where($conditions)
            ->one();
        if ($model) {
            if (false === $update) {
                return true;
            }
        }
        $model = new $class;
        $model->attributes = $this->record;
        $res = $model->save();
        if ($res) {
            $this->result[$row]['save'] = 'norm';
        } else {
            $this->result[$row]['save-error'] = $this->record;
        }
        return true;
    }

    abstract public function getConfig() : ConfigInterface ;

    /**
     * Проверка валидности текущей строки, показывающая, что текущая строка подлежит обработке
     * @return bool
     */
    abstract protected function isValidRow() : bool ;

    /**
     * Массив для проверки существования записи в таблице
     * @return array например: return ['card_number' => $this->record['card_number']];
     */
    abstract protected function searchCondition() : array ;
}
