<?php

namespace app\modules\import\transports\pss;

use yii\base\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use app\modules\import\components\ColumnNameReadFilter;

/**
 * Description of PSS
 *
 * @author yiimar
 */
class PSS extends \yii\base\Component
{
    public $path;
    public $reader;
    public $spreadsheet;

    /**
     * 
     * @param type $path
     * @param type $dataOnly        Чтение только данных из файла электронной таблицы (без стилей)
     * @param type $oneSheetOnly    Чтение только именованного рабочего листа из файла
     * @param type $filterSubSet    Фильтр, определяющий диапазон считывания
     * @param type $load            Флаг необходимости загрузки всего файла
     * 
     * @return PSS $this 
     */
    public function __construct($path, $dataOnly = true, $oneSheetOnly = '', $filterSubSet = '', $load = true)
    {
        $this->path    = $path;
        $inputFileType = IOFactory::identify($path);
        $this->reader  = IOFactory::createReader($inputFileType);

        $this->reader->setReadDataOnly($dataOnly);

        if (/*($filterSubSet != '') && */($filterSubSet instanceof IReadFilter)) {
            $this->reader->setReadFilter($filterSubSet);
        }

        if (($oneSheetOnly != '') && (self::isSheet($path, $oneSheetOnly))) {
            $this->reader->setLoadSheetsOnly($oneSheetOnly);        // прочитать один лист
        } else {
            $this->reader->setLoadAllSheets();                      // прочитать все листы
        }
        if ($load) {
            $this->spreadsheet = $this->reader->load($path);
        }
    }

    /**
     * Получение списка таблиц без загрузки всего файла в формате:
     *      [
     *          0 => Договор,
     *          1 => pp,csv,
     *          2 => Лист2,
     *      ]
     * @return type array
     */
    public static function sheetNameList($path)
    {
        $sss = new self($path, true, '', '', false);
        return $sss->reader->listWorksheetNames($path);
    }

    /**
     * Получение массива информации о таблицах без загрузки самого файла в формате:
     *      [
     *          0 => [
     *              worksheetName    => Договор,
     *              lastColumnLetter => AD,
     *              lastColumnIndex  => 29,
     *              totalRows        => 18,
     *              totalColumns]    => 30,
     *          ],
     *          1 => [
     *              worksheetName    => pp,csv,
     *              lastColumnLetter => AC,
     *              lastColumnIndex  => 28,
     *              totalRows        => 106,
     *              totalColumns     => 29,
     *          ],
     *          2 => [
     *              worksheetName    => Лист2,
     *              lastColumnLetter => B,
     *              lastColumnIndex  => 1,
     *              totalRows        => 25,
     *              totalColumns     => 2,
     *          ],
     *      ] 
     * 
     * @return type array
     */
    public static function sheetInfo($path)
    {
        $sss = new PSS($path, true, '', '', false);
        return $sss->reader->listWorksheetInfo($path);
    }

    /**
     * Проверка: есть ли таблица (лист) с таким названием в файле
     * @param type $path            путь к файлу-источнику
     * @param type $sheetName       проверяемое название таблицы
     * @return type boolean
     */
    public static function isSheet($path, $sheetName)
    {
        return in_array($sheetName, self::sheetNameList($path));
    }
    public static function testSheet($path, $sheetName)
    {
        if (self::isSheet($path, $sheetName))       return true;
        else                                        throw new \Exception('Листа: ' . $sheetName . ' в файле ' . $path . ' нет!');
    }
}
