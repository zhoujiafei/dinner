<script type="text/javascript">
$(function(){
	$('.deduct_money').click(function(){
		if(confirm('您确认要扣款'))
		{
			var url = $(this).attr('_href');
			$.ajax({
				type:'GET',
				url:url,
				dataType: "json",
				success:function(data){
					if(data.errorCode)
					{
						alert(data.errorText);
					}
					else if(data.success)
					{
						alert('扣款成功');
						window.location.reload();
					}
				}
			})
		}
	})

	$('.cancel_order').click(function(){
		if(confirm('您确认要取消订单'))
		{
			var url = $(this).attr('_href');
			$.ajax({
				type:'GET',
				url:url,
				dataType: "json",
				success:function(data){
					if(data.errorCode)
					{
						alert(data.errorText);
					}
					else if(data.success)
					{
						alert('取消订单成功');
						window.location.reload();
					}
				}
			})
		}
	})

	//根据日期查询订单
	$('#searchOrder').click(function(){
		var date = $('#date').val();
		if(!date)
		{
			alert('请输入要查询订单的日期，格式如：2014-05-20');
			return;
		}

		var url = "<?php echo Yii::app()->createUrl('foodorder/todayorder');?>";
		window.location.href = url+'&date='+date;
	})

	//当天订单一健扣款
	$('#onekey').click(function(){
		if(confirm('您确定要为今天未付款订单扣款吗？'))
		{
			var url = "<?php echo Yii::app()->createUrl('foodorder/onekey');?>";
			$.ajax({
				type:'GET',
				url:url,
				dataType: "json",
				success:function(data){
					if(data.errorCode)
					{
						alert(data.errorText);
					}
					else if(data.success)
					{
						alert(data.successText);
						window.location.reload();
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
        <h3>订单信息</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">列表</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
        	<input type="button" value="一键扣款" class="button" id="onekey" />
        	<label style="color: red">温馨提示：只扣除今天的未付款订单，账户余额不足的不予处理</label>
          <table>
            <thead>
              <tr>
                <th>
                  <input class="check-all" type="checkbox" />
                </th>
                <th>订单号</th>
                <th>所属商家</th>
                <th>用户名</th>
                <th>订单状态</th>
                <th>总价</th>
                <th>创建时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td  colspan="2">
              		<a href="<?php echo Yii::app()->createUrl('foodorder/todayorder');?>" class="button">今日订单统计快速通道</a>
              	</td>
              	<td>
              		<label>按日期查询订单：</label>
              	</td>
              	<td colspan="2">
              		<input class="text-input small-input" type="text"  id="date" />
              		<input type="button" class="button" value="查询" id="searchOrder" />
              	</td>
                <td colspan="3">
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
		                <td><?php echo $v['order_number'];?></td>
		                <td><?php echo $v['shop_name'];?></td>
		                <td><?php echo $v['user_name'];?></td>
		                <td style="cursor:pointer;color:<?php echo $v['status_color'];?>"><?php echo $v['status_text'];?></td>
		                <td><?php echo $v['total_price'];?></td>
		                <td><?php echo $v['create_time'];?></td>
		                <td>
		                  <!-- Icons -->
		                  <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('foodorder/deductmoney',array('id' => $v['id']));?>" class="deduct_money button">扣款</a>
		                  <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('foodorder/cancelorder',array('id' => $v['id']));?>" class="cancel_order button">取消订单</a>
		                  <a href="<?php echo Yii::app()->createUrl('foodorder/form',array('id' => $v['id']));?>" title="查看"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/information.png" alt="查看" /></a> 
		                  <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('foodorder/delete',array('id' => $v['id']));?>"  class="remove_row"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a>
		                </td>
		              </tr>
              		<?php endforeach;?>
              <?php endif;?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- End .content-box-content -->
</div>