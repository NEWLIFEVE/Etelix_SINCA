<?php
/**
 * @package components
 * @version 2.0
 */
class Recordatorio extends CApplicationComponent
{

    public function init() 
    {
       
    }

    public function run($dateSet=null)
    {
    	    $correo='pnfiuty.rramirez@gmail.com';
            $topic= "Recordatorio";  
            $files=array();
        
	    $files['tab']['name']=$topic;
            $files['tab']['body']='<html>
                                    <head>
                                    </head>

                                    <body style="font-family:Arial;">
                                        <div style="background-color:#e4fde4;padding:0.9% 3%;border:1 solid;">
                                            <h4>Estimados empleados</h4>

                                            <p>Les recordamos que es necesario y obligatorio que el empleado encargado de cerrar la cabina 
                                               declare el saldo de cierre y la hora de fin de jornada. El empleado que no declare
                                               los datos solicitados ser&aacute; penalizado.</p>

                                            <p>Agradeciendo su colaboraci&oacute;n para el desarrollo de la empresa nos despedimos.</p>

                                            <p>Copyright 2013 by <a href="www.sacet.com.ve">www.sacet.com.ve</a> Legal privacy</p>

                                        </div>
                                    </body>

                                </html>';
	
            foreach($files as $key => $file)
            {   
                Yii::app()->correo->sendEmail($file['body'],$correo,"Recordatorio",null);
            }
            
            
    }
    
    






}
?>
