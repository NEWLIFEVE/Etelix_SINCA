<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activkey
 * @property integer $superuser
 * @property integer $status
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $CABINA_Id
 * @property integer $tipo
 *
 * The followings are the available model relations:
 * @property Log[] $logs
 * @property Profiles $profiles
 * @property Tipousuario $tipo0
 * @property Cabina $cABINA
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_at', 'required'),
			array('superuser, status, CABINA_Id, tipo', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password, email, activkey', 'length', 'max'=>128),
			array('lastvisit_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, activkey, superuser, status, create_at, lastvisit_at, CABINA_Id, tipo', 'safe', 'on'=>'search'),
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
			'logs' => array(self::HAS_MANY, 'Log', 'USERS_Id'),
			'profiles' => array(self::HAS_ONE, 'Profiles', 'user_id'),
			'tipo0' => array(self::BELONGS_TO, 'Tipousuario', 'tipo'),
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'activkey' => 'Activkey',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'create_at' => 'Create At',
			'lastvisit_at' => 'Lastvisit At',
			'CABINA_Id' => 'Cabina',
			'tipo' => 'Tipo',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public static function UsuariosPorTipo($tipoUsuario)
            {
               $sql="SELECT username FROM users where tipo IN ($tipoUsuario);";
                        $connection=Yii::app()->db; 
                        $command=$connection->createCommand($sql);       
                        $id=$command->query(); // execute a query SQL
                        
                        for ($i = 0; $i < $id->count(); $i++) {
                            $arreglo[$i] = $id->readColumn(0);
                        } 
                        return $arreglo;
            }
                            
        public static function getListUsers($cabina)
    {
		return CHtml::listData(Users::model()->findAll('status=:status AND CABINA_Id=:cabina',array(':status'=>'1',':cabina'=>$cabina)), 'id', 'username');	

    }

    public static function getArrayWorkmateUsers($idCabina){
        $i=0;
        $array = array();
        $resulset = Users::model()->findAllBySql('SELECT id FROM users WHERE status=:status AND CABINA_Id=:cabina;',array(':status'=>1,':cabina'=>$idCabina));
        foreach ($resulset as $value){
            $array[$i++]=$value->id;
        }
        return $array;
    }
    
    public static function getCabinaIDFromUser($userID){
        $resulset = Users::model()->find('id=:userID AND status=:status',array(':userID'=>$userID,':status'=>1));
        return $resulset->CABINA_Id;
    }

}