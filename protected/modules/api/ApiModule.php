<?php
//接口模块
class ApiModule extends CWebModule
{
	public $defaultController='index';
	public function init()
	{
		$this->setImport(array(
			'api.models.*',
			'api.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
