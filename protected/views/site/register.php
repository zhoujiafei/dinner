<script type="text/javascript">
$(function(){
	$('#RegistIn').click(function(){
		var name = $('#NickName').val();
		var password1 = $('#PassWord1').val();
		var password2 = $('#PassWord2').val();

		$('.logTips').hide();

		if(!name)
		{
			$('#name_tip').text('姓名不能为空').show();
			return;
		}
		else if(name.length > 15)
		{
			$('#name_tip').text('姓名太长了').show();
			return;
		}

		if(!password1 || !password2)
		{
			$('#ps2_tip').text('密码不能为空').show();
			return;
		}
		else if(password1.length > 15 || password2.length > 15)
		{
			$('#ps2_tip').text('您设定的密码太长了，不能超过15个字符').show();
			return;
		}
		else if(password1 !== password2)
		{
			$('#ps2_tip').text('两次密码不相等').show();		
			return;
		}

		var url = $('#submit_url').val();
		$.ajax({
			type:'POST',
			url:url,
			dataType: "json",
			data:{name:name,password1:password1,password2:password2},
			success:function(data){
				if(data.errorCode)
				{
					$('#regist_result').show().text(data.errorText);
				}
				else if(data.success)
				{
					alert('注册成功');
					window.location.href=$('#login_url').val();
				}
			}
		})
	})
})
</script>
<div class="login shadow" style="padding-bottom: 20px;">
                <div class="login-title">
                    <h3>
                        用户注册</h3>
                </div>
                <ul>
                	<li class="login_name">
                        <label>姓名：</label>
                        <input name="name" type="text" maxlength="20" id="NickName">
                        <p class="logTips" id="name_tip" style="display: none;"></p>
                    </li>
                    <li class="login_password">
                        <label>密码：</label>
                        <input name="password1" type="password" maxlength="15" id="PassWord1">
                        <p class="logTips"  id="ps1_tip"  style="display: none;"></p>
                    </li>
                    <li class="sure_password">
                        <label>
                            确认密码：</label>
                        <input name="password2" type="password" maxlength="15" id="PassWord2">
                        <p class="logTips" id="ps2_tip" style="display: none;"></p>
                    </li>
                    
                    <li class="regist_btn">
                        <input type="submit" name="RegistIn" value="注册" id="RegistIn">
                        <span id="regist_result"></span>
                        <input type="hidden" id="submit_url" value="<?php echo Yii::app()->createUrl('site/doregister');?>">
                        <input type="hidden" id="login_url" value="<?php echo Yii::app()->createUrl('site/login');?>">
                    </li>
                </ul>
                <div class="member">
                    <span>已有开吃吧帐号？</span> <a href="<?php echo Yii::app()->createUrl('site/login')?>">请登录</a>
                </div>
</div>