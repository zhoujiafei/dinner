<?php
//用户中心
define('NEED_LOGIN',true);//需要登陆
class CenterController extends ApiController
{
	//显示用户的基本信息
	public function actionIndex()
	{
		Out::jsonOutput($this->module->user);//返回用户信息
	}
	
	//修改密码
	public function actionModifyPassword()
	{
		$cur_password = Yii::app()->request->getPost('cur_password');//当前密码
		$new_password = Yii::app()->request->getPost('new_password');//新密码
		$comfirm_password = Yii::app()->request->getPost('comfirm_password');//确认新密码
		
		if(!$cur_password)
		{
			Error::output(Error::ERR_NO_PASSWORD);
		}

		if(!$new_password || !$comfirm_password)
		{
			Error::output(Error::ERR_NO_PASSWORD);
		}
		else if(strlen($new_password) > 15 || strlen($comfirm_password) > 15)
		{
			Error::output(Error::ERR_PASSWORD_TOO_LONG);
		}
		else if($new_password !== $comfirm_password)
		{
			Error::output(Error::ERR_TWO_PASSWORD_NOT_SAME);
		}
		
		//判断该用户是不是已经存在了
		$_member = Members::model()->find('id=:id',array(':id' => $this->module->user['id']));
		if(!$_member)
		{
			Error::output(Error::ERR_NO_USER);
		}
		else if(md5($_member->salt . $cur_password) != $_member->password)
		{
			Error::output(Error::ERR_INVALID_ORI_PASSWORD);
		}
		
		//随机长生一个干扰码
		$salt = Common::getGenerateSalt();
		$_member->salt = $salt;
		$_member->password = md5($salt . $new_password);
		$_member->update_time = time();
		if($_member->save())
		{
			Out::jsonOutput(array('return' => 1));//修改成功
		}
		else 
		{
			Error::output(Error::ERR_SAVE_FAIL);
		}
	}
	
	//查看今日订单
	public function actionTodayOrder()
	{
		$member_id = $this->module->user['id'];
		$criteria = new CDbCriteria;
		$criteria->order = 't.create_time DESC';
		$criteria->select = '*';
		$today = strtotime(date('Y-m-d',time()));
		$criteria->condition = 'food_user_id=:food_user_id AND t.create_time > ' . $today . ' AND t.create_time < ' . ($today + 3600 * 24);
		$criteria->params = array(':food_user_id' => $member_id);

		$model = FoodOrder::model()->with('shops','food_log')->findAll($criteria);
		$orderData = array();
		foreach ($model AS $k => $v)
		{
			$orderData[$k] = $v->attributes;
			$orderData[$k]['shop_name'] = $v->shops->name;
			$orderData[$k]['product_info'] = unserialize($v->product_info);
			$orderData[$k]['create_order_date'] = date('Y-m-d',$v->create_time);
			$orderData[$k]['create_time'] = date('H:i:s',$v->create_time);
			$orderData[$k]['status_text'] = Yii::app()->params['order_status'][$v->status];
			//订单状态日志
			$status_log = CJSON::decode(CJSON::encode($v->food_log));
			foreach ($status_log AS $kk => $vv)
			{
				$status_log[$kk]['status_text'] = Yii::app()->params['order_status'][$vv['status']];
				$status_log[$kk]['create_time'] = date('H:i:s',$vv['create_time']);
			}
			$orderData[$k]['status_log'] = $status_log;
		}
		
		Out::jsonOutput($orderData);
	}
	
	//查看历史订单
	public function actionHistoryOrder()
	{
		$member_id = $this->module->user['id'];
		$criteria = new CDbCriteria;
		$criteria->order = 't.create_time DESC';
		$criteria->select = '*';
		$criteria->condition = 'food_user_id=:food_user_id AND t.create_time < ' . strtotime(date('Y-m-d',time()));
		$criteria->params = array(':food_user_id' => $member_id);

		$model = FoodOrder::model()->with('shops','food_log')->findAll($criteria);
		$orderData = array();
		foreach ($model AS $k => $v)
		{
			$orderData[$k] = $v->attributes;
			$orderData[$k]['shop_name'] = $v->shops->name;
			$orderData[$k]['product_info'] = unserialize($v->product_info);
			$orderData[$k]['create_order_date'] = date('Y-m-d',$v->create_time);
			$orderData[$k]['create_time'] = date('H:i:s',$v->create_time);
			$orderData[$k]['status_text'] = Yii::app()->params['order_status'][$v->status];
			//订单状态日志
			$status_log = CJSON::decode(CJSON::encode($v->food_log));
			foreach ($status_log AS $kk => $vv)
			{
				$status_log[$kk]['status_text'] = Yii::app()->params['order_status'][$vv['status']];
				$status_log[$kk]['create_time'] = date('H:i:s',$vv['create_time']);
			}
			$orderData[$k]['status_log'] = $status_log;
		}
		Out::jsonOutput($orderData);
	}
	
	//用户取消订单
	public function actionCancelOrder()
	{
		$food_order_id = Yii::app()->request->getParam('id');
		if(!$food_order_id)
		{
			Error::output(Error::ERR_NO_ORDERID);
		}
		
		$orderInfo = FoodOrder::model()->find('id=:id AND food_user_id=:food_user_id',array(':id' => $food_order_id,':food_user_id' => $this->module->user['id']));
		if(!$orderInfo)
		{
			Error::output(Error::ERR_NO_ORDER);
		}
		else if($orderInfo->status != 1)
		{
			Error::output(Error::ERR_ORDER_CANNOT_CANCEL);
		}
		
		$orderInfo->status = 3;
		if($orderInfo->save())
		{
			//创建一条订单日志
			$foodOrderLog = new FoodOrderLog();
			$foodOrderLog->food_order_id = $food_order_id;
			$foodOrderLog->status = $orderInfo->status;
			$foodOrderLog->create_time = time();
			$foodOrderLog->save();
			Out::jsonOutput(array('return' => 1));//取消成功
		}
		else 
		{
			Error::output(Error::ERR_SAVE_FAIL);
		}
	}
	
	//用户给餐厅留言
	public function actionLeaveMessage()
	{
		$content = Yii::app()->request->getParam('content');
		$shop_id = Yii::app()->request->getParam('shop_id');
		$user_id = $this->module->user['id'];
		if(!$shop_id)
		{
			Error::output(Error::ERR_NO_SHOPID);
		}
		
		if(!$content)
		{
			Error::output(Error::ERR_NO_MSG_CONTENT);
		}
		
		$model = new Message();
		$model->shop_id = $shop_id;
		$model->user_id = $user_id;
		$model->content = $content;
		$model->create_time = time();
		if($model->save())
		{
			$model->order_id = $model->id;
			if($model->save())
			{
				Out::jsonOutput(array('return' => 1));//留言成功
			}
			else 
			{
				Error::output(Error::ERR_SAVE_FAIL);
			}
		}
		else 
		{
			Error::output(Error::ERR_SAVE_FAIL);
		}
	}
	
	//用户回复留言
	public function actionReplyMessage()
	{
		$message_id = Yii::app()->request->getParam('reply_id');
		$reply_content = Yii::app()->request->getParam('reply_content');
		$user_id = $this->module->user['id'];
		if(!$reply_content)
		{
			Error::output(Error::ERR_NO_REPLY_CONTENT);
		}
		
		if(!$message_id)
		{
			Error::output(Error::ERR_NO_MSGID);
		}
		
		$model = new Reply();
		$model->message_id = $message_id;
		$model->user_id = $user_id;
		$model->content = $reply_content;
		$model->create_time = time();
		if($model->save())
		{
			Out::jsonOutput(array('return' => 1));//留言成功
		}
		else 
		{
			Error::output(Error::ERR_SAVE_FAIL);
		}
	}
	
	//用户下单接口
	public function actionConfirmOrder()
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