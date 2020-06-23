<?php

namespace app\modules\import\transports\pss;

use app\modules\import\transports\pss\PSS;

/**
 * Description of PssHelper
 *
 * @author yiimar
 */
class PssHelper
{
    public static function makeChunk(
        $path, $name,
        $minCol            = 'A1',              // Стартовая колонка
        $maxCol            = null,              // Последняя колонка. Если =null, то все
        $maxRow            = null,              // Последняя строка. Если =null, то все
        $nullValue         = null,              // Обработка null
        $calculateFormulas = true,              // Обработка формул
        $formatData        = true,              // Обработка дат
        $returnCellRef     = false              // Обработка ссылок
    ) {
        $sss               = new PSS($path, true, $name, '', true);     // грузим лист $name
        $maxCol            = ($maxCol !== null) ?: self::getMaxColumnByName($path, $name);
        $maxRow            = ($maxRow !== null) ?: self::getMaxRowByName($path, $name);
        $nullValue         = null;
        $calculateFormulas = true;
        $formatData        = true;
        $returnCellRef     = false;
        $import            = $sss->spreadsheet->getActiveSheet()->rangeToArray($minCol . ':' . $maxCol . $maxRow, $nullValue, $calculateFormulas, $formatData, $returnCellRef);
        foreach ($import as &$item1) {
            if (is_array($item1)) {
                foreach ($item1 as &$item2) {
                    $item2 = ltrim($item2);
                }
            } else {
                $item1 = ltrim($item1);
            }
        }
        return $import;
    }

    /**
     * Получение Символа последней колонки. Внимание! Получать этим методом!
     * spreadsheet->getActiveSheet()->getHighestColumn() работает некорректно!!!
     * (а максимальную строку ...->getHighestRow() вычисляет корректно.
     * 
     * @param type $path
     * @param type $name
     * @return type
     * @throws \Exception
     */
    public static function getMaxColumnByName($path, $name)
    {
        PSS::testSheet($path, $name);
        $info = PSS::sheetInfo($path);
        $max = null;
        foreach ($info as $item) {
            if ($item['worksheetName'] == $name) {
                $max = $item['lastColumnLetter'];
                if ($max) {
                    return $max;
                }
            }
        }
        throw new \Exception('В таблице "' . $name . '" не определены колонки!');
    }

    /**
     * Получение числа строк активного листа
     * 
     * допустимо и:  $sss->spreadsheet->getActiveSheet()->getHighestRow();
     * 
     * @param type $path
     * @param type $name
     * @return type
     * @throws \Exception
     */
    public static function getMaxRowByName($path, $name)
    {
        self::testSheet($path, $name);
        $info = PSS::sheetInfo($path);
        $max = 0;
        foreach ($info as $item) {
            if ($item['worksheetName'] == $name) {
                $max = (int)$item['totalRows'];
                if ($max) {
                    return $max;
                }
            }
        }
        throw new \Exception('Таблица ' . $name . ' имеет 0 строк!');
    }

    public static function testSheet($path, $name)
    {
        if (!PSS::isSheet($path, $name)) {
            throw new \Exception('Листа ' . $name . ' нет в файле ' . $path);
        }
        return true;
    }

    /**
     * Получение индекса колонки по титулу
     * @param type $path
     * @param string $name
     * @param string $title
     * @return type string
     */
    public static function indexByTitle($path, string $name, string $title)
    {
        $row  = self::getTitleRow($path, $name);
        $flip = array_flip($row);
        return isset($flip[$title]) ?: '';
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
        return PssHelper::makeChunk($path, $name, 'A1', null, 1)[0];
    }

    /**
     * Получение индексов колонок в виде:
     *  [
     *      'title1' => 'index1',
     *      ...
     *  ]
     *  для массива титулов: ['title1', 'title1', ... ]
     *  
     * @param type $path
     * @param string $name
     * @param array $titles
     * @return type 
     */
    public static function indexesByTitles($path, string $name, array $titles) : array
    {
        $row     = self::getTitleRow($path, $name);
        $flip    = array_flip($row);
        $indexes = [];
        foreach ($titles as $title) {
            if (isset($flip[$title])) {
                $indexes[$title] =  $flip[$title];
            } else {
                throw new \Exception('Название колонки: ' . $title . 'не найдено!');
            }
        }
        return $indexes;
    }

    /**
     * Получить весь массив данных по имени листа
     * 
     * @param type $path
     * @param type $name
     * @return type array
     */
    public static function getTable($path, string $name) : array
    {
        return PssHelper::makeChunk($path, $name);
    }

    /**
     * Массив таблицы, в которой вместo числовых индексов внутри строки даны названия колонок
     * @param type $path
     * @param string $name
     * @return array
     */
    public static function getTableWithTitles($path, string $name) : array
    {
        $res = [];
        $sheet  = self::makeChunk($path, $name);
        $titles = array_shift($sheet);
        $titles = array_map('trim', $titles);
        for ($j = 0; $j < count($sheet); $j++) {
            for ($i = 0; $i < count($titles); $i++) {
                $res[$j][$titles[$i]] = trim($sheet[$j][$i], "? \t\n\r\0\x0B");
            }
        }
        return $res;
    }

    /**
     * Получение массива избранныъ колонок "в полный рост"
     * @param type $path
     * @param type $name
     * @param array $columns
     * @return type array
     */
    public static function makeChunkByColumns($path, $name, array $columns)
    {
        $titles = self::getTitleRow($path, $name);
        $sheet  = self::getTable($path, $name);
        $chunk  = [];
        for ($i = 1; $i < count($sheet); $i++) {
            foreach ($columns as $index) {
                $title                 = $titles[$index];
                $chunk[$i - 1][$title] = $sheet[$i][$index];
            }
        }
        return $chunk;
    }
}
