<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/admin';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	//动作执行之前判断登录的状态
	protected function beforeAction($action)
	{
		//如果未登录跳转到登录页
		if(!isset(Yii::app()->user->admin_userinfo) && (!defined('NO_LOGIN') || !NO_LOGIN))
		{
			$this->redirect(Yii::app()->createUrl('user/login'));
		}
		return true;
	}
	
	/*****************************整合smarty的两个操作*************************/
	public function assign($name,$value)
	{
		Yii::app()->smarty->assign($name,$value);
	}
	
	public function display($tpl)
	{
		Yii::app()->smarty->display($tpl);
	}
	/*****************************整合smarty的两个操作*************************/
	
	//输出错误信息
	protected function output($data = array())
	{
		echo json_encode($data);
		exit();
	}
	
	//输出错误信息
	protected function errorOutput($data = array())
	{
		echo json_encode($data);
		exit();
	}
}