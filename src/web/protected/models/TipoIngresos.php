<?php

/**
 * This is the model class for table "tipo_ingresos".
 *
 * The followings are the available columns in table 'tipo_ingresos':
 * @property integer $Id
 * @property string $Nombre
 *
 * The followings are the available model relations:
 * @property Detalleingreso[] $detalleingresos
 */
class TipoIngresos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_ingresos';
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
			array('Nombre', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
			'detalleingresos' => array(self::HAS_MANY, 'Detalleingreso', 'TIPOINGRESO_Id'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoIngresos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getListTipoGIngreso(){
            return CHtml::listData(TipoIngresos::model()->findAll(), 'Id', 'Nombre');
        }
        
        public static function getIdIngreso($nombre){
            
		if($nombre != null)
		{
			$model=self::model()->find('Nombre=:nombre',array(':nombre'=>$nombre));
			if($model == null)
			{
				$model=new TipoIngresos;
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
}
