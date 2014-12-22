<?php

/**
 * This is the model class for table "part_catalog".
 *
 * The followings are the available columns in table 'part_catalog':
 * @property string $model_series
 * @property string $catalog
 * @property string $part_number
 * @property string $part_code
 * @property string $sec_group
 * @property string $pri_group
 * @property string $complect_restr
 * @property string $option_restr
 * @property string $alter_code
 * @property string $production_start
 * @property string $production_end
 * @property string $quantity_in_part
 * @property string $desc_en
 * @property string $desc_ru
 * @property string $specification
 * @property string $ica_code
 */
class PartCatalog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'part_catalog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_series, catalog, part_number, part_code, sec_group, pri_group, production_start, production_end, ica_code', 'length', 'max'=>20),
			array('complect_restr, option_restr, specification', 'length', 'max'=>200),
			array('alter_code', 'length', 'max'=>50),
			array('quantity_in_part', 'length', 'max'=>11),
			array('desc_en, desc_ru', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('model_series, catalog, part_number, part_code, sec_group, pri_group, complect_restr, option_restr, alter_code, production_start, production_end, quantity_in_part, desc_en, desc_ru, specification, ica_code', 'safe', 'on'=>'search'),
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
			'part_number' => 'Part Number',
			'part_code' => 'Part Code',
			'sec_group' => 'Sec Group',
			'pri_group' => 'Pri Group',
			'complect_restr' => 'Complect Restr',
			'option_restr' => 'Option Restr',
			'alter_code' => 'Alter Code',
			'production_start' => 'Production Start',
			'production_end' => 'Production End',
			'quantity_in_part' => 'Quantity In Part',
			'desc_en' => 'Desc En',
			'desc_ru' => 'Desc Ru',
			'specification' => 'Specification',
			'ica_code' => 'Ica Code',
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
		$criteria->compare('part_number',$this->part_number,true);
		$criteria->compare('part_code',$this->part_code,true);
		$criteria->compare('sec_group',$this->sec_group,true);
		$criteria->compare('pri_group',$this->pri_group,true);
		$criteria->compare('complect_restr',$this->complect_restr,true);
		$criteria->compare('option_restr',$this->option_restr,true);
		$criteria->compare('alter_code',$this->alter_code,true);
		$criteria->compare('production_start',$this->production_start,true);
		$criteria->compare('production_end',$this->production_end,true);
		$criteria->compare('quantity_in_part',$this->quantity_in_part,true);
		$criteria->compare('desc_en',$this->desc_en,true);
		$criteria->compare('desc_ru',$this->desc_ru,true);
		$criteria->compare('specification',$this->specification,true);
		$criteria->compare('ica_code',$this->ica_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
		public function getPartCatalog()
    {
		$numargs = func_num_args(); 
        $aPartCatalogs = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('part_catalog')
            ->where('catalog = :catalog AND model_series = :modelSeries AND part_code = :partCode', array(':catalog'=>func_get_arg(0), ':modelSeries'=>func_get_arg(1), ':partCode'=>func_get_arg(2)))
            ->queryAll();
		
		
		if ($numargs > 3)
{
$string1 = array(')','(');
	$string2 = array('', '');
	
	foreach (func_get_arg(4) as $name => $value) 
	{
		$value =  substr($value, (stripos ($value, '(')+1), strlen($value));
			if (substr_count($value, '(')>0) 
			
			{
				$value =  substr($value, (stripos ($value, '(')+1), strlen($value));
			}
			$value = str_replace($string1, $string2, $value);   
    }
	
 
   
 foreach($aPartCatalogs as $index1=>$aPartCatalog)
  	
 {
 	if (func_get_arg(3)!='')
	{
	
	if (Functions::relation(func_get_arg(3))>Functions::relation($aPartCatalog['production_end']))
	
	unset ($aPartCatalogs[$index1]);
	}
	$k=0;
	
	foreach (func_get_arg(4) as $name => $value)
	{
		
	if (substr_count($aPartCatalog['complect_restr'], $value)!=0) 
	$k++;
	
	}
	
	if ($k==0) unset ($aPartCatalogs[$index1]);
	 
 }
 
 
 }

 					
        return $aPartCatalogs;
    }
	
	public function getCatByPartNumber($partNumber)
    {
        $aCatalogs = Yii::app()->db->CreateCommand()
            ->select('catalog')
            ->from('part_catalog')
            ->where('part_number = :partNumber', array(':partNumber'=>$partNumber))
			->group('catalog')
            ->queryAll();
			
		return $aCatalogs;
	}
	
	public function getInfoByCatPartNumber($catalog, $partNumber)
    {
        $aModelSeries = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('part_catalog')
            ->where('catalog = :catalog AND part_number = :partNumber', array(':catalog'=>$catalog, ':partNumber'=>$partNumber))
			->group('model_series')
            ->queryAll();
			
		return $aModelSeries;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PartCatalog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
