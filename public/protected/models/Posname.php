<?php

/**
 * This is the model class for table "posname".
 *
 * The followings are the available columns in table 'posname':
 * @property string $catalog
 * @property string $model_series
 * @property integer $pos_num
 * @property string $start_date
 * @property string $end_date
 * @property string $f1
 * @property string $f2
 * @property string $f3
 * @property string $f4
 * @property string $f5
 * @property string $f6
 * @property string $f7
 * @property string $f8
 */
class Posname extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'posname';
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
			array('catalog, start_date, end_date', 'length', 'max'=>10),
			array('model_series', 'length', 'max'=>20),
			array('f1, f2, f3, f4, f5, f6, f7, f8', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, model_series, pos_num, start_date, end_date, f1, f2, f3, f4, f5, f6, f7, f8', 'safe', 'on'=>'search'),
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
			'pos_num' => 'Pos Num',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'f1' => 'F1',
			'f2' => 'F2',
			'f3' => 'F3',
			'f4' => 'F4',
			'f5' => 'F5',
			'f6' => 'F6',
			'f7' => 'F7',
			'f8' => 'F8',
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
		$criteria->compare('pos_num',$this->pos_num);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('f1',$this->f1,true);
		$criteria->compare('f2',$this->f2,true);
		$criteria->compare('f3',$this->f3,true);
		$criteria->compare('f4',$this->f4,true);
		$criteria->compare('f5',$this->f5,true);
		$criteria->compare('f6',$this->f6,true);
		$criteria->compare('f7',$this->f7,true);
		$criteria->compare('f8',$this->f8,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	 public function getPosnames($catalog, $modelSeries)
    {
        $aPosnames = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('posname')
            ->where('catalog = :catalog AND model_series=:modelSeries', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries))
            ->queryAll();
			
			$aPosnames=$this->getAbbrevs($aPosnames);
			
        return $aPosnames;
    }
	
	 public function getPosnum($catalog, $modelSeries, $f1, $f2, $f3, $f4, $f5, $f6, $f7, $f8)
    {
        $Posnum = Yii::app()->db->CreateCommand()
            ->select('pos_num')
            ->from('posname')
            ->where('catalog = :catalog AND model_series=:modelSeries AND f1=:f1 AND f2=:f2 AND f3=:f3 AND f4=:f4 AND f5=:f5 AND f6=:f6 AND f7=:f7 AND f8=:f8', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries, ':f1'=>$f1, ':f2'=>$f2, ':f3'=>$f3,':f4'=>$f4,':f5'=>$f5,':f6'=>$f6,':f7'=>$f7,':f8'=>$f8))
            ->queryScalar();
			
			
        return $Posnum;
    }
	
	 public function getComplByPosnumDate($catalog, $modelSeries, $pos, $date)
    {
        $aquery = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('posname')
            ->where('catalog = :catalog AND model_series=:modelSeries', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries))
            ->queryAll();
			
		$Aquerys = $this->getAbbrevs($aquery);	
		$aComplectation = array();
		foreach ($Aquerys as $Aquery)
		{
			if (($Aquery['pos_num'] === $pos) & (Functions::relation($Aquery['end_date'])>=Functions::relation($date)) & (Functions::relation($Aquery['start_date'])<=Functions::relation($date)))
			$aComplectation = $Aquery; 
		}
		
        return $aComplectation;
    }
	
	
 
 	private function getAbbrevs($aPosnames)
 {
 	$oAppnames = new Appnames();
	
	foreach ($aPosnames as &$aPosname) {
		$catalog = $aPosname['catalog'];
		$modelSeries = $aPosname['model_series'];
		$aPosname['f1'] = $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f1']) . ' (' . $aPosname['f1'] . ')';
		$aPosname['f2'] = $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f2']) . ' (' . $aPosname['f2'] . ')';
		$aPosname['f3'] = $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f3']) . ' (' . $aPosname['f3'] . ')';
		$aPosname['f4'] = $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f4']) . ' (' . $aPosname['f4'] . ')';
		$aPosname['f5'] = $aPosname['f5'] ? $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f5']) . ' (' . $aPosname['f5'] . ')':null;
		$aPosname['f6'] = $aPosname['f6'] ? $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f6']) . ' (' . $aPosname['f6'] . ')':null;
		$aPosname['f7'] = $aPosname['f7'] ? $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f7']) . ' (' . $aPosname['f7'] . ')':null;
		$aPosname['f8'] = $aPosname['f8'] ? $oAppnames->getDescEn($catalog, $modelSeries, $aPosname['f8']) . ' (' . $aPosname['f8'] . ')':null;
		}
		return $aPosnames;
	}


 
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Posname the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
