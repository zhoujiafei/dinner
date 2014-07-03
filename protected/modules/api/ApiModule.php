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
			'api.extensions.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
