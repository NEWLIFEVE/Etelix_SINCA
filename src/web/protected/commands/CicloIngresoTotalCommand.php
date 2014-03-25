<?php
/**
* 
*/
class CicloIngresoTotalCommand extends CConsoleCommand
{
	public function run($args)
	{
            Yii::app()->cicloingresototal->run();
        }
}
?>