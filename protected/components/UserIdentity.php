<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		//获取库里面用户信息
		$userinfo = User::model()->find('username=:username',array(':username' => $this->username));
		if(!$userinfo)
		{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else 
		{
			$_password = md5($userinfo->salt . $this->password);
			if($_password != $userinfo->password)
			{
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			else
			{
				$this->errorCode=self::ERROR_NONE;
				//登录成功之后保持后台用户信息
				 $this->setState('admin_userinfo',array(
				 			'id' 	   => $userinfo->id,
				 			'username' => $userinfo->username,
				 ));  
			}
		}
		return !$this->errorCode;
	}
}