<?php
/**
 * 接口基类 
 */
class ApiController extends CController
{
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