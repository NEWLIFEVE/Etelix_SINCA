<?php
/**
* 
*/
class TableroActCommand extends CConsoleCommand
{
	public function run($args)
	{
            if($args){
                $date = date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));
                Yii::app()->controlactividades->run($date);
            }else{
                Yii::app()->controlactividades->run();
            }    
        }
}
?>