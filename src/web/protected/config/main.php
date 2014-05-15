<?php

$server=$_SERVER['SERVER_NAME'];
switch ($server)
{
    case SERVER_NAME_PROD:
        $server_db='localhost';
        $sinca_db='sinca';
        $sori_db='sori';
        $user_db='root';
        $user_db_sori='postgres';
        $pass_db='Nsusfd8263';
        break;
    case SERVER_NAME_PRE_PROD:
        $server_db='localhost';
        $sinca_db='sinca';
        $sori_db='sori';
        $user_db='root';
        $user_db_sori='postgres';
        $pass_db='Nsusfd8263';
        break;
    case SERVER_NAME_DEV:
    default:
        $server_db='172.16.17.190';
        $sinca_db='sinca2';
        $sori_db='sori';
        $user_db='manuelz';
        $user_db_sori='postgres';
        $pass_db='123';
        break;
}
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'S I N C A',
	'language'=>'es',
	'timeZone'=>'America/Lima',
	'charset'=>'utf-8',
	'theme'=>'mattskitchen',
	'defaultController'=>'user/login',
	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',
        'application.modules.user.components.PHPExcel.*',
		'application.components.reportes.*'
		),
	'modules'=>array(
	// uncomment the following to enable the Gii tool
		'user'=>array(
		# encrypting method (php hash function)
			'hash'=>'md5',
			# send activation email
			'sendActivationMail'=>true,
			# allow access for non-activated users
			'loginNotActiv'=>false,
			# activate user on registration (only sendActivationMail = false)
			'activeAfterRegister'=>false,
			# automatically login from registration
			'autoLogin'=>true,
			# registration path
			'registrationUrl'=>array('/user/registration'),
			# recovery password path
			'recoveryUrl'=>array('/user/recovery'),
			# login form path
			'loginUrl'=>array('/user/login'),
			# page after login
			'returnUrl'=>array('/user/profile'),
			# page after logout
			'returnLogoutUrl'=>array('/user/login'),
			),
		),
		// application components
	'components'=>array(
		'reporte'=>array(
			'class'=>'application.components.Reportes'
			),
		'correo'=>array(
			'class'=>'application.components.EnviarEmail'
			),
                'excel'=>array(
			'class'=>'application.components.Excel'
			), 
                'utility'=>array(
			'class'=>'application.components.Utility'
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
		'errorHandler'=>array(
		// use 'site/error' action to display errors
			'errorAction'=>'site/error',
			),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
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
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'manuelz@sacet.biz',
	),
);
