<?php

class ComplainController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','form'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	//表单页
	public function actionForm()
	{
		$id = Yii::app()->request->getParam('id');
		if($id)
		{
			$model = $this->loadModel($id);
			$data = CJSON::decode(CJSON::encode($model));
		}
		
		$this->render('_form',array(
			'data' 	=> $data,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		//创建查询条件
		$criteria = new CDbCriteria();
		$criteria->order = 't.create_time DESC';
		$count=Complain::model()->count($criteria);
		//构建分页
		$pages = new CPagination($count);
 		$pages->pageSize = Yii::app()->params['pagesize'];
		$pages->applyLimit($criteria);
		$model = Complain::model()->with('members')->findAll($criteria);
		$data = array();
		foreach($model AS $k => $v)
		{
			$data[$k] = $v->attributes;
			$data[$k]['user_name'] = $v->members->name;
			$data[$k]['create_time'] = Yii::app()->format->formatDate($v->create_time);
		}
		
		//输出到前端
		$this->render('index', array(
			'data' 	=> $data,
			'pages'	=> $pages
		));
	}

	public function loadModel($id)
	{
		$model=Complain::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}