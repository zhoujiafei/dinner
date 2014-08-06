<?php
//菜单页面
class MenuController extends ApiController
{
	public function actionIndex()
	{
		$shop_id = Yii::app()->request->getParam('shop_id');
		if(!$shop_id)
		{
			Error::output(Error::ERR_NO_SHOPID);
		}
		
		//查询出改商店的一些详细信息
		$shopData = Shops::model()->findByPk($shop_id);
		if(!$shopData)
		{
			Error::output(Error::ERR_NO_SHOPID);
		}
		$shopData = CJSON::decode(CJSON::encode($shopData));
		//根据店铺id查询出该店铺的菜单
		$menuData = Menus::model()->with('food_sort','image','shops')->findAll(array('condition' => 't.shop_id=:shop_id AND t.status=:status','params' => array(':shop_id' => $shop_id,':status' => 2)));
		$data = array();
		foreach($menuData AS $k => $v)
		{
			$data[$k] = $v->attributes;
			$data[$k]['index_pic'] = $v->index_pic?Yii::app()->params['img_url'] . $v->image->filepath . $v->image->filename:'';
			$data[$k]['sort_name'] = $v->food_sort->name;
			$data[$k]['shop_name'] = $v->shops->name;
			$data[$k]['create_time'] = Yii::app()->format->formatDate($v->create_time);
			$data[$k]['status'] = Yii::app()->params['menu_status'][$v->status];
			$data[$k]['price'] = $v->price;
		}
		
		Out::jsonOutput(array(
			'shop' => $shopData,
			'menus' => $data,
		));
	}
}