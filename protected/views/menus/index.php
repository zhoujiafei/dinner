<script type="text/javascript">
$(function(){
	//按照昵称或者按照手机号搜索
	$('#search_btn').click(function(){
			var val = $('#search_value').val();
			var shop_id = $('#search_shop').val();
			var url = "<?php echo Yii::app()->createUrl('menus/index');?>";
			window.location.href = url + '&k='+ val + '&shop_id=' + shop_id;
	})
})
</script>
<style type="text/css">
.tab-top-search{width:100%;height:40px;}
.tab-top-search .search-box{width:143px;height:25px;float:left;}
.tab-top-search .select-search{width:120px;height:25px;float:left;}
</style>
<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>菜单信息</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">列表</a></li>
          <a href="<?php echo Yii::app()->createUrl('menus/form');?>" class="button" style="float:left;margin-left:10px;">新增</a>
        </ul>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      <div class="content-box-content">
      	<div class="tab-top-search">
      		<div class="search-box">
      			<input type="text" name="k" id="search_value" value="<?php echo Yii::app()->request->getParam('k');?>"/>
      		</div>
      		<div class="select-search">
      			<select id="search_shop">
      				<option value="">所有商家</option>
      				<?php if(isset($shops) && !empty($shops)):?>
      					<?php foreach ($shops AS $_k => $_v):?>
      						<?php 
      							$_cur_id = Yii::app()->request->getParam('shop_id');
      							$_is_selected = false;
      							if($_cur_id == $_v['id'])
      							{
      								$_is_selected = true;
      							}
      						?>
      						<option value="<?php echo $_v['id'];?>" <?php if($_is_selected):?>selected="selected"<?php endif;?>><?php echo $_v['name'];?></option>
      					<?php endforeach;?>
      				<?php endif;?>
      			</select>
      		</div>
      		<div class="select-search">
      			<input type="button" id="search_btn" class="button" value="搜索" />
      		</div>
      	</div>
        <div class="tab-content default-tab" id="tab1">
          <table>
            <thead>
              <tr>
                <th>
                  <input class="check-all" type="checkbox" />
                </th>
                <th>图片</th>
                <th>菜名</th>
                <th>所属商家</th>
                <th>状态</th>
                <th>价格</th>
                <th>创建时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td>
                	<a href="<?php echo Yii::app()->createUrl('menus/form');?>" class="button" style="float:left;margin-left:10px;">新增</a>
                </td>
                <td colspan="7">
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
		                <td><img src="<?php if($v['index_pic']):?><?php echo $v['index_pic']; ?><?php else:?><?php echo Yii::app()->baseUrl;?>/assets/images/defaultMenu.jpg<?php endif;?>" width="40" height="30"></td>
		                <td><?php echo $v['name'];?></td>
		                <td><?php echo $v['shop_name'];?></td>
		                <td  _url="<?php echo Yii::app()->createUrl('menus/audit',array('id' => $v['id'])); ?>"  class="status_row" style="cursor:pointer;color:<?php echo $v['status_color'];?>"><?php echo $v['status_text'];?></td>
		                <td><?php echo $v['price'];?></td>
		                <td><?php echo $v['create_time'];?></td>
		                <td>
		                  <a href="<?php echo Yii::app()->createUrl('menus/form',array('id' => $v['id']));?>" title="Edit"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/pencil.png" alt="Edit" /></a> 
		                  <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('menus/delete',array('id' => $v['id']));?>"  class="remove_row"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a>
		                </td>
		              </tr>
              		<?php endforeach;?>
              <?php endif;?>
            </tbody>
          </table>
        </div>
      </div>
      <input type="hidden" id="audit_url" value="<?php echo Yii::app()->createUrl('menus/audit'); ?>" />
      <!-- End .content-box-content -->
</div>