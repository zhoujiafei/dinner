<?php
define('NO_LOGIN',true);
class UserController extends Controller
{
	public $defaultAction='login';
	//登录的首页
	public function actionLogin()
	{
		if(isset(Yii::app()->user->admin_userinfo))
		{
			$this->redirect(Yii::app()->createUrl('index'));
		}
		else 
		{
			$this->renderPartial('login');
		}
	}
	
	//执行登录
	public function actionDoLogin()
	{
		$model=new LoginForm();
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            if($model->validate() && $model->login())//验证成功跳到后台首页
            {
                $this->redirect(Yii::app()->createUrl('index'));
            }
            else 
            {
            	$this->redirect(Yii::app()->createUrl('user/login'));
            }
        }
	}
	
	//后台退出登陆
	public function actionLogout()
	{
		if(isset(Yii::app()->user->admin_userinfo))
		{
			unset(Yii::app()->user->admin_userinfo);
		}
		
		$this->redirect(Yii::app()->createUrl('user/login'));
	}
}
?>