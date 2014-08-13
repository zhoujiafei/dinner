<?php 
if(isset($data) && $data)
{
	$a = 'update';
	$op_text = '更新';
	$_action = Yii::app()->createUrl('foodsort/update');
}
else 
{
	$a = 'create';
	$op_text = '创建';
	$_action = Yii::app()->createUrl('foodsort/create');
}
?>
<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3><?php echo $op_text;?>菜系</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">表单</a></li>
        </ul>
        <div class="clear"></div>
      </div>
	  <div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
          <form action="<?php echo $_action;?>" method="post">
            <fieldset>
            <p>
              <label>名称名</label>
              <input class="text-input small-input" type="text"  name="FoodSort[name]" value="<?php echo CHtml::encode($data['name']); ?>"/>
            </p>
            <p>
              <label>父级</label>
              <input class="text-input small-input" type="text" name="FoodSort[fid]" value="<?php echo CHtml::encode($data['fid']); ?>" />
            </p>
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