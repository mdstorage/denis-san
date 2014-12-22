<?php

/**
 * This is the model class for table "sec_group_pics".
 *
 * The followings are the available columns in table 'sec_group_pics':
 * @property string $catalog
 * @property string $model_series
 * @property string $sec_group
 * @property string $page_name
 * @property string $img_path
 * @property string $pic_num
 * @property string $model_dir
 * @property string $production_start
 * @property string $production_end
 * @property string $specification
 * @property string $applied_model
 * @property string $options
 */
class SecGroupPics extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sec_group_pics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, sec_group, pic_num, model_dir, production_start, production_end', 'length', 'max'=>10),
			array('model_series, page_name', 'length', 'max'=>20),
			array('img_path, specification, applied_model, options', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, model_series, sec_group, page_name, img_path, pic_num, model_dir, production_start, production_end, specification, applied_model, options', 'safe', 'on'=>'search'),
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
			'catalog' => 'Catalog',
			'model_series' => 'Model Series',
			'sec_group' => 'Sec Group',
			'page_name' => 'Page Name',
			'img_path' => 'Img Path',
			'pic_num' => 'Pic Num',
			'model_dir' => 'Model Dir',
			'production_start' => 'Production Start',
			'production_end' => 'Production End',
			'specification' => 'Specification',
			'applied_model' => 'Applied Model',
			'options' => 'Options',
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

		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('model_series',$this->model_series,true);
		$criteria->compare('sec_group',$this->sec_group,true);
		$criteria->compare('page_name',$this->page_name,true);
		$criteria->compare('img_path',$this->img_path,true);
		$criteria->compare('pic_num',$this->pic_num,true);
		$criteria->compare('model_dir',$this->model_dir,true);
		$criteria->compare('production_start',$this->production_start,true);
		$criteria->compare('production_end',$this->production_end,true);
		$criteria->compare('specification',$this->specification,true);
		$criteria->compare('applied_model',$this->applied_model,true);
		$criteria->compare('options',$this->options,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getSecGroupPics()
	/*public function getSecGroupPics($catalog, $modelSeries, $Id, $data, $options)*/
    {
        $numargs = func_num_args();  
	    $aSecgrouppics = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('sec_group_pics')
            ->where('catalog = :catalog AND model_series = :modelSeries AND sec_group = :Id', array(':catalog'=>func_get_arg(0), ':modelSeries'=>func_get_arg(1), ':Id'=>func_get_arg(2)))
            ->queryAll();




if ($numargs > 3)
{
$string1 = array(')','(');
	$string2 = array('', '');
	
	
	
	
	foreach (func_get_arg(4) as $name => $value) 
	{
		$value =  substr($value, (stripos ($value, '(')+1), strlen($value));
			if (substr_count($value, '(')>0) {$value =  substr($value, (stripos ($value, '(')+1), strlen($value));}
			$value = str_replace($string1, $string2, $value);   
    }
	
   	
	
			
  
   
 foreach($aSecgrouppics as $index1=>$aSecgrouppic)
  	
 {
 	if (func_get_arg(3)!='')
	{
	
	if (Functions::relation(func_get_arg(3))<Functions::relation($aSecgrouppic['production_start']) || Functions::relation(func_get_arg(3))>Functions::relation($aSecgrouppic['production_end']))
	
	unset ($aSecgrouppics[$index1]);
	}
	$k=0;
	
	foreach (func_get_arg(4) as $name => $value)
	{
	if (substr_count($aSecgrouppic['options'], $value)!=0) 
	$k++;	
	}
	if (($k==0)&($aSecgrouppic['options']!='ALL') & (count($aSecgrouppics)>1)) unset ($aSecgrouppics[$index1]);
	
 }
 
 }
	
        return $aSecgrouppics;
    }
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SecGroupPics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
