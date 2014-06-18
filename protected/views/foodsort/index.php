<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>菜系分类</h3>
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
                <th>名称</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td>
                	<a href="<?php echo Yii::app()->createUrl('foodsort/form');?>" class="button" style="float:left;margin-left:10px;">新增</a>
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
		                  <input type="checkbox" name="line_{$v['appid']}" value="{$v['appid']}" />
		                </td>
		                <td><?php echo $v['name'];?></td>
		                <td>
		                  <!-- Icons -->
		                  <a href="<?php echo Yii::app()->createUrl('foodsort/form',array('id' => $v['id']));?>" title="Edit"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/pencil.png" alt="Edit" /></a> 
		                  <a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('foodsort/delete',array('id' => $v['id']));?>"  class="remove_row"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a>
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