<?php

/**
 * This is the model class for table "specdsc".
 *
 * The followings are the available columns in table 'specdsc':
 * @property string $id
 * @property string $model_series
 * @property string $desc_en
 * @property string $desc_ru
 * @property string $catalog
 */
class Specdsc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'specdsc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, catalog', 'length', 'max'=>10),
			array('model_series', 'length', 'max'=>11),
			array('desc_en, desc_ru', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_series, desc_en, desc_ru, catalog', 'safe', 'on'=>'search'),
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
			'model_series' => 'Model Series',
			'desc_en' => 'Desc En',
			'desc_ru' => 'Desc Ru',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('model_series',$this->model_series,true);
		$criteria->compare('desc_en',$this->desc_en,true);
		$criteria->compare('desc_ru',$this->desc_ru,true);
		$criteria->compare('catalog',$this->catalog,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getDescEn($catalog, $modelSeries, $spec)
    {
        $sDescEn = Yii::app()->db->CreateCommand()
            ->select('desc_en')
            ->from('specdsc')
            ->where('catalog = :catalog AND model_series= :modelSeries AND id = :spec', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':spec'=>$spec))
            ->queryScalar();

        return $sDescEn;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Specdsc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
