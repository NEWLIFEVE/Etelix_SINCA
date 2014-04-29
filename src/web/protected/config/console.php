<?php
//Obtenemos el nombre del servidor actual 
$server=gethostname();
if($server==SERVER_NAME_PROD)
{
	$server=dirname(__FILE__);
	$nuevo=explode(DIRECTORY_SEPARATOR,$server);
	$num=count($nuevo);
	if($nuevo[$num-3]==DIRECTORY_NAME_PRE_PROD)
	{
	$server_db='localhost';
        $sinca_db='sinca';
        $user_db='root';
        $pass_db='Nsusfd8263';
        $user_db_sori='postgres';
        $sori_db='sori';
	}
	else
	{
	$server_db='localhost';
        $sinca_db='sinca';
        $user_db='root';
        $pass_db='Nsusfd8263';
        $user_db_sori='postgres';
        $sori_db='sori';
	}
}
else
{
	$server_db='172.16.17.190';
    $sinca_db='sinca';
    $user_db='manuelz';
    $pass_db='123';
    $user_db_sori='postgres';
        $sori_db='sori';
}

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	// preloading 'log' component
	'preload'=>array('log'),
        'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
		'application.modules.user.components.*',
		'application.components.reportes.*'
		),
	// application components
	'components'=>array(
		'controlactividades'=>array(
			'class'=>"application.components.TableroActividades",
			),
		'cicloingreso'=>array(
			'class'=>"application.components.CicloIngresoAutomatico",
			),
		'cicloingresototal'=>array(
			'class'=>"application.components.CicloIngresoTotalAutomatico",
			),
                'consolidadoresumido'=>array(
			'class'=>"application.components.ConsolidadoResumidoAutomatico",
			),
                'consolidado'=>array(
			'class'=>"application.components.ConsolidadoAutomatico",
			),        
		'recordatorio'=>array(
			'class'=>"application.components.Recordatorio",
			),
		'correo'=>array(
			'class'=>'application.components.EnviarEmail'
			),
		'excel'=>array(
			'class'=>'application.components.Excel'
			),
		'reporte'=>array(
			'class'=>'application.components.Reportes'
			),        
		'user'=>array(
			'class'=>'WebUser',
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
			'loginUrl'=>array('/user/login'),
			),
			// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'recargas/<action:\w+>/<compania:\w+>'=>'recargas/<action>/view',

				),
			),
		// uncomment the following to use a MySQL database
		'importcsv'=>array(
			'path'=>'upload/importCsv/', // path to folder for saving csv file and file with import params
            ),
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>'mysql:host='.$server_db.';port=3306;dbname='.$sinca_db,
			'emulatePrepare'=>true,
                        'username'=>$user_db,
			'password'=>$pass_db,
			'charset'=>'utf8',        
			),
                'soriDB'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>'pgsql:host='.$server_db.';port=5432;dbname='.$sori_db,
			'username'=>$user_db_sori,
			'password'=>$pass_db,
			'charset'=>'utf8',
			),        
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					),
				// uncomment the following to show log messages on web pages
				//array(
				//	'class'=>'CWebLogRoute',
				//		),
				),
			),
		'format'=>array(
			'class'=>'application.components.Formatter',
			'numberFormat'=>array(
				'decimals'=>2,
				'decimalSeparator'=>'.',
				'thousandSeparator'=>''
				),
			),
		),

	);