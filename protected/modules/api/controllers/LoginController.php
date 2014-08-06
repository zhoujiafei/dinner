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
		
		//获取用户模型
		$userinfo = Members::model()->find('name=:name',array(':name' => $name));
		if(!$userinfo)
		{
			Error::output(Error::ERR_NO_USER);
		}
		else 
		{
			$_password = md5($userinfo->salt . $password);
			if($_password != $userinfo->password)
			{
				Error::output(Error::ERR_INVALID_PASSWORD);
			}
		}
		
		//登陆成功生成user_login
		$userLogin = UserLogin::model()->find('user_id = :user_id',array(':user_id' => $userinfo->id));
		if(!$userLogin)
		{
			//不存在就创建
			$userLogin = new UserLogin();
			$userLogin->user_id = $userinfo->id;
			$userLogin->username = $name;
		}
		
		$userLogin->login_time = time();
		$userLogin->token = md5(time() . Common::getGenerateSalt());
		$userLogin->visit_client = Common::getClientType();
		$userLogin->ip = Common::getIp();
		$userLogin->save();
		$member = CJSON::decode(CJSON::encode($userinfo));
		$member['token'] = $userLogin->token;
		unset($member['password'],$member['salt']);
		//返回数据
		//如果存在头像，就返回
		if($member['avatar'])
		{
			//取图片数据
			$material = Material::model()->findByPk($member['avatar']);
			$member['avatar'] = array(
				'host' => Yii::app()->params['img_url'],
				'filepath' => $material->filepath,
				'filename' => $material->filename,
			);
		}
		Out::jsonOutput($member);
	}
	
	//退出
	public function actionLogout()
	{
		$access_token = Yii::app()->request->getParam('access_token');
		if(!$access_token)
		{
			Error::output(Error::ERR_NO_LOGIN);
		}
		
		$model = UserLogin::model()->find('token = :token',array(':token' => $access_token));
		if($model)
		{
			$model->delete();
		}
		
		//退出成功
		Out::jsonOutput(array(
			'return' => 1
		));
	}
	
	//注册
	public function actionRegister()
	{
		$name = Yii::app()->request->getParam('name');
		$password1 = Yii::app()->request->getParam('password1');
		$password2 = Yii::app()->request->getParam('password2');

		if(!$name)
		{
			Error::output(Error::ERR_NO_USER_NAME);
		}
		else if(strlen($name) > 15)
		{
			Error::output(Error::ERR_USERNAME_TOO_LONG);
		}

		if(!$password1 || !$password2)
		{
			Error::output(Error::ERR_NO_PASSWORD);
		}
		else if(strlen($password1) > 15 || strlen($password2) > 15)
		{
			Error::output(Error::ERR_PASSWORD_TOO_LONG);
		}
		else if($password1 !== $password2)
		{
			Error::output(Error::ERR_TWO_PASSWORD_NOT_SAME);
		}
		
		//判断该用户是不是已经存在了
		$_member = Members::model()->find('name=:name',array(':name' => $name));
		if($_member)
		{
			Error::output(Error::ERR_USER_HAS_EXISTS);
		}
		
		//随机长生一个干扰码
		$salt = Common::getGenerateSalt();
		$model = new Members();
		$model->name = $name;
		$model->salt = $salt;
		$model->password = md5($salt . $password1);
		$model->create_time = time();
		$model->update_time = time();
		if($model->save())
		{
			$model->order_id = $model->id;
			$model->save();
			//注册成功返回数据
			$member = CJSON::decode(CJSON::encode($model));
			//返回数据
			Out::jsonOutput($member);
		}
		else 
		{
			Error::output(Error::ERR_SAVE_FAIL);
		}
	}
}