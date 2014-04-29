<?php
/**
 * @package components
 * @version 1.0
 */
class ConsolidadoAutomatico extends CApplicationComponent
{

    public function init() 
    {
       
    }
    
    /**
     * Ejecuta el comando de ciclo de ingreso total automatico
     * @access public
     * @param date $dateSet
     * @author Ramon Ramirez
     */
    public function run($dateSet)
    {
            $ultimo_dia = date('Y-m-j',strtotime("-6 day",strtotime($dateSet)));
            $dia = $dateSet;
    	    $name = 'SINCA Reporte Consolidado de Fallas ('.$ultimo_dia.'_'.$dia.')';
            $dir = Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$name.".xlsx";
            
            $cuerpo = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;>".str_replace("_","/",$name)."<h2>";
            
            $body = Yii::app()->reporte->reporteConsolidado($dia,$name,$dir);
            
            if(YII_DEBUG){
                   $correo = 'auto@etelix.com';
            }else{
                   $correo = '';
            }
            
            Yii::app()->correo->sendEmail($cuerpo,$correo,$name,$dir);
            
            echo $dateSet;
    }
}

