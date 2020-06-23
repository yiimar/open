<?php

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
		if ($error=app()->errorHandler->error) {
			if (request()->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionUpload()
	{
		$model = new UploadForm();
		if ($model->populate() && $model->proccess()) {
		    $this->redirect(['/base/list']);
        }
		$this->render('upload', compact('model'));
	}

    /**
     * Performs the AJAX validation.
     * @param Client $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}