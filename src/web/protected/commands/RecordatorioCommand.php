<?php
/**
* 
*/
class RecordatorioCommand extends CConsoleCommand
{
	public function run($args)
	{
            Yii::app()->recordatorio->run();
        }
}
?>