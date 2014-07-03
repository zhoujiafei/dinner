<?php
//下单接口
define('NEED_LOGIN',true);//需要登陆
class OrderController extends ApiController
{
	public function actionIndex()
	{
		//接收传递过来的菜单id
		$menuInfo = Yii::app()->request->getParam('menu_info');
		$menuInfo = json_decode($menuInfo,1);
		if ($menuInfo)
		{
			Out::jsonOutput($menuInfo);
		}
	}
}