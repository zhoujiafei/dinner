<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>商家信息</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">列表</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
          <table>
            <thead>
              <tr>
                <th>
                  <input class="check-all" type="checkbox" />
                </th>
                <th>店招</th>
                <th>店名</th>
                <th>地址</th>
                <th>联系人</th>
                <th>电话</th>
                <th>状态</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td>
                	<a href="<?php echo Yii::app()->createUrl('shops/form');?>" class="button" style="float:left;margin-left:10px;">新增</a>
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
		                <td><img src="<?php echo $v['logo'];?>" width="40" height="30" /></td>
		                <td><?php echo $v['name'];?></td>
		                <td><?php echo $v['address'];?></td>
		                <td><?php echo $v['linkman'];?></td>
		                <td><?php echo $v['tel'];?></td>
		                <td  _url="<?php echo Yii::app()->createUrl('shops/audit',array('id' => $v['id'])); ?>"  class="status_row" style="cursor:pointer;color:<?php echo $v['status_color'];?>"><?php echo $v['status_text'];?></td>
		                <td>
		                  <!-- Icons -->
		                  <a href="<?php echo Yii::app()->createUrl('shops/importMenu',array('id' => $v['id']));?>" title="导入菜单" class="button" >导入菜单</a>
		                  <a href="<?php echo Yii::app()->createUrl('shops/form',array('id' => $v['id']));?>" title="Edit"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/pencil.png" alt="Edit" /></a> 
		                  <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('shops/delete',array('id' => $v['id']));?>"  class="remove_row"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a>
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