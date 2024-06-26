<?php


namespace app\modules\import\components;


use app\modules\import\components\ConfigInterface;
use app\models\AuthUsers;
use app\models\Contractor;
use app\models\EndSystems;
use app\models\Teams;


/**
 * BaseConfig
 *
 * @author yiimar
 */
abstract class BaseConfig implements ConfigInterface
{
    public const MODEL_FACTOR_NEW = 'new';
    public const MODEL_FACTOR_NOTHING = 'nothing';
    public const MODEL_FACTOR_THROU = 'throw';
    public const MODEL_FACTOR_FALSE = 'false';

    /**
     * BaseContractConfig constructor.
     */
    public function __construct()
    {
        $this->class = $this->getClass();
    }

    /**
     * Список и порядок выполнения сценариев обработки
     * @return array
     */
    public function getScenario() : array
    {
        return [
            'Books',
            'Models',
            'Items',
            'Dates',
            'Amounts',
            'Parent',
            'Users'
        ];
    }

    /**
     * Массив полей справочников договора (модели Book и BookItem)
     * 'books' => [
     *      bookModel->kind => [
     *          `имя результирующего атрибута модели` => ``,
     *          `имя колонки листа`                   => ``,
     *          `имя поискового атрибута модели`      => ``,
     *      ],
     * ],
     * @return array
     */
    public function getBooks()
    {
        return [
            4 => [//'Способ закупки',
                'field'        => 'purchase',
                'sheet_column' => 'Способ закупки',
                'table_column' => 'code',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return [
        ];
    }

    abstract public function getClass(): string ;

    /**
     * Массив строчных полей прямого соответвствия
     * @return array
     */
    abstract public function getItems() : array ;

}