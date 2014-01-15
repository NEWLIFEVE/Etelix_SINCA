<?php

/**
 * This is the model class for table "comparativos".
 *
 * The followings are the available columns in table 'comparativos':
 * @property integer $Id
 * @property string $Fecha
 * @property string $RecargaVentasMov
 * @property string $RecargaVentasClaro
 * @property string $TraficoCapturaDollar
 * @property integer $CABINA_Id
 *
 * The followings are the available model relations:
 * @property Cabina $cABINA
 */
class Comparativos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comparativos the static model class
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
		return 'comparativos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, CABINA_Id', 'required'),
			array('CABINA_Id', 'numerical', 'integerOnly'=>true),
			array('RecargaVentasMov, RecargaVentasClaro, TraficoCapturaDollar', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Fecha, RecargaVentasMov, RecargaVentasClaro, TraficoCapturaDollar, CABINA_Id', 'safe', 'on'=>'search'),
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
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Fecha' => 'Fecha',
			'RecargaVentasMov' => 'Recarga Ventas Mov',
			'RecargaVentasClaro' => 'Recarga Ventas Claro',
			'TraficoCapturaDollar' => 'Trafico Captura Dollar',
			'CABINA_Id' => 'Cabina',
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
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('RecargaVentasMov',$this->RecargaVentasMov,true);
		$criteria->compare('RecargaVentasClaro',$this->RecargaVentasClaro,true);
		$criteria->compare('TraficoCapturaDollar',$this->TraficoCapturaDollar,true);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}