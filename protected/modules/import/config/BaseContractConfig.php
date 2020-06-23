<?php


namespace app\modules\import\config;


use app\modules\import\components\ConfigInterface;
use app\models\AuthUsers;
use app\models\Contractor;
use app\models\EndSystems;
use app\models\Teams;


/**
 * BaseContractConfig
 *
 * @author yiimar
 */
abstract class BaseContractConfig implements ConfigInterface
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
            1 => [//'Класс контракта',
                'field'        => 'class',
                'sheet_column' => 'Класс договора',
                'table_column' => 'code',
            ],
            2 => [//'Вид контракта',
                'field'        => 'species',
                'sheet_column' => 'Вид договора',
                'table_column' => 'code',
            ],
            3 => [//'Тип контракта',
                'field'        => 'kind',
                'sheet_column' => 'Тип договора',
                'table_column' => 'code',
            ],
            4 => [//'Способ закупки',
                'field'        => 'purchase',
                'sheet_column' => 'Способ закупки',
                'table_column' => 'code',
            ],
            5 => [//'Ответственное подразделение',
                'field'        => 'responsible',
                'sheet_column' => 'Ответственное подразделение',
                'table_column' => 'code',
            ],
            6 => [//'Валюта договора',
                'field'        => 'currency',
                'sheet_column' => 'Валюта договора',
                'table_column' => 'code',
            ],
        ];
    }

    /**
     * Массив полей пользователей TWS (из модели AuthUsers)
     * @return array
     */
//    public function getUsers()
//    {
//        return [
//            [
//                'field'        => 'dpm_resp_id',
//                'sheet_column' => 'Ответственный от DPM за спецификацию/договор',
//                'table_column' => 'name',
//                'factor'       => self::MODEL_FACTOR_NOTHING,
//            ],
//        ];
//    }

    /**
     * Массив полей справочников, имеющих отдельные модели
     * @return array
     */
    public function getModels()
    {
        return [
            [
                'class'        => AuthUsers::class,
                'field'        => 'dpm_resp_id',
                'sheet_column' => 'Ответственный от DPM за спецификацию/договор',
                'table_column' => 'name',
                'factor'       => self::MODEL_FACTOR_NOTHING,
            ],
            [
                'class'        => Contractor::class,
                'field'        => 'contractor_id',
                'sheet_column' => 'Поставщик',
                'table_column' => 'name',
                'factor'       => self::MODEL_FACTOR_NEW,
            ],
            [
                'class'        => Teams::class,
                'field'        => 'team_id',
                'sheet_column' => 'ID команды (из ФОС) new',
                'table_column' => 'additional_code',
                'items'        => [
                    'name' => 'Команда (из ФОС) new',
                ],
                'factor'       => self::MODEL_FACTOR_NOTHING,
            ],
            [
                'class'        => EndSystems::class,
                'field'        => 'end_systems_id',
                'sheet_column' => 'АС',
                'table_column' => 'name',
                'factor'       => self::MODEL_FACTOR_NOTHING,
            ],
        ];
    }

    /**
     * Массив строчных полей прямого соответвствия
     * @return array
     */
    public function getItems() : array
    {
        return [
            'Предмет договора'         => 'subject',
            '№ Основного Договора '    => 'number_out',
//            'БЕ'                       => 'unit',
//            'Номер карточки договора'  => 'card_number',
            'Заголовок договора'       => 'headline',
            'Внешний номер договора'   => 'number_out',
//            'Номер разового счета'     => 'single_account',
            'Предмет договора'         => 'subject',
//            'Статус карточки договора' => 'card_status',
            'Валюта договора'          => 'currency',
        ];
    }

    /**
     * Массив полей сумм
     * @return array
     */
    public function getAmounts()
    {
        return [
            'Лимит договора руб. с НДС' => 'amount_rub',//Сумма рамочного дог. с НДС (руб.)
//            'Сумма договора (Вал.)' => 'total_currency',
//            'Сумма договора (Руб.)' => 'amount_rub',
//            'НДС (Руб.)'            => 'vat_rub',
            'НДС, %'                => 'vat_percent',
        ];
    }

    /**
     * Массив полей для определения родительского (рамочного) договора
     * @return array
     */
    public function getParent()
    {
        return [
            'field'        => 'parent_id',
            'sheet_column' => '№ Основного Договора',
        ];
    }
}