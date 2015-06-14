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
		$cur_password = Yii::app()->request->getParam('cur_password');//当前密码
		$new_password = Yii::app()->request->getParam('new_password');//新密码
		$comfirm_password = Yii::app()->request->getParam('comfirm_password');//确认新密码
		
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
	
	//查看历史订单（查询出所有订单包括当天的）
	public function actionHistoryOrder()
	{
		$member_id = $this->module->user['id'];
		$criteria = new CDbCriteria;
		$criteria->order = 't.create_time DESC';
		$criteria->select = '*';
		$criteria->condition = 'food_user_id=:food_user_id';
		$criteria->params = array(':food_user_id' => $member_id);

		$model = FoodOrder::model()->with('shops','food_log')->findAll($criteria);
		$orderData = array();
		$priceSum = array();//统计每月总消费
		foreach ($model AS $k => $v)
		{
			$sort = date('Y-m',$v->create_time);
			$_data = $v->attributes;
			$_data['shop_name'] = $v->shops->name;
			$_data['product_info'] = unserialize($v->product_info);
			$_data['create_order_date'] = date('Y-m-d',$v->create_time);
			$_data['create_time_text'] = date('H:i:s',$v->create_time);
			$_data['status_text'] = Yii::app()->params['order_status'][$v->status];
			if(date('Y-m-d',time()) == date('Y-m-d',$v->create_time))
			{
				$_data['is_today'] = 1;
			}
			else 
			{
				$_data['is_today'] = 0;
			}
			//订单状态日志
			$status_log = CJSON::decode(CJSON::encode($v->food_log));
			foreach ($status_log AS $kk => $vv)
			{
				$status_log[$kk]['status_text'] = Yii::app()->params['order_status'][$vv['status']];
				$status_log[$kk]['create_time'] = date('H:i:s',$vv['create_time']);
			}
			$_data['status_log'] = $status_log;
			$orderData[$sort][] = $_data;
			if(intval($v->status) == 2)
			{
				$priceSum[$sort][] = $_data['total_price'];
			}
		}
		
		//计算每月的总支出
		$outData = array();
		foreach ($orderData AS $k => $v)
		{
			$tmp = array();
			$tmp['date'] = $k;
			$tmp['data'] = $orderData[$k];
			
			if(isset($priceSum[$k]))
			{
				$tmp['total_price'] = array_sum($priceSum[$k]);
			}
			else 
			{
				$tmp['total_price'] = 0;
			}
			$outData[] = $tmp;
		}
		Out::jsonOutput($outData);
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
		if(!$message_id)
		{
			Error::output(Error::ERR_NO_MSGID);
		}
		
		if(!$reply_content)
		{
			Error::output(Error::ERR_NO_REPLY_CONTENT);
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
		//检查在不在订餐时间内
		if(!Yii::app()->check_time->isOnTime())
		{
			Error::output(Error::ERR_NOT_IN_TIME);
		}
		
		//接收传递过来的订单
		$menuInfo = Yii::app()->request->getParam('menu_info');
		$menuInfo = json_decode($menuInfo,1);
		if ($menuInfo)
		{
			$shop_id = 0;
			$totalPrice = 0;//记录总价
			$orderData = array();
			//根据传递过来的订单构造数据
			foreach ($menuInfo AS $k => $v)
			{
				$menu = Menus::model()->find('id = :id AND status = :status',array(':id' => $v['id'],':status' => 2));
				if(!$menu)
				{
					Error::output(Error::ERR_ORDER_DATA_WRONG);
				}
				
				if(!$shop_id)
				{
					$shop_id = 	$menu->shop_id;				
				}
				elseif ($menu->shop_id != $shop_id)
				{
					Error::output(Error::ERR_MENU_NOT_SAME_SHOP);
				}
				
				$orderData[] = array(
					'Id' 			=> $menu->id,//菜单id
					'Name' 			=> $menu->name,//菜名
					'Count' 		=> intval($v['nums']),//菜的数量
					'Price'			=> $menu->price,//菜的单价
					'smallTotal' 	=> $menu->price * $v['nums'],//小计
				);
				
				$totalPrice += $menu->price * $v['nums'];
			}
			
			if(!$shop_id || empty($orderData))
			{
				Error::output(Error::ERR_ORDER_DATA_WRONG);
			}
			
			//获取当前用户信息，查看用户账户余额够不够付款
			if($this->module->user['balance'] < $totalPrice && !in_array($this->module->user['id'], Yii::app()->params['allow_user_id'])) 
			{
				Error::output(Error::ERR_BALANCE_NOT_ENOUGH);
			}
			
			//构建数据
			$foodOrder = new FoodOrder();
			$foodOrder->shop_id = $shop_id;
			$foodOrder->order_number = date('YmdHis',time()) . Common::getRandNums(6);
			$foodOrder->food_user_id = $this->module->user['id'];
			$foodOrder->total_price = $totalPrice;
			$foodOrder->create_time = time();
			$foodOrder->product_info = serialize($orderData);
			
			if($foodOrder->save())
			{
				//记录订单动态
				$foodOrderLog = new FoodOrderLog();
				$foodOrderLog->food_order_id = $foodOrder->id;
				$foodOrderLog->create_time = time();
				$foodOrderLog->save();
				Out::jsonOutput(array('return' => 1));//下单成功
			}
			else 
			{
				Error::output(Error::ERR_SAVE_FAIL);
			}
		}
	}
	
	//修改头像
	public function actionModifyAvatar()
	{
		//处理图片
		if($_FILES['avatar'] && !$_FILES['avatar']['error'])
		{
			$imgInfo = Yii::app()->material->upload('avatar');
			if($imgInfo)
			{
				//更新到用户表里面
				$member = Members::model()->findByPk($this->module->user['id']);
				$member->avatar = $imgInfo['id'];
				if($member->save())
				{
					Out::jsonOutput(array('return' => 1));//留言成功
				}
				else 
				{
					Error::output(Error::ERR_UPLOAD_FAIL);
				}
			}
			else 
			{
				Error::output(Error::ERR_UPLOAD_FAIL);
			}
		}
		else 
		{
			Error::output(Error::ERR_NO_SELECT_FILE);
		}
	}
}