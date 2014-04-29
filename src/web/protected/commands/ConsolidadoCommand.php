<?php
/**
* 
*/
class ConsolidadoCommand extends CConsoleCommand
{
	public function run($args)
	{
            $date = $args[0];
            Yii::app()->consolidado->run($date);
        }
}


?>
