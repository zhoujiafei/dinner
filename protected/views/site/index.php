<div id="left">
                <!--在线餐厅开始-->
                <div id="onlineSup" class="sup_list">
                    <div class="sup_list_title">
                        <h2>在线订餐</h2>
                        <p class="si_filter">
                            <!--  <input id="showOnLine" class="fl" type="checkbox"><span class="fl">仅显示营业中</span>-->
                        </p>
                        <p class="step">
                            <span>交预付款</span><span>选餐厅</span><span>选美食</span><span>下订单</span><span>由前台妹子统一订购</span>
                        </p>
                    </div>
                    <div class="sup_list_body shadow" id="hallListOnline">
                        <table cellpadding="0" cellspacing="0" id="SupplierListBody">       
                         <tbody>
                         	<?php 
                         		$_tr_num = count($shops)/4;
                         		for($i = 0;$i<$_tr_num;$i++):
                         	?>
                         		<tr>
                              		<?php for($j = 0;$j<4;$j++):
                              				$_index = $i * 4 + $j;
                                    		if($_index >= (count($shops)))
                                    		{
                                    			break;
                                    		}
                              		?>	
                                    <td>
                                        <div class="si_block<?php if(!$isOnTime):?> si_closed <?php endif;?>" sid="0">
                                            <div class="si_logo">
                                            	<?php if($isOnTime):?>
                                                <a href="<?php echo Yii::app()->createUrl('site/lookmenu',array('shop_id' => $shops[$_index]['id']));?>">
                                                <?php else:?>
                                                <a href="javascript:alert('不好意思啦，已经打烊啦');">
                                                <?php endif;?>
                                                    <img src="<?php echo $shops[$_index]['logo'];?>"   width="43px" height="43px" style="display: inline;">
                                                </a>
                                            </div>
                                            <div class="si_info">
                                                <p class="si_name">
                                                	<?php if($isOnTime):?>
                                                    <a href="<?php echo Yii::app()->createUrl('site/lookmenu',array('shop_id' => $shops[$_index]['id']));?>">
                                                    <?php else:?>
                                                    <a href="javascript:alert('不好意思啦，已经打烊啦');">
                                                    <?php endif;?>
                                                	<?php echo $shops[$_index]['name'];?>
                                                    </a>
                                                </p>
                                                <?php if($isOnTime):?>
                                                <p class="si_rec star">推荐度：0星</p>
                                                <p class="si_com"><em>&nbsp;</em></p>
                                                <?php if ($shops[$_index]['url']):?>
                                                	<a href="<?php echo $shops[$_index]['url'];?>" target="_blank">商家网站</a>
                                                <?php endif;?>
                                                <?php else:?>
                                                <span class="rest"></span>
                                                <p class="rest">已打烊</p>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </td>
                                    <?php endfor;?>
                               </tr> 
                               <?php endfor;?>                               
                        </tbody>
                        </table>
                    </div>
                </div>
                <!--在线餐厅结束-->
</div>

<div id="right">
	<div class="right_item shadow" id="siteNotice">
	    <h3>餐厅公告</h3>
	    <div class="ri_body">
	    <?php foreach ($announce AS $_k => $_v):?>
	    <p><?php echo $_v['content'];?></p>
	    <?php endforeach;?>
	    </div>
	</div>
	<div class="right_item shadow" id="customerService">
	    <h3>
	        客户服务</h3>
	    <div class="ri_body">
	        <p>客服QQ:564751169</p>
	        <p>技术支持:周星星</p>
	    </div>
	</div>
	<a href="javascript:alert('扫描下方的二维码即可下载ios版客户端');" target="_blank" id="androidAppDownload" class="mt10" style="display: block;">
	    <img src="<?php echo Yii::app()->baseUrl;?>/assets/images/front/appdown.png" width="272" height="63" alt="Adroid APP客户端">
	</a>
	<div class="right_item shadow">
	    <h3>下载iphone版</h3>
	    <img src="<?php echo Yii::app()->baseUrl;?>/assets/images/front/ios.png" width="265" height="265" />
	</div>
	<div class="right_item shadow" id="customerService">
	    <h3>账户余额不足20元的会员名单</h3>
	    <div class="ri_body">
	    	<?php if($members):?>
	    	<?php foreach ($members AS $_k => $_v):?>
	        	<p><?php echo $_v['name'];?>-------仅剩<?php echo $_v['balance'];?>元</p>
	        <?php endforeach;?>
	        <?php else:?>
	        	<p>暂时没有</p>
	        <?php endif;?>
	    </div>
	</div>
	<div class="right_item shadow" id="focusUs">
	    <h3>玩转阿吃啦</h3>
	    <div class="ri_body">
	        <script charset="Shift_JIS" src="http://chabudai.sakura.ne.jp/blogparts/honehoneclock/honehone_clock_tr.js"></script>
	    </div>
	</div>
</div>