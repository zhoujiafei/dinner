<script type="text/javascript">
$(function(){
	$('#deduct_btn').click(function(){
		if(confirm('您确定要扣款吗?'))
		{
			var member_id = $('#member_id').val();
			var money = $('#money').val();
			var url = $('#deduct_url').val();
			
			$.ajax({
				type:'POST',
				url:url,
				dataType: "json",
				data:{member_id:member_id,money:money},
				success:function(data){
					if(data.errorCode)
					{
						alert('扣款失败：' + data.errorText);
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
        <h3>扣款</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">表单</a></li>
        </ul>
        <div class="clear"></div>
      </div>
	  <div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
          <form action="#" method="post" enctype="multipart/form-data">
            <fieldset>
            
            <p>
              <label>您正在为<font color="blue"><?php echo $member_name;?></font>扣款</label>
              <input type="text" name="money"  id="money" />元
            </p>
   
            <p>
               <input type="hidden" id="member_id" value="<?php echo $member_id;?>" />
               <input type="hidden" value="<?php echo Yii::app()->createUrl('members/dodeduct');?>" id="deduct_url" />
               <input type="hidden" value="<?php echo Yii::app()->createUrl('members');?>" id="member_url" />
               <input class="button" type="button" value="扣款" id="deduct_btn" />
            </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
          </form>
        </div>
     </div>
 </div>