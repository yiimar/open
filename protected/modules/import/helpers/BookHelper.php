<?php

namespace app\modules\import\components;

/**
 * Description of BookHelper
 *
 * @author yiimar
 */
class BookHelper
{
    /**
     * Метод для заполнения справочника
     * 
     * @param string $modelName
     * @param array $attributes
     * @return type
     * @throws \Exception
     */
    public static function getIdOrInsertNew(string $modelName, array $attributes)
    {
        $attributes['book_id'] = intval($attributes['book_id']);
        $model = new $modelName;
        $model = $model::find()
            ->where(array_slice($attributes, -2, 2))
            ->one();
        if (!$model) {
            $model = new $modelName;
            $model->attributes = $attributes;
            if (!$model->save()) {
//                throw new \Exception('В модель ' . $modelName . ' не добавилась: ' . print_r($model->attributes));
            }
        }
        return $model->id;
    }

    /**
     * Метод для получения идентификатора справочника при загрузке документа
     * 
     * @param string $modelName
     * @param array $attributes
     * @return type
     * @throws \Exception
     */
    public static function getBookId(string $modelName, array $attributes)
    {
        $model = new $modelName;
        $model = $model::find()
            ->where(array_slice($attributes, -2, 2))
            ->one();
        if (!$model) {
            echo 'В справочнике нет такой записи: ' . 'model= ' . $modelName . "<br>"; print_r($attributes); die();
//            throw new \Exception('В справочнике нет такой записи: ' . $attributes['name']);
        }

        return $model->id;
    }

    /**
     * Метод для получения идентификатора справочника FOS при загрузке документа
     * 
     * @param string $modelName
     * @param array $attributes
     * @return type
     * @throws \Exception
     */
    public static function getFoxId(string $modelName, array $attributes)
    {
        $model = new $modelName;
        $model = $model::find()
            ->where(array_slice($attributes, -1, 1))
            ->one();
        if (!$model)                throw new \Exception('В справочнике FOS нет такой записи');

        return $model->id;
    }
}
