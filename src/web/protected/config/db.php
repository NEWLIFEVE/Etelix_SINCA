<?php
// Solo contiene la informacion de conexion de base de datos
return array(
	'components'=>array(
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>'mysql:host=172.16.17.190;port=3306;dbname=sinca2',
			'emulatePrepare'=>true,
            'username'=>'manuelz',
			'password'=>'123',
			'charset'=>'utf8',
			'enableProfiling'=>true,
        	'enableParamLogging'=>true,      
			),
		'soriDB'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>'pgsql:host=172.16.17.190;port=5432;dbname=sori',
			'username'=>'postgres',
			'password'=>'123',
			'charset'=>'utf8',
			'enableProfiling'=>true,
        	'enableParamLogging'=>true,
			)
		)  
	);