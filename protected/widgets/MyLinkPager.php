<?php
class MyLinkPager extends CLinkPager
{
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo CHtml::tag('div',array('class' => 'pagination'),implode("\n",$buttons));
		echo $this->footer;
	}
	
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		$class = intval($label)?'number':'';
		if($selected)
		{
			$class .= ' current ';
		}	
		return CHtml::link($label,$this->createPageUrl($page),array('class' => $class,'title' => $label));	
	}
}