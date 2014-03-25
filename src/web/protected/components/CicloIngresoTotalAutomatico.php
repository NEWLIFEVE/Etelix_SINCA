<?php
/**
 * @package components
 * @version 2.0
 */
class CicloIngresoTotalAutomatico extends CApplicationComponent
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
            $topic= 'SINCA Total Diario Ciclo de Ingresos "'.$dias[$day].'" '.date("h",time()).':00 '.date("A",time()).' (Hasta Ayer)';
            $excel_name= 'SINCA Total Diario Ciclo de Ingresos '.$dias[$day].' '.date("h",time()).'.00 '.date("A",time()).' (Hasta Ayer)';
            $files=array();

	    $files['cicloIngresoT']['name']=$topic;
            $files['cicloIngresoT']['body']=Yii::app()->reporte->cicloIngresoTotal(null,$topic,false,false,$ayer);
            $files['cicloIngresoT']['excel']=Yii::app()->reporte->cicloIngresoTotal(null,$topic,false,true,$ayer);
            $files['cicloIngresoT']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$excel_name.".xls";  
	
            if(YII_DEBUG){
                    Yii::app()->excel->genExcel($excel_name,utf8_encode($files['cicloIngresoT']['excel']),false);
                    Yii::app()->correo->sendEmail($files['cicloIngresoT']['body'],'auto@etelix.com',$topic,$files['cicloIngresoT']['dir']);
            }else{
               foreach($files as $key => $file)
               {   
                   Yii::app()->excel->genExcel($file['name'],utf8_encode($file['excel']),false);
                   Yii::app()->correo->sendEmail($file['body'],$correo,$topic,$file['dir']);
               }
            }
            
            
    }
    
    






}
?>
