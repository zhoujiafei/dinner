<?php

class MessageController extends Controller
{
	//设置过滤器
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	//访问控制的规则
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','form'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','audit','delete','replymsg'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	//删除
	public function actionDelete($id)
	{
		$id = Yii::app()->request->getParam('id');
		if(!$id)
		{
			throw new CHttpException(404,Yii::t('没有id'));
		}
		
		$this->loadModel($id)->delete();
		$this->redirect(Yii::app()->createUrl('message/index'));
	}
	
	//回复消息
	public function actionReplyMsg()
	{
		$message_id = Yii::app()->request->getParam('message_id');
		$content = Yii::app()->request->getParam('content');
		if(!$content)
		{
			$this->errorOutput(array('errorCode' => 1,'errorText' => '回复内容不能为空'));
		}
		
		if(!$message_id)
		{
			$this->errorOutput(array('errorCode' => 2,'errorText' => '没有留言id'));
		}
		
		$model = new Reply();
		$model->message_id = $message_id;
		$model->user_id = -1;
		$model->content = $content;
		$model->create_time = time();
		if($model->save())
		{
			$this->output(array('success' => 1,'successText' => '回复成功'));
		}
		else 
		{
			$this->errorOutput(array('errorCode' => 3,'errorText' => '回复失败'));
		}
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
				case 2:$status = 1;break;
			}
			
			$model->status = $status;
			if($model->save())
			{
				$this->output(array('status' => $status,'status_text' => Yii::app()->params['message_status'][$status],'status_color' => Yii::app()->params['status_color'][$status]));
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

	//首页
	public function actionIndex()
	{
		//创建查询条件
		$criteria = new CDbCriteria();
		$criteria->order = 't.order_id DESC';
		$count=Message::model()->count($criteria);
		//构建分页
		$pages = new CPagination($count);
 		$pages->pageSize = Yii::app()->params['pagesize'];
		$pages->applyLimit($criteria);
		$model = Message::model()->with('members','shops')->findAll($criteria);
		$data = array();
		foreach($model AS $k => $v)
		{
			$data[$k] = $v->attributes;
			$data[$k]['shop_name'] = $v->shops->name;
			$data[$k]['user_name'] = $v->members->name;
			$data[$k]['create_time'] = Yii::app()->format->formatDate($v->create_time);
			$data[$k]['status_text'] = Yii::app()->params['message_status'][$v->status];
			$data[$k]['status_color'] = Yii::app()->params['status_color'][$v->status];			
		}
		//输出到前端
		$this->render('index', array(
			'data' 	=> $data,
			'pages'	=> $pages
		));
	}

	//加载模型数据
	public function loadModel($id)
	{
		$model=Message::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
