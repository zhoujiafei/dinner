<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>公告信息</h3>
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
                <th>标题</th>
                <th>公告内容</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              	<td>
                	<a href="<?php echo Yii::app()->createUrl('announcement/form');?>" class="button" style="float:left;margin-left:10px;">新增</a>
                </td>
                <td colspan="5">
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
		                <td><?php echo $v['title'];?></td>
		                <td><?php echo $v['content'];?></td>
		                <td  _url="<?php echo Yii::app()->createUrl('announcement/audit',array('id' => $v['id'])); ?>"  class="status_row" style="cursor:pointer;color:<?php echo $v['status_color'];?>"><?php echo $v['status_text'];?></td>
		                <td><?php echo $v['create_time'];?></td>
		                <td>
		                	<a href="<?php echo Yii::app()->createUrl('announcement/form',array('id' => $v['id']));?>" title="Edit"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/pencil.png" alt="Edit" /></a> 
		                  	<a href="javascript:void(0);" _href="<?php echo Yii::app()->createUrl('announcement/delete',array('id' => $v['id']));?>"  class="remove_row"><img src="<?php echo Yii::app()->baseUrl;?>/assets/images/icons/cross.png" alt="Delete" /></a>
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