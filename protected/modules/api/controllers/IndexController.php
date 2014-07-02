<?php

class IndexController extends ApiController
{
	public function actionIndex()
	{
		$this->errorOutput(array('return' => 1));
	}
}