<?php
class CMenuList extends CWidget
{
	public function init() 
	{ 
		 
    }
    
    public function run() 
    {
    	  $menu = Yii::app()->params['menu'];
    	  $this->render('left_menu', array('_menus'=>$menu));
    }
}