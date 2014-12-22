<?php

/**
 * This is the model class for table "model_codes".
 *
 * The followings are the available columns in table 'model_codes':
 * @property string $model_code
 * @property string $model_series
 * @property string $catalog
 * @property integer $pos_num
 * @property string $id
 */
class ModelCodes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'model_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pos_num', 'numerical', 'integerOnly'=>true),
			array('model_code', 'length', 'max'=>50),
			array('model_series, id', 'length', 'max'=>20),
			array('catalog', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('model_code, model_series, catalog, pos_num, id', 'safe', 'on'=>'search'),
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
			'model_code' => 'Model Code',
			'model_series' => 'Model Series',
			'catalog' => 'Catalog',
			'pos_num' => 'Pos Num',
			'id' => 'ID',
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

		$criteria->compare('model_code',$this->model_code,true);
		$criteria->compare('model_series',$this->model_series,true);
		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('pos_num',$this->pos_num);
		$criteria->compare('id',$this->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getInfByModelCode($ModelCode)
    {
        $aInfByModelCode = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('model_codes')
            ->where('id = :id', array(':id'=>$ModelCode))
            ->queryRow();
		
				
        return  $aInfByModelCode;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
