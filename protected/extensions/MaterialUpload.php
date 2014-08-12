<?php
/**
 *用于处理素材库上传
 **/
define('CREATE_DIR_MODE',0777);
class MaterialUpload extends CComponent
{
	private $_dirPath;
	public function init()
	{
		
	}
	
	public function upload($name = '')
	{
		if(!$name)
		{
			throw new CException(Yii::t('no file name'));
		}
		
		$file = CUploadedFile::getInstanceByName($name);
		if(!$file->hasError)
		{
			//生成目录
			$filename = md5(time()) . '.' .  $file->extensionName;
			$filepath = $this->getDirByTime() . DIRECTORY_SEPARATOR;
			$allFilePath = $this->_dirPath . DIRECTORY_SEPARATOR  . $filepath . $filename;
			if(!$this->createDir($this->_dirPath . DIRECTORY_SEPARATOR  . $filepath) || !is_writable($this->_dirPath . DIRECTORY_SEPARATOR  . $filepath))
			{
				throw new CException(Yii::t('yii','dir can not create or can not writeable'));
			}
			
			if($file->saveAs($allFilePath))
			{
				//获取图片宽和高
				$picSize = getimagesize($allFilePath);
				$imgInfo = array(
					'name' 	   		=> $file->name,
					'filepath' 		=> $filepath,
					'filename' 		=> $filename,
					'filesize' 		=> $file->size,
					'type'	   		=> $file->extensionName,
					'mark'	   		=> 'img',
					'imgwidth' 		=> $picSize[0],
					'imgheight'		=> $picSize[1],
					'create_time' 	=> time(),
				);			
				
				//素材数据入库
				$model = new Material();
				$model->attributes = $imgInfo;
				$model->save();
				$imgInfo['id'] = $model->id;
				return $imgInfo;
			}
			else 
			{
				throw new CException(Yii::t('yii','file save error'));
			}
		}
		else 
		{
			throw new CException(Yii::t('yii','there is an error for upload ,error:{error}',array('{error}'=>$file->error)));
		}
	}
	
	public function getDirByTime()
	{
		return date('Y',time()) . DIRECTORY_SEPARATOR . date('m',time());
	}
	
	public function createDir($dir)
	{
		if (!is_dir($dir))
		{
			if(!@mkdir($dir, CREATE_DIR_MODE, 1))
			{
				return false;//创建目录失败
			}
		}
		return true;
	}
	
	public function getDirPath()
	{
		return $this->_dirPath;
	}
	
	public function setDirPath($path)
	{
		if(is_dir($path))
		{
			$this->_dirPath = $path;
		}
		else if($_path = Yii::getPathOfAlias($path))
		{
			$this->_dirPath = $_path;
		}
		else 
		{
			throw new CException(Yii::t('yii','upload dir error, please check it:{path}',array('{path}'=>$path)));
		}
	}
}