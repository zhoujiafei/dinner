<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>素材信息</h3>
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
                <th>图片</th>
                <th>文件名</th>
                <th>存储路径</th>
                <th>类型</th>
                <th>文件大小</th>
                <th>创建时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td>
                	<a href="<?php echo Yii::app()->createUrl('menus/form');?>" class="button" style="float:left;margin-left:10px;">新增</a>
                </td>
                <td colspan="8">
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
		                  <input type="checkbox"   value="<?php echo $v['id'];?>" />
		                </td>
		                <td><img src="<?php echo $v['index_pic'];?>" width="40" height="30"></td>
		                <td><?php echo $v['name'];?></td>
		                <td><?php echo $v['filepath'];?></td>
		                <td><?php echo $v['type'];?></td>
		                <td><?php echo $v['filesize'];?></td>
		                <td><?php echo $v['create_time'];?></td>
		                <td><a href="<?php echo Yii::app()->createUrl('Material/delete',array('id' => $v['id']));?>" title="Delete"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a></td>
		              </tr>
              		<?php endforeach;?>
              <?php endif;?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- End .content-box-content -->
</div>