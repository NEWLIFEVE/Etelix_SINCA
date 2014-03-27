<?php
/**
 * @package components
 * @version 1.0
 */
class TableroActividades extends CApplicationComponent
{

    public function init() 
    {
       
    }

    public function run($dateSet)
    {
    	    $correo='cabinasperu@etelix.com';
            $correo_rrhh='rrhh@sacet.biz';
            
            $date = $dateSet;
            
            $topic= 'SINCA Tablero de Control de Actividades '.$date;  
            $files=array();
        
	    $files['tab']['name']=$topic;
            $files['tab']['body']=Yii::app()->reporte->tableroControl($date,$topic);
            $files['tab']['excel']=Yii::app()->reporte->tableroControl($date,$topic);
            $files['tab']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['tab']['name'].".xls";
            
            
            if(YII_DEBUG){           
                    Yii::app()->excel->genExcel($files['tab']['name'],utf8_encode($files['tab']['excel']),false);
                    Yii::app()->correo->sendEmail($files['tab']['body'],'auto@etelix.com',$topic,$files['tab']['dir']);
            }else{
               foreach($files as $key => $file)
               {   
                   Yii::app()->excel->genExcel($file['name'],utf8_encode($file['excel']),false);
                   Yii::app()->correo->sendEmail($file['body'],$correo,$topic,$file['dir']);
                   Yii::app()->correo->sendEmail($file['body'],$correo_rrhh,$topic,$file['dir']);
               }
            }
            
            
            
    }
    
    






}
?>
