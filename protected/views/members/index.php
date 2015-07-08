<script type="text/javascript">
$(function(){
	$('#doSearch').click(function(){
		var val = $('#search_name').val();
		var url = $('#request_url').val();
		window.location.href = url + '&k=' + val;
	})

	$('.resetpass_btn').click(function(){
		if(confirm('您确定要重置此人的密吗?'))
		{
			var member_id = $(this).attr('_id');
			var url = "<?php echo Yii::app()->createUrl('members/resetpassword');?>";
			$.ajax({
				type:'POST',
				url:url,
				dataType: "json",
				data:{member_id:member_id},
				success:function(data){
					if(data.errorCode)
					{
						alert(data.errorText);
					}
					else if(data.success)
					{
						alert(data.successText);
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
        <h3>用户信息</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">列表</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      <div class="content-box-content">
	      <input type="text" name="k" id="search_name"  value="<?php echo Yii::app()->request->getParam('k');?>" />
	      <input type="button" value="查找" class="button" id="doSearch" />
	      <div class="tab-content default-tab" id="tab1">
          <table>
            <thead>
              <tr>
                <th>
                  <input class="check-all" type="checkbox" />
                </th>
                <th>用户名</th>
                <th>电话</th>
                <th>邮箱</th>
                <th>状态</th>
                <th>账户余额</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td>
              		<label>会员账户总金额</label>
              		<label style="color:blue;"><?php echo $total_money;?> 元</label>
              	</td>
                <td colspan="6">
                 <?php $this->widget('application.widgets.MyLinkPager', array(
                 			'pages' 			=> $pages,
                 			'firstPageLabel' 	=> '首页',
                 			'lastPageLabel' 	=> '末页',
                 			'prevPageLabel' 	=> '前一页',
                 			'nextPageLabel' 	=> '下一页',
                 			'firstPageLabel' 	=> '首页',
                 			'maxButtonCount' 	=> '5',
                 			'header'			=> '',
                 		));
                 ?>
                  <!-- End .pagination -->
                  <div class="clear"></div>
                </td>
              </tr>
            </tfoot>
            <tbody>
               <?php if(isset($data)):?>
               		<?php foreach ($data AS $k => $v):?>
		              <tr>
		                <td>
		                  <input type="checkbox" name="infolist[]" value="<?php echo $v['id'];?>" />
		                </td>
		                <td><?php echo $v['name'];?></td>
		                <td><?php echo $v['mobile'];?></td>
		                <td><?php echo $v['email'];?></td>
		                <td  _url="<?php echo Yii::app()->createUrl('members/audit',array('id' => $v['id'])); ?>"  class="status_row" style="cursor:pointer;color:<?php echo $v['status_color'];?>"><?php echo $v['status_text'];?></td>
		                <td><?php echo $v['balance'];?></td>
		                <td>
		                	<a href="<?php echo Yii::app()->createUrl('members/recharge',array('id' => $v['id']));?>"  class="button">充值</a>
		                	<a href="<?php echo Yii::app()->createUrl('members/deduct',array('id' => $v['id']));?>"  class="button">扣款</a>
		                	<a href="<?php echo Yii::app()->createUrl('members/seerecord',array('user_id' => $v['id']));?>"  class="button">查看操作记录</a>
		                	<a href="javascript:void(0);" _id="<?php echo $v['id'];?>"  class="button resetpass_btn">重置密码</a>
		                  	<a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('members/delete',array('id' => $v['id']));?>"  class="remove_row"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a>
		                </td>		              
		             </tr>
              		<?php endforeach;?>
              <?php endif;?>
            </tbody>
          </table>
        </div>
      </div>
      <input type="hidden" id="request_url" value="<?php echo Yii::app()->createUrl('members');?>" />
      <!-- End .content-box-content -->
</div>