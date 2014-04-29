<?php
/**
* 
*/
class ConsolidadoResumidoCommand extends CConsoleCommand
{
	public function run($args)
	{
            $date = $args[0];
            Yii::app()->consolidadoresumido->run($date);
        }
}


?>
