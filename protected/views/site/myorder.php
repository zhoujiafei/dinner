<script type="text/javascript">
$(function(){
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
				        <dd><a href="<?php echo Yii::app()->createUrl('site/systemnotice');?>" class="n7">系统公告</a></dd>
						</dl>
					</div>
				</div>

				<div id="pContent" class="today_order">
                    <p class="ac_title"><?php echo $cur_title;?></p>
                    <!--end of order_list-->
                    <?php if($order):?>
                    <?php foreach($order AS $k => $v):?>
	                <div class="order_list">
	                    <div class="order_simp">
	                        <table>
	                            <tbody>
	                            	<tr>
		                                <td class="col1">
		                                    <p class="sname fl">
		                                        <a href="#"><?php echo $v['shop_name'];?></a></p>
		                                    <p class="order_num fl">
		                                        （订单号：<span><?php echo $v['order_number'];?></span>）
		                                    </p>
		                                </td>
		                                <td class="col2">
		                                    <?php if($v['status'] == 1):?>
		                                    <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('site/cancelorder',array('id' => $v['id']));?>" class="cancel_order">取消订单</a>
		                                    <?php endif;?>
		                                </td>
		                                <td class="col3 last">
		                                    <span style="color:#5ad;font-size:12px;">下单日期：<?php echo $v['create_order_date'];?></span>
		                                </td>
	                            	</tr>
	                        	</tbody>
	                        </table>
	                        <p class="mt10">
	                            <span class="real_pay">应付：<?php echo $v['total_price'];?>元</span>
	                        </p>
	                    </div>
	                    <!--end of order_simp-->
	                    <div class="order_detail clearfix">
	                        <div class="l fl">
	                            <p><b>您的地址：</b>南京厚建软件有限责任公司</p>
	                            
	                        </div>
	                        <ul class="r fr">
	                        	<?php foreach($v['product_info'] AS $_k => $_v):?>
                                <li>
                                   	<span class="fl"><?php echo $_v['Name']?>×<?php echo $_v['Count']?></span>
                                    <span class="fr price"><?php echo $_v['smallTotal'];?>元</span> 
                                </li>
	                            <?php endforeach;?>
	                        </ul>
	                    </div>
	                    <!--end of order_detail-->
	                    <div class="order_proc pos_relative">
	                    		<?php foreach($v['status_log'] AS $_k => $_v):?>
                                <div class="mt10">
                                    <span style="width:66px;height:24px;text-align:center;background:#bfbfbf;font-family:Arial;font-size: 14px;color:#fff;display: inline-block;"><?php echo $_v['create_time'];?></span>   <?php echo $_v['status_text'];?>
                                </div>
                                <?php endforeach;?>
                        		<p class="refresh clearfix"></p>
	                    </div>
	                </div>
	                <?php endforeach;?>
	                <?php endif;?>
	                <!--end of order_list-->
	                
	                 <?php $this->widget('application.widgets.MyLinkPager', array(
                 			'pages' 			=> $pages,
                 			'firstPageLabel' 	=> '首页',
                 			'lastPageLabel' 	=> '末页',
                 			'prevPageLabel' 	=> '前一页',
                 			'nextPageLabel' 	=> '下一页',
                 			'maxButtonCount' 	=> '5',
                 			'header'			=> '',
                 		));
                 	?>
                 	
					<!--<p id="order_OrderPage" class="order_page" style="display:block"><span>第1/1页</span></p>-->
                    <!--end of todayOrder -->
        		</div>
</div>
<!--end of pCenter -->