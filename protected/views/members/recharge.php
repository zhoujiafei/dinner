<script type="text/javascript">
$(function(){
	$('#recharge_btn').click(function(){
		if(confirm('您确定要充值吗?'))
		{
			var member_id = $('#member_id').val();
			var money = $('#money').val();
			var url = $('#recharge_url').val();
			
			$.ajax({
				type:'POST',
				url:url,
				dataType: "json",
				data:{member_id:member_id,money:money},
				success:function(data){
					if(data.errorCode)
					{
						alert('充值失败：' + data.errorText);
					}
					else if(data.success)
					{
						alert(data.successText);
						window.location.href = $('#member_url').val();
					}
				}
			})
		}
	})
})
</script>
<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>充值</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">表单</a></li>
        </ul>
        <div class="clear"></div>
      </div>
	  <div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
          <form action="<?php echo $_action;?>" method="post" enctype="multipart/form-data">
            <fieldset>
            
            <p>
              <label>您正在为<font color="blue"><?php echo $member_name;?></font>充值</label>
              <select id="money" class="small-input">
                <?php foreach($recharge AS $_key => $_value):?>
                <option value="<?php echo $_value;?>"><?php echo $_value;?>元</option>
                <?php endforeach;?>
              </select>
            </p>
   
            <p>
               <input type="hidden" id="member_id" value="<?php echo $member_id;?>" />
               <input type="hidden" value="<?php echo Yii::app()->createUrl('members/dorecharge');?>" id="recharge_url" />
               <input type="hidden" value="<?php echo Yii::app()->createUrl('members');?>" id="member_url" />
               <input class="button" type="button" value="充值" id="recharge_btn" />
            </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
          </form>
        </div>
     </div>
 </div>