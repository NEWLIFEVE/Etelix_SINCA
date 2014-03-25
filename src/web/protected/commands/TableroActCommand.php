<?php
/**
* 
*/
class TableroActCommand extends CConsoleCommand
{
	public function run($args)
	{
            Yii::app()->controlactividades->run();
        }
}
?>