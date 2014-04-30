<?php
/**
 * Funciones para implementar en toda la aplicacion.
 */
class Utility
{
    public function init()
    {
        
    }
    
    public static function ChangeTime($hora)
    {
		$doce = 12;
		if($hora[1] == ':')
		{
			if($hora[5] == 'A')
			{
				$horaMod = '0'.substr($hora, -7, 4).':00';
			}
			else
			{
				$horaMod = substr($hora, -7, 2)+$doce.substr($hora, -6, 3).':00';
			}
		}
		else if($hora[1] == '2')
		{
			if($hora[6] == 'A')
			{
				$horaMod = '00'.substr($hora, -6, 3).':00';
			}
			else
			{
				$horaMod = substr($hora, -8, 5).':00';
			}
		}
		else
		{
			if($hora[6] == 'A')
			{
				$horaMod = substr($hora, -8, 5).':00';
			}
			else
			{
				$horaMod = substr($hora, -8, 2)+$doce.substr($hora, -6, 3).':00';
			}
		}
		return $horaMod;
	}

	/**
	 * Encargada de cambiar las comas recibidas por un punto.
     * @access public
     * @static
     */
    public static function ComaPorPunto($monto)
	{
		for ($i = 0; $i < strlen($monto); $i++)
		{
			if ($monto{$i} == ',')
			{
				$monto{$i} = '.';
            }
            return $monto;
    	}
    }

    /**
     * @access public
     * @static
     */
    public static function PuntoPorComa($monto)
    {
        $find = Array('S/.','USD$');
        $htmlWithoutSimbol = str_replace($find,' ',$monto);
        $htmlWithoutPoint = str_replace('.',',',$htmlWithoutSimbol);
        return $htmlWithoutPoint;
    }

    /**
     * funcion que valida la hora pasada como parametro
     * @access public
     * @static
     */
    public static function hora($hora=null,$var=true)
    {
    	if(isset($hora) && isset($var))
    	{
    		if($var == true)
    		{
    			if(date('H',time()) > $hora)
    			{
    				return true;
    			}
    			else
    			{
    				return false;
    			}
    		}
    		elseif($var == false)
    		{
    			if(date('H',time()) < $hora)
    			{
    				return true;
    			}
    			else
    			{
    				return false;
    			}
    		}
    	}
    }

    /**
     * @access public
     * @static
     */
    public static function ver($userType)
    {
        $arreglo = array();
        $arregloView = array();
        $arregloUpdate = array();
        $arregloDelete = array();

            if($userType == 1 || $userType == 5)
            {   
                $arregloView['label']='Detalle';
                $arregloView['imageUrl']=Yii::app()->request->baseUrl."/themes/mattskitchen/img/view.png";
                $arregloUpdate['visible']='false';
                $arregloDelete['visible']='false';
                $arreglo['view']=$arregloView;
                $arreglo['update']=$arregloUpdate;
                $arreglo['delete']=$arregloDelete;
                return $arreglo;
            }
            else
            {
                $arregloView['label']='Detalle';
                $arregloView['imageUrl']=Yii::app()->request->baseUrl."/themes/mattskitchen/img/view.png";
                $arregloUpdate['label']='Editar';
                $arregloUpdate['imageUrl']=Yii::app()->request->baseUrl."/themes/mattskitchen/img/update.png";
                $arregloDelete['visible']='false';
                $arreglo['view']=$arregloView;
                $arreglo['update']=$arregloUpdate;
                $arreglo['delete']=$arregloDelete;
                return $arreglo;
            }
        
        
    }
    
    public static function verParcial($Type)
    {
        $arreglo = array();
        $arregloView = array();
        $arregloUpdate = array();
        $arregloDelete = array();
        
            if($Type == 1)
            {   
                $arregloView['label']='Detalle';
                $arregloView['imageUrl']=Yii::app()->request->baseUrl."/themes/mattskitchen/img/view.png";
                $arregloUpdate['visible']='false';
                $arregloDelete['visible']='false';
                $arreglo['view']=$arregloView;
                $arreglo['update']=$arregloUpdate;
                $arreglo['delete']=$arregloDelete;
                return $arreglo;
            }
            elseif($Type == 2)
            {
                $arregloUpdate['label']='Editar';
                $arregloUpdate['imageUrl']=Yii::app()->request->baseUrl."/themes/mattskitchen/img/update.png";
                $arregloView['visible']='false';
                $arregloDelete['visible']='false';
                $arreglo['view']=$arregloView;
                $arreglo['update']=$arregloUpdate;
                $arreglo['delete']=$arregloDelete;
                return $arreglo;
            }
        
        
    }

    /**
     * @access public
     * @static
     */
    public static function notNull($dato)
    {
    	if($dato == NULL)
    	{
    		return 0.00;
    	}
    	else
    	{
    		if(is_numeric($dato))
            {
                if($dato>0)
                {
                    return $dato;
                }
                else
                {
                    return 0.00;
                }
            }
            else
            {
                return 0.00;
            }
    	}
    }

    /**
    * Retorna el nombre del mes del la fecha pasada
    * @param date $date.
    * @return string.
    */
    public static function monthName($date)
    {
        list($year, $mon, $day) = explode('-',$date);
        setlocale(LC_TIME, 'spanish');
        $name=strftime("%B",mktime(0, 0, 0, $mon, $day, $year));
        return ucwords($name);
    }

    /**
     * @access public
     * @static
     */
    public static function cambiarFormatoFecha($fecha,$formato="d/m/Y")
    {
        if(isset($fecha) && $fecha!="")
        {
            list($year, $mon, $day) = explode('-',"$fecha");
            return date($formato,mktime(0, 0, 0,$mon, $day, $year));
        }
        return;
    }

    /**
    * Funcion que retorna no declarado
    * @param int valor
    * @return string valor o frase
    */
    public static function noDeclarado($valor)
    {
        if($valor<0)
        {
            $valor="No Declarado";
        }
        return $valor;
    }
    
    public static function getTime($date, $hour, $datec, $hourc)
    {
        $_date = explode('-', $date);
        $_hour = explode(':', $hour);
        
        if($datec == NULL){
            $_datec = explode('-', date('Y-m-d',time()));
        }else{
            $_datec = explode('-', $datec);
        }
        
        if($hourc == NULL){
            $_hourc = explode(':', date('H:i:s',time()));
        }else{
            $_hourc = explode(':', $hourc);
        }
        
        $timestamp = mktime($_hour[0],$_hour[1],$_hour[2], $_date[1],$_date[2],$_date[0]);
        $timestampc = mktime($_hourc[0],$_hourc[1],$_hourc[2], $_datec[1],$_datec[2],$_datec[0]);
        
        $timeTicket = $timestampc - $timestamp;
        return $timeTicket;
    }
    
    public static function restarHoras($horaini, $horafin, $timestamp)
    {
            $horai=substr($horaini,0,2);
            $mini=substr($horaini,3,2);
            $segi=substr($horaini,6,2);

            $horaf=substr($horafin,0,2);
            $minf=substr($horafin,3,2);
            $segf=substr($horafin,6,2);

            $ini=((($horai*60)*60)+($mini*60)+$segi);
            $fin=((($horaf*60)*60)+($minf*60)+$segf);

            $dif=$fin-$ini;

            $difh=floor($dif/3600);
            $difm=floor(($dif-($difh*3600))/60);
            $difs=$dif-($difm*60)-($difh*3600);
            $date = date("H:i",mktime($difh,$difm,$difs));
            $fecha_final = '';
            
            if ($timestamp == 0) {
                $fecha_final = $date;
            } elseif ($timestamp == 1) {
                $fecha_final = $timestamp . ' dia ' . $date;
            } elseif ($timestamp >= 2) {
                $fecha_final = $timestamp . ' dias ' . $date;
            } 
            
            return $fecha_final;
    }
    
    public static function timeNull($time){
        
        if($time != NULL)
            return date('H:i',strtotime($time));
        else
            return '';
        
    }
}
?>