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
				
				<div id="pContent">
                    <div id="sysNotice">
                        <h1>消费记录</h1>
                        <div class="sys_con">
                            	<?php if(!$data):?>
                            	<p class="not_title">
                                <span>暂时还没有消费记录...</span>
                                </p>
                                <?php else:?>
                                <?php foreach ($data AS $k => $v):?>
                                <p class="not_title">
                                <span><?php echo $v['user_name'];?>--------<span style="color:<?php if($v['type']):?>blue;<?php else:?>red;<?php endif;?>"><?php echo $v['type_text'];?></span>--------<?php echo $v['money'];?>元--------<?php echo $v['create_time'];?></span>
                                </p>
                                <?php endforeach;?>
                                <?php endif;?>
                        </div>
                    </div>
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
                </div>
</div>
<!--end of pCenter -->