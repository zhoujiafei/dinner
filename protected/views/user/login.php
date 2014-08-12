<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/invalid.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body id="login">
<div id="login-wrapper" class="png_bg">
  <div id="login-top">
    <h1>订餐系统</h1>
    <!-- Logo (221px width) -->
    <a href="#"><img id="logo" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/logo.png"  /></a> 
    </div>
  <!-- End #logn-top -->
  <div id="login-content">
    <form action="<?php echo Yii::app()->createUrl('user/doLogin'); ?>" method="post" name="login">
      <div class="notification information png_bg">
      </div>
      <p>
        <label>用户名</label>
        <input class="text-input" type="text" name="LoginForm[username]" />
      </p>
      <div class="clear"></div>
      <p>
        <label>密码</label>
        <input class="text-input" type="password" name="LoginForm[password]" />
      </p>
      <div class="clear"></div>
      <p id="remember-password">
        <input type="checkbox" name="LoginForm[rememberMe]" />
        记住我</p>
      <div class="clear"></div>
      <p>
        <input class="button" type="submit" name="submit" value="登陆" />
      </p>
    </form>
  </div>
  <!-- End #login-content -->
</div>
<!-- End #login-wrapper -->
</body>
</html>
