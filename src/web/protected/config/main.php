<?php
$server=$_SERVER['SERVER_NAME'];
switch ($server)
{
    case SERVER_NAME_PROD:
        $server_db='localhost';
        $sinca_db='sinca';
        $user_db='root';
        $pass_db='123';
        break;
    case SERVER_NAME_PRE_PROD:
        $server_db='localhost';
        $server_db='sinca';
        $user_db='root';
        $pass_db='Nsusfd8263';
        break;
    case SERVER_NAME_DEV:
    default:
        $server_db='172.16.17.190';
        $sinca_db='sinca';
        $user_db='manuelz';
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
		'application.components.reportes.*'
		),
	'modules'=>array(
	// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'654321',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			),
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
		'errorHandler'=>array(
		// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'manuelz@sacet.biz',
	),
);
