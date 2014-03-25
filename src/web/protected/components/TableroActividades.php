<?php
/**
 * @package components
 * @version 2.0
 */
class TableroActividades extends CApplicationComponent
{

    public function init() 
    {
       
    }

    public function run($dateSet=null)
    {
    	    $correo='pnfiuty.rramirez@gmail.com';
             
            $date = date('Y-m-d', time());
            $topic= 'SINCA Tablero de Control de Actividades '.$date;  
            $files=array();
        
	    $files['tab']['name']=$topic;
            $files['tab']['body']=Yii::app()->reporte->tableroControl($date,$topic);
            $files['tab']['excel']=Yii::app()->reporte->tableroControl($date,$topic);
            $files['tab']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['tab']['name'].".xls";
	
            foreach($files as $key => $file)
            {   
                Yii::app()->excel->genExcel($file['name'],utf8_encode($file['excel']),false);
                Yii::app()->correo->sendEmail($file['body'],$correo,$topic,$file['dir']);
            }
            
            
    }
    
    






}
?>