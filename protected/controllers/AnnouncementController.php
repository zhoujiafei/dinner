<?php

class AnnouncementController extends Controller
{
	//过滤
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	//访问控制
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','form'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','audit','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	//创建公告
	public function actionCreate()
	{
		$model=new Announcement;
		if(isset($_POST['Announcement']))
		{
			$model->attributes=$_POST['Announcement'];
			$model->create_time = time();
			$model->update_time = time();
			if($model->save())
			{
				$model->order_id = $model->id;
				$model->save();
				$this->redirect(array('index'));
			}
			else 
			{
				throw new CHttpException(404,Yii::t('yii','创建失败'));
			}
		}
		else
		{
			throw new CHttpException(404,'no post param');
		}
	}

	//更新公告
	public function actionUpdate()
	{
		$id = Yii::app()->request->getParam('id');
		if(!isset($id))
		{
			throw new CHttpException(404,'param id is not exists');
		}
		
		$model=$this->loadModel($id);
		if(isset($_POST['Announcement']))
		{
			$model->attributes=$_POST['Announcement'];
			if($model->save())
			{
				$this->redirect(array('Announcement/index'));
			}
			else
			{
				throw new CHttpException(404,Yii::t('yii','更新失败'));
			}
		}
		else
		{
			throw new CHttpException(404,'no post param');
		}
	}
	
	//表单页
	public function actionForm()
	{
		$id = Yii::app()->request->getParam('id');
		if($id)
		{
			$model = $this->loadModel($id);
			$model = CJSON::decode(CJSON::encode($model));
		}
		
		$this->render('_form',array(
			'data' => $model,
		));
	}

	//删除公告
	public function actionDelete()
	{
		$id = Yii::app()->request->getParam('id');
		if(!$id)
		{
			throw new CHttpException(404,Yii::t('没有id'));
		}
		
		$this->loadModel($id)->delete();
		$this->redirect(Yii::app()->createUrl('announcement/index'));
	}
	
	//审核
	public function actionAudit()
	{
		//审核设定成只能ajax访问
		if(Yii::app()->request->isAjaxRequest)
		{
			$id = Yii::app()->request->getParam('id');
			if(!$id)
			{
				$this->output(array('errorCode' => 1,'errorText' => '没有id'));
			}
			
			//查询出原来的状态
			$model = $this->loadModel($id);
			switch (intval($model->status))
			{
				case 1:$status = 2;break;
				case 2:$status = 3;break;
				case 3:$status = 2;break;
			}
			
			$model->status = $status;
			if($model->save())
			{
				$this->output(array('status' => $status,'status_text' => Yii::app()->params['notice_status'][$status],'status_color' => Yii::app()->params['status_color'][$status]));
			}
			else 
			{
				$this->output(array('errorCode' => 1,'errorText' => '审核失败'));
			}
		}
		else 
		{
			throw new CHttpException(404,Yii::t('yii','非法访问'));
		}		
	}

	//列表显示
	public function actionIndex()
	{
		//创建查询条件
		$criteria = new CDbCriteria();
		$criteria->order = 'order_id DESC';
		$count=Announcement::model()->count($criteria);
		//构建分页
		$pages = new CPagination($count);
 		$pages->pageSize = Yii::app()->params['pagesize'];
		$pages->applyLimit($criteria);
		$model = Announcement::model()->findAll($criteria);
		$data = array();
		foreach($model AS $k => $v)
		{
			$data[$k] = $v->attributes;
			$data[$k]['create_time'] = Yii::app()->format->formatDate($v->create_time);
			$data[$k]['status_text'] = Yii::app()->params['notice_status'][$v->status];
			$data[$k]['status_color'] = Yii::app()->params['status_color'][$v->status];				
		}
		//输出到前端
		$this->render('index', array(
			'data' 	=> $data,
			'pages'	=> $pages
		));
	}
	
	//加载模型
	public function loadModel($id)
	{
		$model=Announcement::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
