<script type="text/javascript">
$(function(){
	var _cart = new CartHelper();
	$('#sendOrder').click(function(){
		if(!_cart.Read().Count)
		{
			alert('您还没有选择菜，请选完之后再下单');
			return;
		}
		window.location.href=$('#goToOrderUrl').val();
	})
})
</script>
<div id="wrap" style="width: 750px;">
        <div id="order" class="shadow">
            <div class="order_top clearfix">
                <ul class="clearfix buy_item fr">
                    <li>1.选择美食</li>
                    <li>3.完成订单</li>
                    <li>2.确认订单</li>
                    <li class="buy_item_last">&nbsp;</li>
                </ul>
                <img src="" alt="" width="45px" height="45px" class="fl">
                <p><a id="Supplier_id" supid="22" href="<?php echo Yii::app()->createUrl('site/lookmenu',array('shop_id' => $order['shop_id']));?>"><?php echo $order['shop_name'];?></a></p>
                <p>起送价：都能送</p>
            </div>
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="col1">
                            美食筐
                        </td>
                        <td class="col2">
                            单价
                        </td>
                        <td class="col3">
                            数量
                        </td>
                        <td class="col4">
                            小计
                        </td>
                    </tr>
                </thead>
                <tbody>
                		<?php if($order && $order['Items']):?>
                    		<?php foreach ($order['Items'] AS $k => $v):?>
                    		<tr>
			                    <td><?php echo $v['Name'];?></td>
			                    <td>￥<?php echo $v['Price'];?></td>
			                    <td><?php echo $v['Count'];?></td>
			                    <td>￥<?php echo $v['smallTotal'];?></td>
                    		</tr>
                    		<?php endforeach;?>
	                    <?php endif;?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <p class="order_total">
                                共<em><?php echo $order['Count'];?></em>份美食&nbsp;&nbsp;&nbsp;&nbsp;总价：<em>¥<?php echo $order['Total'];?>
                                </em>
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="button" id="sendOrder" value="确认下单" style="margin-top: 6px;">
            <input type="hidden" id="goToOrderUrl" value="<?php echo Yii::app()->createUrl('site/confirmorder');?>" />
        </div>
</div>