<?php
class Common 
{
	/**
	 * 生成指定长度的随机数
	 **/
	public static function getRandNums($length = 5)
	{
		$randstr = '0123456789';
		$rlength = strlen($randstr);
		$salt = '';
		for ($i = 0; $i < $length; $i++)
		{
			$n = mt_rand(0, ($rlength-1));
			if(!$randstr[$n] && !$i)
			{
			 $randstr[$n] = '3';
			}
			$salt .= $randstr[$n];
		}
		return $salt;
	}
	
	/**
	 * 生成用户加密干扰码
	 *
	 * @param intager $length 干扰码长度
	 */
	public static function getGenerateSalt($length = 5)
	{
		$randstr = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		$rlength = strlen($randstr);
		$salt = '';
		for ($i = 0; $i < $length; $i++)
		{
			$n = mt_rand(0, $rlength);
			$salt .= $randstr[$n];
		}
		return $salt;
	}
	
	//获取ip
	public static function getIp()
	{
		if ($_SERVER['HTTP_CLIENT_IP'])
		{
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif ($_SERVER['HTTP_X_FORWARDED_FOR'] && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
		{
			foreach ($matches[0] AS $realip) 
			{
				if (!preg_match("#^(10|172\.16|192\.168)\.#", $realip)) 
				{
					break;
				}
			}
		}
		elseif ($_SERVER['HTTP_FROM'])
		{
			$realip = $_SERVER['HTTP_FROM'];
		}
		elseif ($_SERVER['HTTP_X_REAL_IP'])
		{
			$realip = $_SERVER['HTTP_X_REAL_IP'];
		}
		else 
		{
			$realip = $_SERVER['REMOTE_ADDR'];
		}
		
		if (!self::_checkIp($realip))
		{
			$realip = '';
		}
		return $realip;
	}
	
	//检测ip合法性私有方法
	private static function _checkIp($ipaddres = '')
	{
		$preg="/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
		if(preg_match($preg,$ipaddres))
		{
			return true;
		}
		return false;
	}
	
	/**
	 * 获取客户端系统类型
	 *
	 * @return 1:ios 2:android 3:其他（电脑）
	 */
	public static function getClientType()
	{
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$is_iphone = (strpos($agent, 'iphone')) ? true : false;
		$is_ipad = (strpos($agent, 'ipad')) ? true : false;
		$is_ipod = (strpos($agent, 'ipod')) ? true : false;
		$is_android = (strpos($agent, 'android')) ? true : false;
		if($is_iphone || $is_ipad || $is_ipod)
		{
			return 1;
		}
		else if($is_android)
		{
			return 2;
		}
		else 
		{
			return 3;
		}
	}
}