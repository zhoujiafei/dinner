<?php                                                                     
require_once(Yii::getPathOfAlias('application.extensions.smarty.libs').DIRECTORY_SEPARATOR.'Smarty.class.php');                                                          
define('SMARTY_VIEW_DIR', Yii::getPathOfAlias('application.views.smarty'));                
class CSmarty extends Smarty
{                                                 
	const DIR_SEP = DIRECTORY_SEPARATOR;                                 
	public function __construct()
	{                                                
		parent::__construct();                                                   
		$this->template_dir = SMARTY_VIEW_DIR.self::DIR_SEP.'templates';          
		$this->compile_dir = SMARTY_VIEW_DIR.self::DIR_SEP.'template_c';          
		$this->config_dir = SMARTY_VIEW_DIR.self::DIR_SEP.'config';               
		$this->cache_dir = SMARTY_VIEW_DIR.self::DIR_SEP.'cache';            
		$this->left_delimiter = '{@';                                        
		$this->right_delimiter = '@}';                                          
	}     
	                                                               
	public function init()
	{
		                                                        
	}                                                                       
}                                                                      
?>                              