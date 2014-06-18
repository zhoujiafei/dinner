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
}