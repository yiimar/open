<?php

namespace app\modules\import\components;

use app\modules\import\transports\pss\PSS;
use app\modules\import\transports\pss\PssHelper;

/**
 * Description of PssService
 *
 * @author yiimar
 */
class PssService
{
    const MYSQL_FORMAT = 'Y-m-d H:i:s';

    /**
     * Получить весь массив данных по имени листа
     * 
     * @param type $path
     * @param type $name
     * @return type array
     */
    public static function getTable($path, string $name) : array
    {
        return PssHelper::getTable($path, $name);
    }

    /**
     * Получить массив для титульной строки (1й)
     * 
     * @param type $path
     * @param type $name
     * @return type 
     */
    public static function getTitleRow($path, string $name) : array
    {
        return PssHelper::getTitleRow($path, $name);
    }

    /**
     * Получить вертикальную вырезку листа для заданных индексами колонок
     * Индексы можно получить методом self::getIndexesForColumns($path, $name, $columns)
     * 
     * @param type $path
     * @param type $name
     * @param type $columns
     * @return type
     */
    public static function getListChunkByIndexColumns($path, string $name, array $columnIndexes) : array
    {
        return PssHelper::makeChunkByColumns($path, $name, $columnIndexes);
    }

    /**
     * Получить вертикальную вырезку листа для заданных Надписями колонок
     * 
     * @param type $path
     * @param type $name
     * @param type $columns
     * @return type
     */
    public static function getListChunkByTitleColumns($path, string $name, array $columnTitles) : array
    {
        $indexes = self::getIndexesForColumns($path, $name, $columnTitles);
        return PssHelper::makeChunkByColumns($path, $name, $indexes);
    }

    /**
     * Получение индексов колонок по их Названиям
     * @param type $path
     * @param type $name
     * @param type $columns
     * @return type array
     */
    public static function getIndexesForColumns($path, string $name, array $titles) : array
    {
        return PssHelper::indexesByTitles($path, $name, $titles);
    }
    public static function getSheetNameList($path)
    {
        return PSS::sheetNameList($path);
    }
    public static function getSheetInfo($path)
    {
        return PSS::sheetInfo($path);
    }

    /**
     * Перевод даты из формата Microsoft Excel в MySql
     * @param $value numeric
     * @return false|string|null
     */
    public static function makeDate(int $value)
    {
        if (!empty($value)) {
            $unixDate = ($value - 25569) * 86400;
            $mysqlDate = date(self::MYSQL_FORMAT, $unixDate);
            return $mysqlDate;
        } else {
            return null;
        }
    }
}
