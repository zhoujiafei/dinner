<?php
//首页的界面
class IndexController extends ApiController
{
	public function actionIndex()
	{
		//获取商家信息
		$model = Shops::model()->with('image')->findAll('t.status=:status',array(':status' => 2));
		$shopData = array();
		foreach($model AS $k => $v)
		{
			$shopData[$k] = $v->attributes;
			$shopData[$k]['logo'] = $shopData[$k]['logo']?Yii::app()->params['img_url'] . $v->image->filepath . $v->image->filename:'';
		}
		Out::jsonOutput(array(
			'shops' 	=> $shopData,
			'isOnTime'  => Yii::app()->check_time->isOnTime(),
		));
	}
	
	//获取当前应用的版本
	public function actionGetVersion()
	{
		Out::jsonOutput(array(
			'app_version' => Yii::app()->params['app_version'],
		));
	}
}