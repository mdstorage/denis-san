<?php

/**
 * This is the model class for table "models".
 *
 * The followings are the available columns in table 'models':
 * @property string $catalog
 * @property string $model_name
 * @property string $catalog_code
 * @property string $add_codes
 * @property string $prod_start
 * @property string $prod_end
 * @property string $cd
 */
class ModelSeries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'model_series';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, model_series', 'length', 'max'=>10),
			array('model_name, differens, dt_start, dt_end', 'length', 'max'=>50),
			array('rstr_code', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, model_name, catalog_code, add_codes, prod_start, prod_end, cd', 'safe', 'on'=>'search'),
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
			'catalog' => 'Регион',
			'model_name' => 'Наименование модели',
			'differens' => 'Отличия',
			'model_series' => 'Серия модели',
			'dt_start' => 'Дата начала производства',
			'dt_end' => 'Дата снятия с производства',
			'rstr_code' => 'rstrc',
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
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('differens',$this->differens,true);
		$criteria->compare('model_series',$this->model_series,true);
		$criteria->compare('dt_start',$this->dt_start,true);
		$criteria->compare('dt_end',$this->dt_end,true);
		$criteria->compare('rstr_code',$this->rstr_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     * Возвращает список регионов (каталогов)
     */
    public function getCatalogs(){

        $aCatalogs = Yii::app()->db->CreateCommand()
            ->select('catalog')
            ->from('model_series')
            ->group('catalog')
            ->queryAll();

        return $aCatalogs;
    }

    /*
     * Возвращает список наименований моделей для выбранного региона
     */
    public function getModelNames($catalog){

        $aModelNames = Yii::app()->db->CreateCommand()
            ->select('model_name')
            ->from('model_series')
            ->where('catalog = :catalog', array(':catalog'=>$catalog))
            ->group('model_name')
            ->queryAll();

        return $aModelNames;
    }

    /*
     * Возвращает набор кодов по каждой модели (по годам выпуска)
     */
    public function getModelNameCodes($catalog, $modelName)
    {
        $aModelNameCodes = Yii::app()->db->CreateCommand()
            ->select('rstr_code, dt_start, dt_end, differens, model_series')
            ->from('model_series')
            ->where('catalog = :catalog AND model_name = :model_name', array(':model_name'=>$modelName, ':catalog'=>$catalog))
            ->queryAll();

        return $aModelNameCodes;
    }
	
	public function getInfByCatMS($catalog, $modelSeries)
    {
        $aArray = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('model_series')
            ->where('catalog = :catalog AND model_series=:modelSeries', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries))
            ->queryRow();

        return $aArray;
    }

	public function getModelCodes($catalog, $modelSeries)
    {
		$oPosnames = new Posname();
		$aModelCodes = $oPosnames->getPosnames($catalog, $modelSeries);
        return $aModelCodes;
    }
	
	 public function getdiff($catalog, $modelSeries)
    {
        $sdiff = Yii::app()->db->CreateCommand()
            ->select('differens')
            ->from('model_series')
            ->where('catalog = :catalog AND model_series=:modelSeries', array(':catalog'=>$catalog, ':modelSeries'=>$modelSeries))
            ->queryScalar();
			
        return $aDiff = Functions::getNumberSubstring($sdiff);
		
    }
	
    /*
     * Возвращает название модели по региону и коду каталога
     */
    public function getModelNameByCatalog($catalog, $ModelSeries)
    {
        $sModelName = Yii::app()->db->CreateCommand()
            ->select('model_name')
            ->from('model_series')
            ->where('catalog = :catalog AND model_series = :model_series', array(':catalog'=>$catalog, ':model_series'=>$ModelSeries))
            ->queryScalar();

        return $sModelName;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Models the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
