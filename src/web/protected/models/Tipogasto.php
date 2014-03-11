<?php

/**
 * This is the model class for table "tipogasto".
 *
 * The followings are the available columns in table 'tipogasto':
 * @property integer $Id
 * @property string $Nombre
 * @property integer $category_id
 *
 * The followings are the available model relations:
 * @property Detallegasto[] $detallegastos
 * @property Category $category
 */
class Tipogasto extends CActiveRecord
{
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
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('Nombre', 'length', 'max'=>145),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Nombre, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
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
			'category_id' => 'Category',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tipogasto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getIdGasto($nombre,$categoria){
            
		if($nombre != null || $categoria!= null)
		{
			$model=self::model()->find('Nombre=:nombre',array(':nombre'=>$nombre));
			if($model == null)
			{
				$model=new Tipogasto;
				$model->Nombre=$nombre;
                                $model->category_id=$categoria;
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
        
        public static function getListTipoGastoCategoria($tipo)
	{
            return CHtml::listData(Tipogasto::model()->findAll('category_id=:category_id',array(':category_id'=>$tipo)), 'Id', 'Nombre');
	}
}
