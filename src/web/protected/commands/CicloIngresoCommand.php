<?php
/**
* 
*/
class CicloIngresoCommand extends CConsoleCommand
{
	public function run($args)
	{
            Yii::app()->cicloingreso->run();
        }
}
?>