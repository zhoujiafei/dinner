<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>时间配置</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">表单</a></li>
        </ul>
        <div class="clear"></div>
      </div>
	  <div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
          <form action="<?php echo Yii::app()->createUrl('timeconfig/update');?>" method="post" enctype="multipart/form-data">
            <fieldset>
            <p>
              <label>开始时间</label>
              <input class="text-input small-input" type="text"  name="start_time" value="<?php echo CHtml::encode($data['start_time']); ?>"/>
            </p>
            
            <p>
              <label>结束时间</label>
              <input class="text-input small-input" type="text" name="end_time" value="<?php echo CHtml::encode($data['end_time']); ?>"/>
            </p>
            
            <p>
              <label>是否开启</label>
              <input type="checkbox" name="is_open" value="1"  <?php if($data['is_open']):?>checked="checked"<?php endif;?> />
            </p>
            
            <p>
              <input class="button" type="submit" value="修改" />
            </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
          </form>
        </div>
     </div>
 </div>