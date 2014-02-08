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
     * busca el reporte en componente "balanceAdmin" hace la consulta y extrae los atributos necesarios para luego formar el html y enviarlo por correo y/o exportarlo a excel
     * @param array $ids
     * @return string
     */
    public function balanceAdmin($ids)
    {
        $var=  balanceAdmin::reporte($ids);
        return $var;
    }
    
    public static function defineStyleTr($type){
        switch ($type) {
            case "even":
                $style="style ='background: #E5F1F4; text-align: center; background-position: initial initial; background-repeat: initial initial;'";
                break;
            case "odd":
                $style="style ='background: #F8F8F8; text-align: center; background-position: initial initial; background-repeat: initial initial;'";
                break;
        }
    }
    public static function defineStyleHeader($type){
        switch ($type){
            case "balance":
                $style="style='background:#00992B;color:#FFF;border:0px solid black;'";
                break;
            case "libroV":
                break;
            case "depositos":
                break;
            case "captura":
                break;
            case "brightstar":
                break;
        }
        return $style;
    }
    
    public static function defineHeader($type){
        switch ($type) {
            case "balance":
                $header='<thead>
                            <tr '.self::defineStyleHeader("balance").'>
                                <th id="Fechas">Fecha</th>
                                <th id="balance-grid_c2">Cabina</th>
                                <th id="balance-grid_c3">Saldo Apertura Movistar (S/.)</th>
                                <th id="balance-grid_c4">Saldo Apertura Claro (S/.)</th>
                                <th id="balance-grid_c5">Trafico (S/.)</th>
                                <th id="balance-grid_c6">Recarga Movistar (S/.)</th>
                                <th id="balance-grid_c7">Recarga Claro (S/.)</th>
                                <th id="balance-grid_c8">Monto Deposito (S/.)</th>
                            </tr>
                        </thead>';
                break;
            case "libroV":
                break;
            case "depositos":
                break;
            case "captura":
                break;
            case "brightstar":
                break;
        }
        return $header;
    }
   
}
?>