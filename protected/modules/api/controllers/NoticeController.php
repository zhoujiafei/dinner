<?php
//首页的界面
class NoticeController extends ApiController
{
	public function actionIndex()
	{
		//取出公告数据
		$notice = Announcement::model()->findAll(array('order' => 'create_time DESC','condition' => 'status=:status','params'=>array(':status'=>2)));
		$notice = CJSON::decode(CJSON::encode($notice));
		Out::jsonOutput($notice);
	}
}