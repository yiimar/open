<?php


namespace app\components;

use CJSON;
use CMenu;
use CBreadcrumbs;
use Yii;

class Controller extends \CController
{
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu   = [];

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = [];

    /**
     * @var string pageTitle
     */
    public $title = null;

    /**
     * @var string page description
     */
    public $description = null;

    /**
     * @var boolean
     */
    public $top_separator = false;

    /**
     * @var boolean
     */
    public $footer = true;

    /**
     * @var boolean
     */
    public $header  = true;

    /**
     * @var mixed sidebar data
     */
    public $sidebar = false;

    /**
     * @return void
     */
    public function init()
    {
        $this->sidebar = $this->sidebar ?: [
            'data' => null,
            'type' => 'default',
        ];

        return parent::init();
    }

    /**
     * badQuery action:
     *
     * @param mixed $error - error array
     *
     * @return void
     */
    public function badQuery($error = null)
    {
        if (Yii::app()->request->getIsAjaxRequest() === true) {
            return $this->ajaxQuery([
                'message' => $error['message'],
                'code'    => $error['code'],
            ]);
        }

        $this->title  = 'Error ' . $error['code'];

        $this->render('//layouts/error', $error);
    }

    /**
     * ajaxQuery action:
     *
     * @param mixed $data - data to return
     *
     * @return void
     */
    public function ajaxQuery($data = null)
    {
        header('Content-type: application/json; charset="UTF-8"');

        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * render sidebar:
     *
     * @return void
     */
    public function renderSidebar()
    {
        if (isset($this->sidebar['type'], $this->sidebar['data']) === false) {
            $this->sidebar = [
                'data' => null,
                'type' => 'default',
            ];
        }

        $this->renderPartial(
            '//sidebar/' . $this->sidebar['type'], $this->sidebar['data']
        );
    }
}