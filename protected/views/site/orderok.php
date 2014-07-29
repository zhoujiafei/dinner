<div id="wrap" style="width: 750px;">
        <div id="order" class="shadow">
                <div class="suc_text">
                    <div class="clearfix">
                        <h2 class="fl">恭喜您：<?php echo $order_info['username'];?>  您的订单提交成功!</h2>
                    </div>
                </div>
                <div class="suc_block">
                    <p>订单号：<?php echo $order_info['order_number'];?>  下单时间：<?php echo $order_info['create_time'];?></p>
                    <p>美食将在12点之前送到，请好好上班！</p>
                </div>

                <p class="goto">
                    <a href="<?php echo Yii::app()->createUrl('site/myorder',array('today' => 1));?>">追踪订单状态</a> | <a href="<?php echo Yii::app()->createUrl('site');?>">返回首页</a>
                </p>
        </div>
</div>