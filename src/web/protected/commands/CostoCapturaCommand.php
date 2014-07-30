<?php
/**
* 
*/
class CostoCapturaCommand extends CConsoleCommand
{
	public function run($args)
	{

            Yii::app()->costocaptura->run();
        }
}
?>