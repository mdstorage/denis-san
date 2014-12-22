<?php

/**
 * This is the model class for table "pic_labels".
 *
 * The followings are the available columns in table 'pic_labels':
 * @property string $catalog
 * @property string $model_dir
 * @property string $pic_num
 * @property string $sec_group
 * @property string $page_id
 * @property string $part_code
 * @property string $label_x
 * @property string $label_y
 * @property string $model_series
 */
class PicLabels extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pic_labels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, model_dir, pic_num, sec_group, page_id, part_code, label_x, label_y', 'length', 'max'=>50),
			array('model_series', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, model_dir, pic_num, sec_group, page_id, part_code, label_x, label_y, model_series', 'safe', 'on'=>'search'),
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
			'model_dir' => 'Model Dir',
			'pic_num' => 'Pic Num',
			'sec_group' => 'Sec Group',
			'page_id' => 'Page',
			'part_code' => 'Part Code',
			'label_x' => 'Label X',
			'label_y' => 'Label Y',
			'model_series' => 'Model Series',
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
		$criteria->compare('model_dir',$this->model_dir,true);
		$criteria->compare('pic_num',$this->pic_num,true);
		$criteria->compare('sec_group',$this->sec_group,true);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('part_code',$this->part_code,true);
		$criteria->compare('label_x',$this->label_x,true);
		$criteria->compare('label_y',$this->label_y,true);
		$criteria->compare('model_series',$this->model_series,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getPartCoords($catalog, $modelSeries, $ModelDir, $PicNum, $SecGroup)
    {
        $query = Yii::app()->db->CreateCommand()
            ->select('part_code, label_x, label_y')
            ->from('pic_labels')
            ->where('catalog = :catalog AND model_series=:modelSeries AND model_dir = :ModelDir AND pic_num = :PicNum AND sec_group = :SecGroup', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':ModelDir'=>$ModelDir, ':PicNum'=>$PicNum, ':SecGroup'=>$SecGroup))
		/*	->group('part_code')*/
			->order('part_code');
					
			$aPartCoords = $query->queryAll();

        $oPartCodes = new PartCodes();
 
        foreach($aPartCoords as &$aPartCoord)
		{
           
                $aPartCoord['desc_en'] = $oPartCodes->getDescEnById($catalog, $modelSeries, trim ($aPartCoord['part_code']), $SecGroup);
        }	
				
        return $aPartCoords;
		
		 
    }
	
	public function getInfByPartCode($catalog, $modelSeries, $PartCode)
    {
        $aInfByPartCode = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('pic_labels')
            ->where('catalog = :catalog AND model_series=:modelSeries AND part_code = :PartCode', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':PartCode'=>$PartCode))
			->queryRow();
					
			
        return $aInfByPartCode;
		 
    }
	
	
	
	
	
	
	public function getCatByPartNumber($PartCode)
    {
        $aCatalogs = Yii::app()->db->CreateCommand()
            ->select('catalog')
            ->from('pic_labels')
            ->where('part_code = :partCode', array(':partNumber'=>$PartCode))
			->group('catalog')
            ->queryAll();
			
		return $aCatalogs;
	}
	
	public function getInfoByCatPartNumber($catalog, $PartCode)
    {
        $aModelSeries = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('pic_labels')
            ->where('catalog = :catalog AND part_code = :PartCode', array(':catalog'=>$catalog, ':PartCode'=>$PartCode))
			->group('model_series')
            ->queryRow();
			
		return $aModelSeries;
	}
	
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PicLabels the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
