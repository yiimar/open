<?php

use app\components\Controller;
use app\models\Client;
use app\models\Account;
use app\models\forms\UploadForm;

class BaseController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionList()
	{
        $model=new Client('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Client']))
            $model->attributes=$_GET['Client'];

        $this->render('list', compact('model'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    /**
     * Displays the upload form page
     * @throws \CDbException
     */
	public function actionUpload()
	{
		$model = new UploadForm();
		if ($model->populate() && $model->validate() && $model->proccess()) {
            $this->redirect(['/base/list']);
        }
		$this->render('upload', compact('model'));
	}
}