<?php
//接口模块
class ApiModule extends CWebModule
{
	public $defaultController='index';
	private $_user;//存放用户信息
	public function init()
	{
		$this->setImport(array(
			'api.models.*',
			'api.components.*',
			'api.extensions.*',
		));
	}
	
	//获取当前用户信息
	public function getUser()
	{
		return $this->_user;
	}
	
	//设置当前用户信息
	public function setUser($userInfo = array())
	{
		$this->_user = $userInfo;
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
						
						//转换成数组
						$memberInfo = CJSON::decode(CJSON::encode($memberInfo));
						//把用户信息存放到user里面供访问
						unset($memberInfo['password'],$memberInfo['salt']);
						//如果存在头像，就返回
						if($memberInfo['avatar'])
						{
							//取图片数据
							$material = Material::model()->findByPk($memberInfo['avatar']);
							$memberInfo['avatar'] = array(
								'host' => Yii::app()->params['img_url'],
								'filepath' => $material->filepath,
								'filename' => $material->filename,
							);
						}
						$this->_user = $memberInfo;
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
