<?php
//记录扣款打款日志
class Record extends CComponent
{
	public function init()
	{
		
	}
	
	public function record($user_id = 0,$money = 0,$type = 0)
	{
		if(!$user_id)
		{
			return false;
		}
		
		$model = new RecordMoney();
		$model->attributes = array(
			'user_id' 		=> $user_id,
			'type' 			=> $type,
			'money' 		=> $money,
			'create_time' 	=> time(),
		);
		
		if($model->save())
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
}