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
	const ERR_TWO_PASSWORD_NOT_SAME = 40009;
	const ERR_PASSWORD_TOO_LONG = 50001;
	const ERR_INVALID_ORI_PASSWORD = 50002;
	const ERR_SAVE_FAIL = 50003;
	const ERR_NO_ORDERID = 50004;
	const ERR_NO_ORDER = 50005;
	const ERR_ORDER_CANNOT_CANCEL = 50006;
	const ERR_NO_MSG_CONTENT = 50007;
	const ERR_NO_MSGID = 50008;
	const ERR_NO_REPLY_CONTENT = 50009;
	const ERR_ORDER_DATA_WRONG = 60001;
	const ERR_MENU_NOT_SAME_SHOP = 60002;
	const ERR_BALANCE_NOT_ENOUGH = 60003;
	const ERR_NOT_IN_TIME = 60004;
	const ERR_USERNAME_TOO_LONG = 60005;
	const ERR_USER_HAS_EXISTS = 60006;
	const ERR_NO_SELECT_FILE = 60007;
	const ERR_UPLOAD_FAIL = 60008;

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
			self::ERR_UNKNOW 				=> '未知错误',
			self::ERR_NO_ACCESS_TOKEN 		=> '没有access_token',
			self::ERR_NO_LOGIN 				=> '未登录',
			self::ERR_NO_USER_NAME 			=> '用户名不能为空',
			self::ERR_NO_PASSWORD 			=> '密码不能为空',
			self::ERR_NO_USER 				=> '用户不存在',
			self::ERR_INVALID_PASSWORD 		=> '密码不合法',
			self::ERR_NO_SHOPID 			=> '没有商店id',
			self::ERR_NO_SHOP 				=> '商店不存在',
			self::ERR_TWO_PASSWORD_NOT_SAME => '两次密码不相同',
			self::ERR_PASSWORD_TOO_LONG 	=> '设置的密码过长',
			self::ERR_INVALID_ORI_PASSWORD 	=> '原密码不合法',
			self::ERR_SAVE_FAIL 			=> '保存失败',
			self::ERR_NO_ORDERID 			=> '没有订单id',
			self::ERR_NO_ORDER 				=> '订单不存在',
			self::ERR_ORDER_CANNOT_CANCEL 	=> '该订单不能被取消',
			self::ERR_NO_MSG_CONTENT 		=> '没有留言内容',
			self::ERR_NO_MSGID 				=> '没有留言ID',
			self::ERR_NO_REPLY_CONTENT 		=> '没有回复内容',
			self::ERR_ORDER_DATA_WRONG 		=> '订单数据有误',
			self::ERR_MENU_NOT_SAME_SHOP 	=> '您提交的订单中的菜不属于同一家餐厅',
			self::ERR_BALANCE_NOT_ENOUGH 	=> '余额不足',
			self::ERR_NOT_IN_TIME 			=> '不在订餐时间内',			
			self::ERR_USERNAME_TOO_LONG 	=> '用户名过长',	
			self::ERR_USER_HAS_EXISTS 		=> '用户已经存在',	
			self::ERR_NO_SELECT_FILE 		=> '未选择上传文件',	
			self::ERR_UPLOAD_FAIL 			=> '上传失败',
		);
	}
}