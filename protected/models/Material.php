<?php

/**
 * This is the model class for table "{{material}}".
 *
 * The followings are the available columns in table '{{material}}':
 * @property integer $id
 * @property string $name
 * @property string $filepath
 * @property string $filename
 * @property string $type
 * @property string $mark
 * @property integer $imgwidth
 * @property integer $imgheight
 * @property integer $filesize
 * @property integer $create_time
 */
class Material extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{material}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, filepath, filename, type, mark, imgwidth, imgheight, filesize, create_time', 'required'),
			array('id, name, filepath, filename, type, mark, imgwidth, imgheight, filesize, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'filepath' => 'Filepath',
			'filename' => 'Filename',
			'type' => 'Type',
			'mark' => 'Mark',
			'imgwidth' => 'Imgwidth',
			'imgheight' => 'Imgheight',
			'filesize' => 'Filesize',
			'create_time' => 'Create Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('filepath',$this->filepath,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('imgwidth',$this->imgwidth);
		$criteria->compare('imgheight',$this->imgheight);
		$criteria->compare('filesize',$this->filesize);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Material the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
