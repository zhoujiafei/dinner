<?php
//获取某个餐厅留言
class MessageController extends ApiController
{
	public function actionIndex()
	{
		$shop_id = Yii::app()->request->getParam('shop_id');
		if(!$shop_id)
		{
			Error::output(Error::ERR_NO_SHOPID);
		}
		
		//获取该店的留言
		$criteria = new CDbCriteria();
		$criteria->order = 't.order_id DESC';
		$criteria->condition = 't.shop_id=:shop_id AND t.status=:status';
		$criteria->params = array(':shop_id' => $shop_id,':status' => 1);
		
		$messageMode = Message::model()->with('members','shops','replys')->findAll($criteria);
		$message = array();
		foreach($messageMode AS $k => $v)
		{
			$message[$k] = $v->attributes;
			$message[$k]['shop_name'] = $v->shops->name;
			$message[$k]['user_name'] = $v->members->name;
			$message[$k]['create_time'] = date('Y-m-d H:i:s',$v->create_time);
			$message[$k]['status_text'] = Yii::app()->params['message_status'][$v->status];
			$message[$k]['status_color'] = Yii::app()->params['status_color'][$v->status];
			
			$_replys = Reply::model()->with('members')->findAll(array(
					'condition' => 'message_id=:message_id',
					'params'	=> array(':message_id' => $v->id),
			));
			
			if(!empty($_replys))
			{
				foreach ($_replys AS $kk => $vv)
				{
					$message[$k]['replys'][$kk] = $vv->attributes;
					$message[$k]['replys'][$kk]['create_time'] 	= date('Y-m-d H:i:s',$vv->create_time);
					$message[$k]['replys'][$kk]['user_name'] 	= ($vv->user_id == -1)?'前台妹子说':$vv->members->name;
				}
			}
		}
		Out::jsonOutput($message);
	}
}