<?php
class Error
{
	const ERR_UNKNOW = -1;
	const ERR_NO_ACCESS_TOKEN = 40001;
	const ERR_NO_LOGIN = 40002;
	const ERR_NO_USER_NAME = 40003;
	const ERR_NO_PASSWORD = 40004;
	const ERR_NO_USER = 40005;
	const ERR_INVALID_PASSWORD = 40006;
	const ERR_NO_SHOPID = 40007;
	const ERR_NO_SHOP = 40008;
	
	public static function output($errorCode = '')
	{
		$errorMsg = self::getErrorInfo();
		if(!isset($errorMsg[$errorCode]))
		{
			$errorCode = self::ERR_UNKNOW;
		}
		
		$error = array(
			'errorCode' => $errorCode,
			'errorText' => $errorMsg[$errorCode]
		);
		
		header('Content-Type: text/plain');
        echo json_encode($error);
        exit;
	}
	
	public static function getErrorInfo()
	{
		return array(
			self::ERR_UNKNOW 			=> '未知错误',
			self::ERR_NO_ACCESS_TOKEN 	=> '没有access_token',
			self::ERR_NO_LOGIN 			=> '未登录',
			self::ERR_NO_USER_NAME 		=> '用户名不能为空',
			self::ERR_NO_PASSWORD 		=> '密码不能为空',
			self::ERR_NO_USER 			=> '用户不存在',
			self::ERR_INVALID_PASSWORD 	=> '密码不合法',
			self::ERR_NO_SHOPID 		=> '没有商店id',
			self::ERR_NO_SHOP 			=> '商店不存在',
		);
	}
}