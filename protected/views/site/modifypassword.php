<script type="text/javascript">
$(function(){
	$('#btnSubmit').click(function(){
		var cur_password = $('#curPassword').val();
		var new_password = $('#newPassword').val();
		var comfirm_password = $('#comfirmPassword').val();

		$('.focusTips').hide();
		
		if(!cur_password)
		{
			$('#cur_tip').show().text('当前密码不能为空');
			return;
		}

		if(!new_password)
		{
			$('#new_tip').show().text('新密码不能为空');
			return;
		}
		else if(new_password.length > 15)
		{
			$('#new_tip').show().text('新密码长度不能超过15');
			return;
		}
		
		if(!comfirm_password)
		{
			$('#new_tip').show().text('新密码不能为空');
			return;
		}
		else if(comfirm_password !== new_password)
		{
			$('#comfirm_tip').show().text('两次密码输入不一致');
			return;
		}

		var url = $('#submit_url').val();
		$.ajax({
			type:'POST',
			url:url,
			dataType: "json",
			data:{cur_password:cur_password,new_password:new_password,comfirm_password:comfirm_password},
			success:function(data){
				if(data.errorCode)
				{
					$('#modify_result').show().text(data.errorText);
				}
				else if(data.success)
				{
					alert('修改成功');
					window.location.href=$('#membercenter_url').val();
				}
			}
		})

	})
})
</script>
<div class="shadow clearfix" id="pCenter">
                 <div id="pMenu" class="gray" style="height: 519px;">
					<div class="border">
						<dl>
						<dt>个人中心</dt>
				        <dd><a href="<?php echo Yii::app()->createUrl('site/membercenter');?>" class="n1">我的帐户</a></dd>
						<dd><a href="<?php echo Yii::app()->createUrl('site/modifypassword');?>" class="n10">修改密码</a></dd>
						</dl>
					</div>
					<div class="border">
						<dl>
						<dt>订单中心</dt>
				        <dd><a href="<?php echo Yii::app()->createUrl('site/myorder',array('today' => 1));?>" class="n2">今日订单</a></dd>
						<dd><a href="<?php echo Yii::app()->createUrl('site/myorder');?>" class="n3">历史订单</a></dd>
						<dd><a href="<?php echo Yii::app()->createUrl('site/seeconsume');?>" class="n3">消费记录</a></dd>
						</dl>
					</div>
					<div class="border">
						<dl>
						<dt>信息中心</dt>
				        <dd><a href="#" class="n7">系统公告</a></dd>
						</dl>
					</div>
				</div>
				
				<div id="pAccount">
                    <div id="ChgPwd" class="acc_con">
                        <p class="ac_title">
                            密码修改</p>
                        <div id="personalPwd" class="ac_content">
                            <ul>
                                <li>
                                    <label>当前密码：</label>
                                    <input type="password" id="curPassword" maxlength="15">
                                    <p class="focusTips" id="cur_tip"></p>
                                </li>
                                <li>
                                    <label>新密码：</label>
                                    <input type="password" id="newPassword" maxlength="15">
                                    <p class="focusTips" id="new_tip"></p>
                                </li>
                                <li>
                                    <label>
                                        确认新密码：</label>
                                    <input type="password" id="comfirmPassword" maxlength="15">
                                    <p class="focusTips"  id="comfirm_tip"></p>
                                </li>
                                <li>
                                    <input type="button" id="btnSubmit" value="确认修改">
                                    <span id="modify_result" style="margin-left:135px;color:red;"></span>
                                    <input type="hidden" id="submit_url" value="<?php echo Yii::app()->createUrl('site/domodify');?>">
                                    <input type="hidden" id="membercenter_url" value="<?php echo Yii::app()->createUrl('site/membercenter');?>">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
               
</div>
<!--end of pCenter -->