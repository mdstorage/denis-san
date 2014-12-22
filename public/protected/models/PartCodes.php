<?php

/**
 * This is the model class for table "part_codes".
 *
 * The followings are the available columns in table 'part_codes':
 * @property string $model_series
 * @property string $catalog
 * @property string $Id
 * @property string $sec_group
 * @property string $desc_en
 * @property string $desc_ru
 */
class PartCodes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'part_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id', 'required'),
			array('model_series, catalog, Id', 'length', 'max'=>20),
			array('sec_group, desc_en, desc_ru', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('model_series, catalog, Id, sec_group, desc_en, desc_ru', 'safe', 'on'=>'search'),
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
			'model_series' => 'Model Series',
			'catalog' => 'Catalog',
			'Id' => 'ID',
			'sec_group' => 'Sec Group',
			'desc_en' => 'Desc En',
			'desc_ru' => 'Desc Ru',
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

		$criteria->compare('model_series',$this->model_series,true);
		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('Id',$this->Id,true);
		$criteria->compare('sec_group',$this->sec_group,true);
		$criteria->compare('desc_en',$this->desc_en,true);
		$criteria->compare('desc_ru',$this->desc_ru,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDescEnById($catalog, $modelSeries, $partCode, $secGroup)
    {
        $sDescEnById = Yii::app()->db->CreateCommand()
            ->select('desc_en')
            ->from('part_codes')
            ->where('catalog = :catalog AND model_series = :modelSeries AND Id = :partCode AND sec_group = :secGroup', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':partCode'=>$partCode, ':secGroup'=>$secGroup))
            ->queryScalar();
						
        return $sDescEnById;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PartCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
