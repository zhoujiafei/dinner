<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'订餐系统',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helps.*',	
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'api',//用于客户端访问的接口
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			//'loginUrl'=>array('user/login'),
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dinner',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
			'tablePrefix' => 'liv_',
		),
		
		'errorHandler'=>array(
			'errorAction'=>'error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
				
			),
		),
		'smarty'=>array(                                               
			'class' => 'application.extensions.smarty.CSmarty',                       
		),
		'curl'=>array(                                               
			'class' => 'application.extensions.Curl',                       
		),
		'material'=>array(                                               
			'class' => 'application.extensions.MaterialUpload',
			'dirPath' => 'application.uploads',              
		),
		'check_time'=>array(                                               
			'class' => 'application.extensions.CheckTime',
		),
		'record'=>array(                                               
			'class' => 'application.extensions.Record',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		//允许账户余额不足可以下单的用户id
		'allow_user_id' => array(67),
		'record_money' => array(
			0 => '扣款',
			1 => '充值',
		),
		'status_color' => array(
			1 => 'red',
			2 => 'blue',
			3 => 'green',
			4 => '#EA0CF3',
		),
		//会员充值金额配置
		'member_recharge' => array(
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 10,
			7 => 20,
			8 => 30,
			9 => 40,
			10 => 50,
			11 => 60,
			12 => 70,
			13 => 80,
			14 => 90,
			15 => 100,
			16 => 150,
			17 => 200,
		),
		//留言状态
		'message_status' => array(
			1 => '已审核',
			2 => '被打回',
		),
		//用户状态
		'member_status' => array(
			1 => '好同志',
			2 => '不良公民',
		),
		//公告状态
		'notice_status' => array(
			1 => '待发布',
			2 => '已发布',
			3 => '被打回',
		),
		//商家的状态
		'shop_status' => array(
			1 => '待上市',
			2 => '已上市',
			3 => '被下市',
		),
		//菜的状态
		'menu_status' => array(
			1 => '待上架',
			2 => '已上架',
			3 => '被下架',
		),
		'member_sex' => array(
			0 => '男',
			1 => '女',
		),
		//订单状态
		'order_status' => array(
			1 => '待付款',
			2 => '已付款',
			3 => '用户取消订单',
			4 => '妹子取消订单',
		),
		'homeIndexPic' => 'home.jpg',
		'material_path' => 'application.uploads',
		'img_url' => 'http://localhost/dinner/protected/uploads/',
		'pagesize' => 10,//配置后台分页显示的个数
		'menu' => array(
						   	array(
						        'zh_name'       => '首页',
						        'en_name'       => 'home',
						        'link'          => '#',
						        'child'  		=>  array(
												   			array(
													             'zh_name'       => '首页',
														         'en_name'       => 'home',
														         'link'          => 'index', 
												   				),
						       							 ),  
						    ),
						    array(
						        'zh_name'       => '订餐',
						        'en_name'       => 'menu_manger',
						        'link'          => '#',    
						        'child'  		=>  array(
						    								array(
														        'zh_name'       => '菜单管理',
														        'en_name'       => 'menus_manger',
														        'link'          => 'menus',  
						    								), 
						    								/*
						    								array(
														        'zh_name'       => '菜系管理',
														        'en_name'       => 'menu_sort_manger',
														        'link'          => 'foodsort',  
						    								), 
						    								*/
						    								array(
														        'zh_name'       => '用户管理',
														        'en_name'       => 'members_mamger',
														        'link'          => 'members',  
						    								),
						    								array(
														        'zh_name'       => '商家管理',
														        'en_name'       => 'shops_manger',
														        'link'          => 'shops',  
						    								), 
						    								array(
														        'zh_name'       => '订单管理',
														        'en_name'       => 'order_manger',
														        'link'          => 'foodorder',  
						    								),
						    								array(
														        'zh_name'       => '公告管理',
														        'en_name'       => 'announcement_manger',
														        'link'          => 'announcement',  
						    								),
						    								array(
														        'zh_name'       => '留言管理',
														        'en_name'       => 'message_manger',
														        'link'          => 'message',
						    								),
												        ),            
						    ),
						    array(
						        'zh_name'       => '系统设置',
						        'en_name'       => 'system_seeting',
						        'link'          => '#',    
						        'child'  		=>  array(
						    								array(
														        'zh_name'       => '素材管理',
														        'en_name'       => 'material_manger',
														        'link'          => 'material',  
						    								), 
						    								array(
														        'zh_name'       => '点餐时间',
														        'en_name'       => 'dinnertime_manger',
														        'link'          => 'timeconfig',  
						    								), 
												        ),            
						    ),
						),
	
	),
);