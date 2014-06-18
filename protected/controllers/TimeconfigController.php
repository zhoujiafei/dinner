<?php

class TimeConfigController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	//显示时间配置
	public function actionIndex()
	{
		$timeConfig = Config::model()->find('name=:name',array(':name' => 'dinner_time'));
		$timeConfig = CJSON::decode(CJSON::encode($timeConfig));
		$this->render('index',array('data' => $timeConfig));
	}
	
	//更新时间配置
	public function actionUpdate()
	{
		$startTime = Yii::app()->request->getParam('start_time');
		$endTime = Yii::app()->request->getParam('end_time');
		$isOpen = Yii::app()->request->getParam('is_open');
		
		if(!$startTime || !$endTime)
		{
			throw new CHttpException(404,Yii::t('yii','时间设置错误'));
		}
		
		$timeConfig = Config::model()->find('name=:name',array(':name' => 'dinner_time'));
		$timeConfig->start_time = $startTime;
		$timeConfig->end_time = $endTime;
		$timeConfig->is_open = intval($isOpen);
		if($timeConfig->save())
		{
			$this->redirect(array('index'));
		}
		else 
		{
			throw new CHttpException(404,Yii::t('yii','更新失败'));
		}
	}
}
