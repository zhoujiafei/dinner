<?php
//登录接口
class LoginController extends ApiController
{
	public function actionIndex()
	{
		//获取用户名和密码
		$name = Yii::app()->request->getParam('name');
		$password = Yii::app()->request->getParam('password');

		if(!$name)
		{
			Error::output(Error::ERR_NO_USER_NAME);
		}
		
		if(!$password)
		{
			Error::output(Error::ERR_NO_PASSWORD);
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
}