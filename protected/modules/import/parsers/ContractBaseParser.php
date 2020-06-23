<?php

namespace app\modules\import\parsers;

use app\models\AuthUsers;
use app\modules\book\components\BookHelper;
use app\modules\import\components\BaseParser;
use app\modules\import\config\BaseContractConfig;

/**
 * Description of ContractBaseParser
 *
 * @author yiimar
 */
abstract class ContractBaseParser extends BaseParser
{
    protected function makeModels()
    {
        $models = $this->config->getModels();
        foreach ($models as $model) {
            if ($value = $this->sheetRow[$model['sheet_column']]) {
                $class = $model['class'];
                $item = $class::find()
                    ->where([$model['table_column'] => $value])
                    ->one();
                if (!$item) {
                    switch ($model['factor']) {
                        case BaseContractConfig::MODEL_FACTOR_NEW:
                            $item = new $class();
                            $item->{$model['table_column']} = $value;
                            if (property_exists($class, 'status')) {
                                $item->status = 1;
                            }
                            if (isset($model['items'])) {
                                foreach ($model['items'] as $key => $val) {
                                    $item->$key = $this->sheetRow[$val];
                                }
                            }
                            if (!$item->save()) {
                                throw new \Exception('Не удалось сохранить новую запись: ' . $value);
                            }
                            $this->record[$model['field']] = $item->id;
                            break;
                        case BaseContractConfig::MODEL_FACTOR_THROU :
                            throw new \Exception('Не удалось найти запись в справочнике: ' . $value);
                            break;
                        case BaseContractConfig::MODEL_FACTOR_NOTHING :
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
                if ($item) {
                    $this->record[$user['field']] = $item->id;
                } elseif ($users['factor'] === BaseContractConfig::MODEL_FACTOR_THROU) {
                    throw new \Exception('Не удалось найти пользователя: ' . $value);
                }
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
    protected function searchCondition(): array
    {
        return [
            'number_out' => $this->record['number_out'],
        ];
    }

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
