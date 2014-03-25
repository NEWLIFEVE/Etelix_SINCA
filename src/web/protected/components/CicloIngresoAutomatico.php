<?php
/**
 * @package components
 * @version 2.0
 */
class CicloIngresoAutomatico extends CApplicationComponent
{

    public function init() 
    {
       
    }

    public function run($dateSet=null)
    {
    	    $correo='cabinasperu@etelix.com';
            $ayer = date( "Y-m-d", strtotime( "-1 day", strtotime( date('Y-m-d', time()) ) ) );
            $dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
            $day = date('w',strtotime($ayer));
            $topic= 'SINCA Status Ciclo de Ingresos "'.$dias[$day].'" '.date("h",time()).':00 '.date("A",time()).' (Ayer)';
            $excel_name= 'SINCA Status Ciclo de Ingresos '.$dias[$day].' '.date("h",time()).'.00 '.date("A",time()).' (Ayer)';
            $files=array();

	    $files['cicloIngreso']['name']=$topic;
            $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso(null,$topic,false,false,$ayer);
            $files['cicloIngreso']['excel']=Yii::app()->reporte->cicloIngreso(null,$topic,false,true,$ayer);
            $files['cicloIngreso']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$excel_name.".xls"; 
	
            if(YII_DEBUG){           
                    Yii::app()->excel->genExcel($files['tab']['name'],utf8_encode($files['tab']['excel']),false);
                    Yii::app()->correo->sendEmail($files['tab']['body'],'pnfiuty.rramirez@gmail.com',$topic,$files['tab']['dir']);
            }else{
//                foreach($files as $key => $file)
//                {   
//                    Yii::app()->excel->genExcel($file['name'],utf8_encode($file['excel']),false);
//                    Yii::app()->correo->sendEmail($file['body'],$correo,$topic,$file['dir']);
//                }
            }
            
            
    }
    
    






}
?>
