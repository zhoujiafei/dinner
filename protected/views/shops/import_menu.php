<div class="content-box">
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3>导入菜单到《<?php echo $data['name'];?>》</h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">表单</a></li>
        </ul>
        <div class="clear"></div>
      </div>
	  <div class="content-box-content">
		<div class="tab-content default-tab" id="tab1">
          <form action="<?php echo Yii::app()->createUrl('shops/doImport');?>" method="post" enctype="multipart/form-data">
            <fieldset>
            <p>
              <label style="color:red;">请添加菜单文件</label>
              <input type="file" name="menufile" />
            </p>
            
            <p>
              <input type="hidden" name="id" value="<?php echo $data['id'];?>" />
              <input class="button" type="submit" value="导入" />
            </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
          </form>
        </div>
     </div>
 </div>