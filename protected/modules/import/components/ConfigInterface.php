<?php


namespace app\modules\import\components;


/**
 * ConfigInterface
 *
 * @author yiimar
 */
interface ConfigInterface
{
    /**
     * Строка полного пути к классу модели результирующего сохранения данных
     * @return string
     */
    public function getClass() : string ;
    /**
     * Получение массива названий этапов сценария, например:
     *  array(
     *      'Books',
     *      'Models',
     *      'Items',
     *      'Dates',
     *      'Money',
     *      'Parent',
     *  )
     * @return array
     */
    public function getScenario() : array ;
    /**
     * Массив соответствия названий колонок таблицы названиям полей таблицы БД:
     * array(
     *     ...
     *     'назване колонки таблицы(листа)' => 'название поля таблицы БД',
     *     ...
     * )
     * @return array
     */
    public function getItems() : array ;
}