<?php
date_default_timezone_set('America/Caracas'); 
//Definimos nuestro servidor de produccion 
define('SERVER_NAME_PROD','sinca.sacet.com.ve'); 
//Definimos nuestro servidor de preproduccion 
define('SERVER_NAME_PRE_PROD','devsinca.sacet.com.ve'); 
//Definimos nuestro servidor de desarrollo 
define('SERVER_NAME_DEV','sinca.local'); 
//Obtenemos el nombre del servidor actual 
$server=$_SERVER['SERVER_NAME']; 
// change the following paths if necessary




$yii=dirname(__FILE__).'/../../../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';


switch ($server)
{
	case SERVER_NAME_PROD:
		defined('YII_DEBUG') or define('YII_DEBUG',false);
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
		break;
	case SERVER_NAME_PRE_PROD:
		defined('YII_DEBUG') or define('YII_DEBUG',true);
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
		break;
	case SERVER_NAME_DEV:
	default:
		defined('YII_DEBUG') or define('YII_DEBUG',true);
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
		break;
}


// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createConsoleApplication($config)->run();
