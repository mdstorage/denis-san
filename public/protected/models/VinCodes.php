<?php

/**
 * This is the model class for table "vin_codes".
 *
 * The followings are the available columns in table 'vin_codes':
 * @property string $vin
 * @property string $vdate
 * @property string $internal_color
 * @property string $color
 * @property string $country
 * @property string $model_code
 * @property string $spec_code
 * @property string $catalog
 */
class VinCodes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vin_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vin, model_code, spec_code, catalog', 'length', 'max'=>20),
			array('vdate, country', 'length', 'max'=>10),
			array('internal_color, color', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vin, vdate, internal_color, color, country, model_code, spec_code, catalog', 'safe', 'on'=>'search'),
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
			'vin' => 'Vin',
			'vdate' => 'Vdate',
			'internal_color' => 'Internal Color',
			'color' => 'Color',
			'country' => 'Country',
			'model_code' => 'Model Code',
			'spec_code' => 'Spec Code',
			'catalog' => 'Catalog',
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

		$criteria->compare('vin',$this->vin,true);
		$criteria->compare('vdate',$this->vdate,true);
		$criteria->compare('internal_color',$this->internal_color,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('model_code',$this->model_code,true);
		$criteria->compare('spec_code',$this->spec_code,true);
		$criteria->compare('catalog',$this->catalog,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getInfByVinCode($vin)
    {
        $aInfByVinCode = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('vin_codes')
            ->where('vin = :vin', array(':vin'=>$vin))
            ->queryRow();
		
				
        return  $aInfByVinCode;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VinCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
