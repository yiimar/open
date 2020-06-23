<?php


namespace app\modules\import\config;


use app\modules\book\models\Worker;
use app\modules\import\components\ConfigInterface;
use app\models\AuthUsers;
use app\models\Contractor;
use app\models\EndSystems;
use app\models\Teams;


/**
 * BaseVendorConfig
 *
 * @author yiimar
 */
abstract class BaseVendorConfig implements ConfigInterface
{
    public function __construct()
    {
        $this->class = $this->getClass();
    }

    /**
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
     * 'books' => [
     *      bookModel->kind => [
     *          `имя результирующего атрибута модели` => ``,
     *          `имя колонки листа`                   => ``,
     *          `имя поискового атрибута модели`      => ``,
     *      ],
     * ],
     */
    public function getBooks()
    {
        return [
//            1 => [//'Класс контракта',
//                'field'        => 'class',
//                'sheet_column' => 'Класс договора',
//                'table_column' => 'code',
//            ],
//            2 => [//'Вид контракта',
//                'field'        => 'species',
//                'sheet_column' => 'Вид договора',
//                'table_column' => 'code',
//            ],
//            3 => [//'Тип контракта',
//                'field'        => 'kind',
//                'sheet_column' => 'Тип договора',
//                'table_column' => 'code',
//            ],
//            4 => [//'Способ закупки',
//                'field'        => 'purchase',
//                'sheet_column' => 'Способ закупки',
//                'table_column' => 'code',
//            ],
//            5 => [//'Ответственное подразделение',
//                'field'        => 'responsible',
//                'sheet_column' => 'Ответственное подразделение',
//                'table_column' => 'code',
//            ],
//            6 => [//'Валюта договора',
//                'field'        => 'currency',
//                'sheet_column' => 'Валюта договора',
//                'table_column' => 'code',
//            ],
        ];
    }

    public function getUsers()
    {
        return [
//            [
//                'field'        => 'resp_id',
//                'sheet_column' => 'Ответственный за спецификацию/договор',
//                'table_column' => 'name',
//            ],
        ];
    }
    public function getModels()
    {
        return [
            [
                'class'        => Contractor::class,
                'field'        => 'contractor_id',
                'sheet_column' => 'Подразделение 2 уровня',
                'table_column' => 'name',
                'factor'       => 'new',
            ],
            [
                'class'        => Teams::class,
                'field'        => 'team_id',
                'sheet_column' => 'ID команды (из ФОС) new',
                'table_column' => 'additional_code',
                'items'        => [
                    'name' => 'Команда (из ФОС) new',
                ],
                'factor'       => self::MODEL_FACTOR_NEW,
            ],
            [
                'class'        => Worker::class,
                'field'        => 'team_id',
                'sheet_column' => 'Команда (из ФОС)',
                'table_column' => 'name',
                'factor'       => 'wnothing',
            ],
        ];
    }

//    public function getItems() : array
//    {
//        return [
//            'Предмет договора' => 'subject'
////            '№ Основного Договора ' => 'number_out',//Внешний номер договора
////            'БЕ'                       => 'unit',
////            'Номер карточки договора'  => 'card_number',
////            'Заголовок договора'       => 'headline',
////            'Внешний номер договора'   => 'number_out',
////            'Номер разового счета'     => 'single_account',
////            'Предмет договора'         => 'subject',
////            'Статус карточки договора' => 'card_status',
////            'Валюта договора'          => 'currency',
//        ];
//    }
//    public function getAmounts()
//    {
//        return [
//            'Лимит договора руб. с НДС' => 'amount_rub',//Сумма рамочного дог. с НДС (руб.)
////            'Сумма договора (Вал.)' => 'total_currency',
////            'Сумма договора (Руб.)' => 'amount_rub',
////            'НДС (Руб.)'            => 'vat_rub',
//        ];
//    }

    public function getParent()
    {
        return [
            'field'        => 'parent_id',
            'sheet_column' => '№ Основного Договора',
        ];
    }
}