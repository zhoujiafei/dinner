<?php 
if(isset($data) && $data)
{
	$a = 'update';
	$op_text = '更新';
	$_action = Yii::app()->createUrl('announcement/update');
}
else 
{
	$a = 'create';
	$op_text = '创建';
	$_action = Yii::app()->createUrl('announcement/create');
}
?>
<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3><?php echo $op_text;?>公告</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">表单</a></li>
        </ul>
        <div class="clear"></div>
      </div>
	  <div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
          <form action="<?php echo $_action;?>" method="post" enctype="multipart/form-data">
            <fieldset>
            <p>
              <label>标题</label>
              <input class="text-input small-input" type="text"  name="Announcement[title]" value="<?php echo CHtml::encode($data['title']); ?>"/>
            </p>
            
            <p>
              <label>内容</label>
              <textarea class="text-input textarea" name="Announcement[content]" cols="79" rows="15"><?php echo CHtml::encode($data['content']); ?></textarea>
            </p>
            
            <p>
              <input type="hidden" name="id" value="<?php echo $data['id'];?>" />
              <input class="button" type="submit" value="<?php echo $op_text;?>" />
            </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
          </form>
        </div>
     </div>
 </div>