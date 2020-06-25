<?php

namespace app\components;

use Yii;

/**
 * Class DActiveRecord
 * @package app\components
 */
class DActiveRecord extends \CActiveRecord
{
    /**
     * Fill form fields:
     *
     * @return mixed, request data
     */
    public function populate()
    {
        $class = str_replace('\\', '_', get_class($this));
        $data = Yii::app()->getRequest()->getPost($class);
        $this->setAttributes($data);

        return $data;
    }

    /**
     * Проверка: есть ли запись, отвечающая $criteria. Если есть, то:
     *      - при $update = true проверяем атрибуты модели и новые, если раздичные, то обновляем аттрибуты и сохраняем
     *                                                 Если нет, то:
     *                            создаем новую запись, заполняем аттрибутами и сохраняем
     * @param array $criteria
     * @param array $attributes
     * @param bool $update
     * @return mixed
     * @throws \CDbException
     */
    public static function findOrInsert(array $criteria, array $attributes = [])
    {
        $class = static::class;
        if (null !== ($model = $class::model()->findByAttributes($criteria))) {
//            todo - написать метод
//            $model->saveIfAttributesChanged($attributes);
        } else {
            if ([] === $attributes) {
                $attributes = $criteria;
            }
            $model = new $class;
            $model->attributes = $attributes;
            if (!$model->save()) {
                throw new \CDbException('Модель ' . $class . ' сохранить не удалось');
            }
        }
        return $model;
    }
}