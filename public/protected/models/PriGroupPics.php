<?php

/**
 * This is the model class for table "pri_group_pics".
 *
 * The followings are the available columns in table 'pri_group_pics':
 * @property string $catalog
 * @property string $model_series
 * @property string $pri_group
 * @property string $img_path
 * @property integer $label_x
 * @property integer $label_y
 * @property string $model_dir
 */
class PriGroupPics extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pri_group_pics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label_x, label_y', 'numerical', 'integerOnly'=>true),
			array('catalog, model_series, pri_group, model_dir', 'length', 'max'=>20),
			array('img_path', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, model_series, pri_group, img_path, label_x, label_y, model_dir', 'safe', 'on'=>'search'),
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
			'pri_group' => 'Pri Group',
			'img_path' => 'Img Path',
			'label_x' => 'Label X',
			'label_y' => 'Label Y',
			'model_dir' => 'Model Dir',
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
		$criteria->compare('pri_group',$this->pri_group,true);
		$criteria->compare('img_path',$this->img_path,true);
		$criteria->compare('label_x',$this->label_x);
		$criteria->compare('label_y',$this->label_y);
		$criteria->compare('model_dir',$this->model_dir,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getPriGroupPics($catalog, $modelSeries)
    {
        $aPriGroupPics = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('pri_group_pics')
            ->where('catalog = :catalog AND model_series=:modelSeries', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries))
			->group('model_dir')
            ->queryAll();	
        return $aPriGroupPics;
    }
	
	public function getPriGroupCoords($catalog, $modelSeries)
    {
        $query = Yii::app()->db->CreateCommand()
            ->select('model_dir, pri_group, label_x, label_y')
            ->from('pri_group_pics')
            ->where('catalog = :catalog AND model_series=:modelSeries', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries))
			->order('pri_group');
					
			$aPriGroupCoords = $query->queryAll();

        $oPriGroups = new PriGroups();
		$k = 0;
 
        foreach($aPriGroupCoords as &$aPriGroupCoord)
		{
           
                $aPriGroupCoord['desc_en'] = $oPriGroups->getDescEnById($catalog, $modelSeries, $aPriGroupCoord['pri_group']);
	/*			$aPriGroupCoord['num'] = $k;
				$k++;*/
        }	
				
        return $aPriGroupCoords;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PriGroupPics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
