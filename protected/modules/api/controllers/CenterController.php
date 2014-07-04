<?php
//用户中心
define('NEED_LOGIN',true);//需要登陆
class CenterController extends ApiController
{
	public function actionIndex()
	{
		$user = $this->module->user;
		Out::jsonOutput($user);//返回用户信息
	}
}