<?php

/**
 * This is the model class for table "{{food_order}}".
 *
 * The followings are the available columns in table '{{food_order}}':
 * @property integer $id
 * @property string $order_number
 * @property integer $pay_time
 * @property integer $status
 * @property integer $food_user_id
 */
class FoodOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{food_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('shop_id,order_number, product_info,create_time, status, food_user_id,total_price', 'required'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'shops' 	=> array(self::BELONGS_TO, 'Shops', '', 'on' => 't.shop_id = shops.id'),
			'members' 	=> array(self::BELONGS_TO, 'Members', '', 'on' => 't.food_user_id = members.id'),
			'food_log'	=> array(self::HAS_MANY, 'FoodOrderLog', '', 'on' => 't.id = food_log.food_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_number' => 'Order Number',
			'pay_time' => 'Pay Time',
			'status' => 'Status',
			'food_user_id' => 'Food User',
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
		$criteria->compare('order_number',$this->order_number,true);
		$criteria->compare('pay_time',$this->pay_time);
		$criteria->compare('status',$this->status);
		$criteria->compare('food_user_id',$this->food_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FoodOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
