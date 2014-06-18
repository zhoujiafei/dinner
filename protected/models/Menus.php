<?php

/**
 * This is the model class for table "{{menus}}".
 *
 * The followings are the available columns in table '{{menus}}':
 * @property integer $id
 * @property string $name
 * @property integer $sort_id
 * @property integer $price
 * @property string $brief
 * @property integer $status
 */
class Menus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menus}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name,shop_id, price,index_pic','required'),
			array('brief','safe'),
			array('id, name,index_pic,sort_id, price, brief, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'food_sort' => array(self::BELONGS_TO,'FoodSort','sort_id','select'=>'name'),
			'image' 	=> array(self::HAS_ONE, 'Material', '', 'on' => 't.index_pic = image.id'),
			'shops' 		=> array(self::BELONGS_TO, 'Shops', '', 'on' => 't.shop_id = shops.id'),
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
			'sort_id' => 'Sort',
			'price' => 'Price',
			'brief' => 'Brief',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sort_id',$this->sort_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('brief',$this->brief,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}