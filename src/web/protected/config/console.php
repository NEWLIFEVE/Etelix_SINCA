<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SINCA Consola',
	'timeZone'=>'America/Lima',
	'charset'=>'utf-8',
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
		'costocaptura'=>array(
			'class'=>"application.components.GenerarCostoCapturaAutomatico",
			),
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