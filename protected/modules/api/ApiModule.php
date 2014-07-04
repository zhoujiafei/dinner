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
					//检测token有没有过期
					$userLogin = UserLogin::model()->find("token = :token AND login_time + " .Yii::app()->params['login_expire_time'] . " > " . time(),array(':token' => $accessToken));
					if($userLogin)
					{
						//根据用户id查询用户信息
						$memberInfo = Members::model()->find('id = :id',array(':id' => $userLogin->user_id));
						if(!$memberInfo)
						{
							Error::output(Error::ERR_NO_LOGIN);
						}
					}
					else 
					{
						Error::output(Error::ERR_NO_LOGIN);
					}
				}
			}
			return true;
		}
		else
			return false;
	}
}
