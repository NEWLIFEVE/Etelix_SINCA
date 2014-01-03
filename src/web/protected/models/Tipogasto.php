<?php

/**
 * This is the model class for table "tipogasto".
 *
 * The followings are the available columns in table 'tipogasto':
 * @property integer $Id
 * @property string $Nombre
 *
 * The followings are the available model relations:
 * @property Detallegasto[] $detallegastos
 */
class Tipogasto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tipogasto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipogasto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Nombre', 'required'),
			array('Nombre', 'length', 'max'=>145),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Nombre', 'safe', 'on'=>'search'),
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
			'detallegastos' => array(self::HAS_MANY, 'Detallegasto', 'TIPOGASTO_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Nombre' => 'Nombre',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Nombre',$this->Nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public static function getIdGasto($nombre){
            
		if($nombre != null)
		{
			$model=self::model()->find('Nombre=:nombre',array(':nombre'=>$nombre));
			if($model == null)
			{
				$model=new Tipogasto;
				$model->Nombre=$nombre;
				if($model->save())
				{
					return $model->Id;
				}
			}
			else
			{
				return $model->Id;
			}
		}
        }
     
          public static function getListTipoGasto(){
            return CHtml::listData(Tipogasto::model()->findAll(), 'Id', 'Nombre');
        }
}