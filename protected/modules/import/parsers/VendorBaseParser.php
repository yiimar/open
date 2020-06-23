<?php

namespace app\modules\import\parsers;

use app\models\AuthUsers;
use app\models\Contractor;
use app\modules\book\components\BookHelper;
use app\modules\contract\components\ContractHelper;
use app\modules\contract\models\Contract;
use app\modules\import\components\BaseParser;
use Yii;
use yii\db\Exception;

/**
 * Description of VendorBaseParser
 *
 * @author yiimar
 */
abstract class VendorBaseParser extends BaseParser
{
    protected function makeModels()
    {
        $models = $this->config->getModels();
        foreach ($models as $model) {
            if ($value = $this->sheetRow[$model['sheet_column']]) {
                $class = $model['class'];
                $item = $class::find()
                    ->where(['like', $model['table_column'], $value . '%', false])
                    ->one();
                if (!$item) {
                    switch ($model['factor']) {
                        case 'new':
                            $item = new $class();
                            $item->{$model['table_column']} = $value;
                            if (property_exists($class, 'status')) {
                                $item->status = 1;
                            }
                            if (!$item->save()) {
                                throw new \Exception('Не удалось сохранить новую запись: ' . $value);
                            }
                            $this->record[$model['field']] = $item->id;
                            break;
                        case 'throe' :
                            throw new \Exception('Не удалось найти запись в справочнике: ' . $value);
                            break;
                        case 'wnothing' :
                        default :
                    }
                } else {
                    $this->record[$model['field']] = $item->id;
                }
            }
        }
        return true;
    }

    protected function makeUsers()
    {
        $users = $this->config->getUsers();
        foreach ($users as $user) {
            if ($value = $this->sheetRow[$user['sheet_column']]) {
                $item = AuthUsers::find()
                    ->where(['like', $user['table_column'], $value . '%', false])
                    ->one();
                if (!$item) {
                    throw new \Exception('Не удалось найти пользователя: ' . $value);
                }
                $this->record[$user['field']] = $item->id;
            }
        }
        return true;
    }
    protected function makeBooks()
    {
        $books = $this->config->getBooks();
        foreach ($books as $id => $book) {
            $sheet_column = $this->sheetRow[$book['sheet_column']];
            if ($sheet_column) {
                $attributes = [];
                $attributes['book_id'] = (int)($id);
                $attributes[$book['table_column']] = $sheet_column;
                $this->record[$book['field']] = BookHelper::bookItemIdByAttributes($attributes);
            }
        }
        return true;
    }
//    protected function searchCondition(): array
//    {
//        return [
//            'number_out' => $this->record['number_out'],
//        ];
//    }
//    /**
//     * Сохранение заполненной строки в таблице БД
//     * @param bool $update необходимость обновления записи
//     * @return bool
//     */
//    protected function saveRecord($row, $update = false)
//    {
////        if (isset($this->record['card_number'])) {
//            $model = $this->config->class::find()
//                ->where(['card_number' => $this->record['card_number']])
//                ->one();
//            if ($model) {
//                if (false === $update) {
//                    return true;
//                }
//            } else {
//                $model = new $this->config->class;
//            }
//            $model->attributes = $this->record;
//                    $model->save();
//            $this->result[] = $this->record;
////        }
//        return true;
//    }

//    protected function makeParent()
//    {
//        $item = $this->config->getParent();
//        $search = $this->sheetRow[$item['sheet_column']] ?: '';
//        if (strlen($search) > 10) {
//            $attributes = [$item['table_column'] => $search];
//            if (false != $id = ContractHelper::bookItemIdByAttributes($attributes)) {
//                $this->record[$item['field']] = $id;
//            }
//        }
//        return true;
//    }
}
