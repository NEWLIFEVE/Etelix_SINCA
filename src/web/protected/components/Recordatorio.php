<?php
/**
 * @package components
 * @version 1.0
 */
class Recordatorio extends CApplicationComponent
{

    public function init() 
    {
       
    }

    public function run($dateSet=null)
    {
            //CORREOS DE LAS CABINAS    
    	    $sql="SELECT DISTINCT(u.email) as email from users u, cabina c  where u.CABINA_Id IS NOT NULL and c.id not in (18,19) and c.status = 1 and u.CABINA_Id = c.id;";
            $emailsCabinas = Users::model()->findAllBySql($sql);

            $topic= "Recordatorio";  
            $files='';
            $files='<html>
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
            
            if(YII_DEBUG){           
                    Yii::app()->correo->sendEmail($files,'auto@etelix.com',$topic,null);
            }else{
               foreach ($emailsCabinas as $value) {
                   Yii::app()->correo->sendEmail($files,$value->email,$topic,null);
               }
            }
                
            
            
            
    }
    
    






}
?>
