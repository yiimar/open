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
        ];
    }

    public function getUsers()
    {
        return [
        ];
    }
    public function getModels()
    {
        return [
        ];
    }

    public function getParent()
    {
        return [
            'field'        => 'parent_id',
            'sheet_column' => '№ Основного Договора',
        ];
    }
}