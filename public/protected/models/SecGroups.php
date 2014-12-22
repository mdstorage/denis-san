<?php

/**
 * This is the model class for table "sec_groups".
 *
 * The followings are the available columns in table 'sec_groups':
 * @property string $model_series
 * @property string $catalog
 * @property string $Id
 * @property string $pri_group
 * @property string $desc_en
 * @property string $desc_ru
 */
class SecGroups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sec_groups';
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
			array('pri_group, desc_en, desc_ru', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('model_series, catalog, Id, pri_group, desc_en, desc_ru', 'safe', 'on'=>'search'),
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
			'pri_group' => 'Pri Group',
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
		$criteria->compare('pri_group',$this->pri_group,true);
		$criteria->compare('desc_en',$this->desc_en,true);
		$criteria->compare('desc_ru',$this->desc_ru,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	 public function getSecGroup($catalog, $modelSeries, $Id)
    {
        $aSecgroup = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('sec_groups')
            ->where('catalog = :catalog AND model_series=:modelSeries AND pri_group=:Id', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':Id'=>$Id))
		/*	->group('desc_en')*/
			->order('Id')
            ->queryAll();
		
				
        return $aSecgroup;
    }
	
	public function getSecGroupCoords($catalog, $modelSeries, $Id)
    {
        $query = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('sec_groups')
            ->where('catalog = :catalog AND model_series=:modelSeries AND pri_group=:Id', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':Id'=>$Id))
			->order('Id');
					
			$aSecGroupCoords = $query->queryAll();

    }
	
	
	public function getDescEnById($catalog, $modelSeries, $Id, $secGroup)
    {
        $sDescEnById = Yii::app()->db->CreateCommand()
            ->select('desc_en')
            ->from('sec_groups')
            ->where('catalog = :catalog AND model_series = :modelSeries AND pri_group = :Id AND Id = :secGroup', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':Id'=>$Id, ':secGroup'=>$secGroup))
            ->queryScalar();
						
        return $sDescEnById;
    }
	
	public function getPGDescEnById($catalog, $modelSeries, $secGroup)
    {
        $aPGDescEnById = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('sec_groups')
            ->where('catalog = :catalog AND model_series = :modelSeries AND Id = :secGroup', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':secGroup'=>$secGroup))
            ->queryRow();
						
        return $aPGDescEnById;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SecGroups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
