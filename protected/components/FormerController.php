<?php

//前端控制器
class FormerController extends CController
{
	public $layout='//layouts/site';
	
	//输出错误信息
	protected function errorOutput($data = array())
	{
		echo json_encode($data);
		exit();
	} 
	
	//输出信息
	protected function output($data = array())
	{
		echo json_encode($data);
		exit();
	} 
}