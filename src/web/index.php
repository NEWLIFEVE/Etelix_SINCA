<?php
ob_start();
//zona horaria
date_default_timezone_set("America/Lima");
// change the following paths if necessary
$yii=dirname(__FILE__).'/Yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
require_once($yii);
// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
