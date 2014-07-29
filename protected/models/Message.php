<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property integer $shop_id
 * @property string $content
 * @property integer $create_time
 * @property integer $user_id
 */
class Message extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('content,shop_id,user_id,create_time', 'required'),
			array('id, shop_id, content, create_time, user_id', 'safe', 'on'=>'search'),
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
			'shops' 	=> array(self::BELONGS_TO, 'Shops', '', 'on' => 't.shop_id = shops.id'),
			'members' 	=> array(self::BELONGS_TO, 'Members', '', 'on' => 't.user_id = members.id'),
			'replys'	=> array(self::HAS_MANY,'Reply','','on' => 't.id = replys.message_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'shop_id' => 'Shop',
			'content' => 'Content',
			'create_time' => 'Create Time',
			'user_id' => 'User',
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
		$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
