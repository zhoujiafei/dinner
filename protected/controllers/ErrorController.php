<?php
define('NO_LOGIN',true);
class ErrorController extends FormerController
{
	//登录的首页
	public function actionIndex()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
?>