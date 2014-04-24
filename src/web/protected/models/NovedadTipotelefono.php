<?php

/**
 * This is the model class for table "novedad_tipotelefono".
 *
 * The followings are the available columns in table 'novedad_tipotelefono':
 * @property integer $Id
 * @property integer $NOVEDAD_Id
 * @property integer $TIPOTELEFONO_Id
 *
 * The followings are the available model relations:
 * @property Novedad $nOVEDAD
 * @property TipoNumeroTelefono $tIPOTELEFONO
 */
class NovedadTipotelefono extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'novedad_tipotelefono';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOVEDAD_Id, TIPOTELEFONO_Id', 'required'),
			array('NOVEDAD_Id, TIPOTELEFONO_Id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, NOVEDAD_Id, TIPOTELEFONO_Id', 'safe', 'on'=>'search'),
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
			'nOVEDAD' => array(self::BELONGS_TO, 'Novedad', 'NOVEDAD_Id'),
			'tIPOTELEFONO' => array(self::BELONGS_TO, 'TipoNumeroTelefono', 'TIPOTELEFONO_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'NOVEDAD_Id' => 'Novedad',
			'TIPOTELEFONO_Id' => 'Tipotelefono',
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
		$criteria->compare('NOVEDAD_Id',$this->NOVEDAD_Id);
		$criteria->compare('TIPOTELEFONO_Id',$this->TIPOTELEFONO_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NovedadTipotelefono the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getTipoTelefonoRow($id)
        {
          $tipo_telefono = Array();  
	  $model = self::model()->findAllBySql("SELECT t.Nombre as TIPOTELEFONO_Id FROM tipo_numero_telefono as t  
                                                INNER JOIN novedad_tipotelefono as nt ON t.Id = nt.TIPOTELEFONO_Id 
                                                WHERE nt.NOVEDAD_Id = $id");
          foreach ($model as $key => $value) {
              $tipo_telefono[$key] = $value->TIPOTELEFONO_Id;
          }
          if(!isset($tipo_telefono[0]))
            $tipo_telefono_string = '0';
          else
            $tipo_telefono_string = implode(",", $tipo_telefono);  
          
          return $tipo_telefono_string;
        }
}
