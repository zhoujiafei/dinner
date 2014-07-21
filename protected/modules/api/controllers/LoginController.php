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
	
}