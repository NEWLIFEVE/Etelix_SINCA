<?php
/**
* 
*/
class TableroActCommand extends CConsoleCommand
{
	public function run($args)
	{
            if($args[0]=='false')
                $date = date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));
            elseif($args[0]=='true')
                $date = date('Y-m-d', mktime(0, 0, 0, date('m'),date('d'),date('Y')));
            
            Yii::app()->controlactividades->run($date);
        }
}
?>