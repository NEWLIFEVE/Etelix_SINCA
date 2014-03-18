<?php
/**
 * @package components
 */
class Reportes extends CApplicationComponent
{
    public function init() 
    {
       
    }

    /**
     * busca el reporte en componente "balanceAdmin" hace la consulta y extrae 
     * los atributos necesarios para luego formar el html y enviarlo por correo y/o exportarlo a excel
     * @param array $ids
     * @return string
     */
    public function balanceAdmin($ids,$name,$type)
    {
        $var=  balanceAdmin::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function libroVenta($ids,$name,$type)

    {
        $var= libroVenta::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function depositoBancario($ids,$name,$type)

    {
        $var= depositoBancario::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function brightstar($ids,$name,$type)

    {
        $var= brightstar::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function captura($ids,$name,$type)

    {
        $var= captura::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function cicloIngreso($ids,$name,$complete,$type)

    {
        $var= cicloIngreso::reporte($ids,$name,$complete,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function cicloIngresoTotal($ids,$name,$complete,$type)

    {
        $var= cicloIngresoTotal::reporte($ids,$name,$complete,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function estadoGasto($ids,$name,$type)

    {
        $var= estadoGasto::reporte($ids,$name,$type);
        return $var;
    }
    
    public function matrizGastos($ids,$nombre,$type)
    {
        $var= matrizGastos::reporte($ids,$nombre,$type);    
        return $var;
    }
    

    public function matrizGastosEvolucion($mes,$cabina,$nombre,$type)
    {
        $var= matrizGastosEvolucion::reporte($mes,$cabina,$nombre,$type);    
        return $var;
    }
    
    public function tableroControl($date,$name)
    {
        $var= tableroControl::reporte($date,$name);    
        return $var;
    }

    /**
     * Documentacion va aqui
     */
    public static function defineStyleTd($type)
    {
        switch ($type)
        {
            case ($type%2==0):
                $style="style ='background: #E5F1F4; font-size: 12px; text-align: center; background-position: initial initial; background-repeat: initial initial;font-size: 11px;'";
                break;
            case ($type%2!=0):
                $style="style ='background: #F8F8F8; font-size: 12px; text-align: center; background-position: initial initial; background-repeat: initial initial;font-size: 11px;'";
                break;
        }
        return $style;
    }

    /**
     * Documentacion va aqui
     */
    public static function defineStyleHeader($type)
    {
        switch ($type){
            case "balance":
                $style="style='background:#00992B;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "libroV":
                $style="style='background:#FFBB00;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "depositos":
                $style="style='background:#1967B2;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "captura":
                $style="style='background:#cc99cc;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "brightstar":
                $style="style='background:#FF9933;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "sobrante":
                $style="style='background:#5E99F2;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
        }
        return $style;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function defineHeader($type)
    {
        switch ($type) {
            case "balance":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c3">Saldo Apertura Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c4">Saldo Apertura Claro (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c5">Trafico (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c6">Recarga Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Recarga Claro (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Monto Deposito (S/.)</th>
                            </tr>
                        </thead>';
                break;
            case "libroV":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("libroV").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c5">Trafico (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c6">Recarga Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Recarga Claro (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Otros Servicios (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Total Ventas (S/.)</th>    
                            </tr>
                        </thead>';
                break;
            case "depositos":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Total  Ventas (S/.) "A"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Monto Deposito (S/.) "B"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Numero de Ref Deposito</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Monto Banco (S/.) "C"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Diferencial Bancario (S/.) "C-A"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">'.htmlentities('Conciliación Bancaria (S/.) "C-B"', ENT_QUOTES,'UTF-8').'</th>    
                            </tr>
                        </thead>';
                break;
            case "captura":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("captura").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c5">Minutos segun Captura</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c6">Trafico Captura (USD $)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c7">Paridad Cambiaria (S/.|$)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Capt Soles</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Soles (S/.)</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Dollar (USD $)</th>       
                            </tr>
                        </thead>';
                break;
            case "brightstar":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("brightstar").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Recarga Ventas Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c6">Diferencial Brightstar Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c7">Recarga Ventas Claro (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Brightstar Claro (S/.)</th>   
                            </tr>
                        </thead>';
                break;
            case "cicloI":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c5">Total de Ventas (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Diferencial Bancario (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">'.htmlentities('Conciliación Bancaria (S/.)', ENT_QUOTES,'UTF-8').'</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Brightstar Movistar (S/.)</th>  
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Brightstar Claro (S/.)</th>  
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c7">Paridad Cambiaria (S/.|$)</th> 
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Soles (S/.)</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Dollar (USD $)</th> 
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Acumulado Dif. Captura (USD $)</th>   
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante (USD $)</th> 
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante Acumulado (USD $)</th>    
                            </tr>
                        </thead>';
                break;
            case "cicloIC":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Cabina</th>
                                    
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c5">Trafico (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c6">Recarga Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Recarga Claro (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Otros Servicios (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Total Ventas (S/.)</th>
                                    
                                <th '.self::defineStyleHeader("depositos").' id="b alance-grid_c6">Fecha del Deposito</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Hora del Deposito</th>
                                    
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Monto Deposito (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Monto Banco (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Diferencial Bancario (S/.) </th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">'.htmlentities('Conciliación Bancaria (S/.)', ENT_QUOTES,'UTF-8').'</th>
                                
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Recarga Ventas Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c6">Diferencial Brightstar Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c7">Recarga Ventas Claro (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Brightstar Claro (S/.)</th> 
                                
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c6">Trafico Captura (USD $)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c7">Paridad Cambiaria (S/.|$)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Capt Soles</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Soles (S/.)</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Dollar (USD $)</th> 
                                
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Acumulado Dif. Captura (USD $)</th>   
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante (USD $)</th> 
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante Acumulado (USD $)</th>    
                            </tr>
                        </thead>';
                break;
            case "matriz":
                $header='<thead>
                            <th '.self::defineStyleHeader("matriz").'><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/mattskitchen/img/Monitor.png" /></td>
                            <th '.self::defineStyleHeader("matriz").'><h3>Chimbote</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Etelix-Peru</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Huancayo</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Iquitos 01</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Iquitos 03</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Piura</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Pucallpa</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Resto</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Surquillo</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Tarapoto</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Trujillo 01</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Trujillo 03</h3></th>
                        </thead>';

                break;
            case "estadoGasto":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("brightstar").' id="Fechas">Mes</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Tipo Gasto</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">'.htmlentities('Descripción', ENT_QUOTES,'UTF-8').'</th>    
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c6">Fecha de Vencimiento</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c7">Monto</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Moneda</th>  
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Beneficiario</th>  
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c7">Estatus</th> 
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Numero de Transferencia</th>   
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Fecha de Transferencia</th> 
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Cuenta</th>     
                            </tr>
                        </thead>';

                break;
        }
        return $header;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function defineMonto($type,$number=null)
    {
        if($type == null)
        {
            $field = '0.00';
        }
        else
        {
            if((float)$number<0)
            {
                $field = '<font color="red">'.$type.'</font>';
            }
            else
            {
                if((float)$number>0)
                {
                    $field = '<font color="green">'.$type.'</font>';
                }
                else
                {
                    $field = $type;
                }    
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui, cambiar nombre a esta funcion
     */
    public static function defineMonto2($type,$number=null)
    {
        if($type == '-1')
        {
            $field = 'No Declarado';
        }
        else
        {
            if($type == null)
            {
                $field = '0.00';
            }
            else
            {
                if((float)$number<0)
                {
                    $field = '<font color="red">'.$type.'</font>';
                }
                else
                {
                    if((float)$number>0)
                    {
                        $field = '<font color="green">'.$type.'</font>';
                    }
                    else
                    {
                        $field = $type;
                    }    
                }
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function defineTotals($type,$number=null)
    {
        if($type == null)
        {
            $field = '0.00';
        }
        else
        {
            if((float)$number<0)
            {
                $field = '<font color="red">'.$type.'</font>';
            }
            else
            {
                if((float)$number>0)
                {
                    $field = '<font color="green">'.$type.'</font>';
                }
                else
                {
                    $field = $type;
                }    
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui, cambiar nombre a esta funcion
     */
    public static function defineTotals2($type,$number=null)
    {
        if($type == '-1')
        {
            $field = 'No Declarado';
        }
        else
        {
            if($type == null)
            {
                $field = '0.00';
            }
            else
            {
                if((float)$number<0)
                {
                    $field = '<font color="red">'.$type.'</font>';
                }
                else
                {
                    if((float)$number>0)
                    {
                        $field = '<font color="green">'.$type.'</font>';
                    }
                    else
                    {
                        $field = $type;
                    }    
                }
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function definePago($type,$number=null)
    {
        if($number == 'Pagada')
        {
            $field = $type;
        }
        else
        {
            $field = 'N/A';
        }
        return $field;
    }
    
    public static function format($monto,$type)
    {
        if($type == true)
        {
            $field = Utility::PuntoPorComa($monto);
        }
        else
        {
            $field = $monto;
        }
        return $field;
    }
    
    
}
?>