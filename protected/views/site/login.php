<script type="text/javascript">
$(function(){
	$('#LoginIn').click(function(){
		var name = $('#name').val();
		var password = $('#password').val();
		$.ajax({
		   type: "POST",
		   url: "<?php echo Yii::app()->createUrl('site/dologin');?>",
		   data: "name="+name+"&password="+password,
		   success: function(msg)
		   {
				var obj = eval('('+msg+')');		     	
				if(obj.error == 1)
				{
					alert('用户名不能为空');
					return;
				}

				if(obj.error == 2)
				{
					alert('密码不能为空');
					return;
				}

				if(obj.error == 3)
				{
					alert('用户名或者密码错误');
					return;
				}

				window.location.href="<?php echo Yii::app()->request->urlReferrer;?>";
				
		   }
		});
	})
})
</script>
<div class="login shadow">
                <div class="login-title">
                    <h3>
                        用户登录</h3>
                </div>
                <ul>
                    <li class="login_mail">
                        <label for="Account">
                            用户名：</label>
                        <input type="text" name="name" id="name" />
                    </li>
                    <li class="login_password">
                        <label for="Password">
                            密码：</label>
                        <input type="password" id="password" name="password" >
                    </li>
                    <li class="login_btn">
                        <input type="submit" id="LoginIn" value="登录" >
                        <p>
                            <a href="#">忘记密码？</a></p>
                    </li>
                </ul>
                <div class="member">
                    <span>还没有开吃吧帐号？</span><a href="<?php echo Yii::app()->createUrl('site/register')?>">注册</a>
                </div>
</div>