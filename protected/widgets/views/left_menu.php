<ul id="main-nav">
        <?php foreach($_menus AS $_k => $_v): ?>
        	<li> 
	        	<a href="<?php echo Yii::app()->createUrl($_v['link'])?>" class="nav-top-item"><?php echo $_v['zh_name']?></a>
	        	<?php if(isset($_v['child'])): ?>
	        		<ul>
	        			<?php foreach($_v['child'] AS $_kk => $_vv): ?>
	        			<li><a href="<?php echo Yii::app()->createUrl($_vv['link'])?>"><?php echo $_vv['zh_name']?></a></li>
	        			<?php endforeach;?>
	        		</ul>
	        	<?php endif; ?>
        	</li>
       <?php endforeach;?>
</ul>