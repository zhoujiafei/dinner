<?php
//接口模块
class ApiModule extends CWebModule
{
	public $defaultController='index';
	public function init()
	{
		$this->setImport(array(
			'api.models.*',
			'api.components.*',
			'api.extensions.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			//如果需要登陆就检测用户是否登陆
			if(defined('NEED_LOGIN') && NEED_LOGIN)
			{
				//检测
				$accessToken = Yii::app()->request->getParam('access_token');
				if(!$accessToken)
				{
					Error::output(Error::ERR_NO_LOGIN);
				}
				else 
				{
						
				}
			}
			
			return true;
		}
		else
			return false;
	}
}
