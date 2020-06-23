<?php


/**
 * Class FormModel
 * @package application.components
 */
class FormModel extends CFormModel
{
    /**
     * Fill form fields:
     *
     * @return mixed, request data
     */
    public function populate()
    {
        $class = str_replace('\\', '_', get_class($this));
        $data  = request()->getPost($class);
        $this->setAttributes($data);

        return $data;
    }

    /**
     * AJAX validation:
     *
     * @param string $ajaxValue - request value name
     * @return void
     */
    public function ajaxValidate($ajaxValue = null)
    {
        if (request()->getPost('ajax') === $ajaxValue) {
            echo CActiveForm::validate($this);

            app()->end();
        }
    }

    /**
     * Получаем placeholder:
     *
     * @param string $field - field name
     * @param string $category
     * @return string, field placeholder
     */
    public function getPlaceHolder($field, $category = 'app')
    {
        return Yii::t($category, 'Input :field_name', [
            ':field_name' => mb_strtolower($this->getAttributeLabel($field), 'UTF-8'),
        ]);
    }
}
