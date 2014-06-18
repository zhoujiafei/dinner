<?php 
if(isset($data) && $data)
{
	$a = 'update';
	$op_text = '更新';
	$_action = Yii::app()->createUrl('members/update');
}
else 
{
	$a = 'create';
	$op_text = '创建';
	$_action = Yii::app()->createUrl('members/create');
}
?>
<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3><?php echo $op_text;?>用户</h3>
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
              <label>用户名</label>
              <input class="text-input small-input" type="text"  name="Members[name]" value="<?php echo CHtml::encode($data['name']); ?>"/>
            </p>
            
            <p>
              <label>图片</label>
              <input class="text-input small-input" type="file"  name="index_pic" />
            </p>
            
            <p>
             	<img src="<?php echo CHtml::encode($data['index_pic']);?>" width="160" hieght="120" />
            </p>
            
            <p>
              <label>分类</label>
              <input class="text-input small-input" type="text" name="Menus[sort_id]" value="<?php echo CHtml::encode($data['sort_id']); ?>" />
            </p>
            
            <p>
              <label>商家</label>
              <select name="Menus[shop_id]" class="small-input">
              	<option value="0" >全部商家</option>
                <?php foreach($shops AS $_key => $_value):?>
                <option value="<?php echo $_value['id'];?>" <?php if($data['shop_id'] == $_value['id']): ?> selected <?php endif;?>><?php echo $_value['name'];?></option>
                <?php endforeach;?>
              </select>
            </p>
            
            <p>
              <label>价格</label>
              <input class="text-input small-input" type="text" name="Menus[price]" value="<?php echo CHtml::encode($data['price']); ?>"/> 元
            </p>
            
            <p>
              <label>简介</label>
              <textarea class="text-input textarea" name="Menus[brief]" cols="79" rows="15"><?php echo CHtml::encode($data['brief']); ?></textarea>
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