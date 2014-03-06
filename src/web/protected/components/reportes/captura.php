<?php
/**
 * @package
 */
class captura extends Reportes 
{
    public static function reporte($ids) 
    {
        /*$acumuladoSaldoApMov = 0;
        $acumuladoSaldoApClaro = 0;
        $acumuladoTrafico = 0;
        $acumuladoRecargasMov = 0;
        $acumuladoRecargasClaro = 0;
        $acumuladoDepositos = 0;*/
        
        $balance=self::get_Model($ids);
        if($balance != NULL)
        {
            $table='<table class="items">'.self::defineHeader("captura").'<tbody>';
            foreach($balance as $key => $registro)
            {
                $table.='<tr>
                            <td '.self::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                            <td '.self::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->MinutosCaptura).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->TraficoCapturaDollar).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->Paridad).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->CaptSoles).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->DifSoles,$registro->DifSoles).'</td>   
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->DifDollar,$registro->DifDollar).'</td>       
                         </tr>';
            }

            $balanceTotals=self::get_ModelTotal($ids);
            $table.=self::defineHeader("captura")
                    .'<tr>
                        <td '.self::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                        <td '.self::defineStyleTd(2).' id="todas">Todas</td>
                        <td '.self::defineStyleTd(2).' id="vistaAdmin1">'.self::defineTotals($balanceTotals->MinutosCaptura).'</td>
                        <td '.self::defineStyleTd(2).' id="vistaAdmin2">'.self::defineTotals($balanceTotals->TraficoCapturaDollar).'</td>
                        <td '.self::defineStyleTd(2).' id="totalTrafico">N/A</td>
                        <td '.self::defineStyleTd(2).' id="totalRecargaMov">'.self::defineTotals($balanceTotals->CaptSoles).'</td>
                        <td '.self::defineStyleTd(2).' id="totalRecargaMov">'.self::defineTotals($balanceTotals->DifSoles,$balanceTotals->DifSoles).'</td>
                        <td '.self::defineStyleTd(2).' id="totalRecargaMov">'.self::defineTotals($balanceTotals->DifDollar,$balanceTotals->DifDollar).'</td>      
                      </tr>
                     </tbody>
                    </table>';
        }
        else
        {
            $table='Hubo un error';
        }
        return $table;
    }

    /**
     * @access public
     * @static
     */
    public static function get_Model($ids)
    {
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina, b.MinutosCaptura AS MinutosCaptura, b.TraficoCapturaDollar AS TraficoCapturaDollar,
                     TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
                     TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2) AS CaptSoles,
                     TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2) AS DifSoles,
                     TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2) AS DifDollar
              FROM balance AS b INNER JOIN cabina AS c ON c.id = b.CABINA_Id INNER JOIN paridad AS p ON p.id = b.PARIDAD_Id
              WHERE b.id IN ($ids)
              ORDER BY b.fecha DESC, c.nombre ASC;";
        return Balance::model()->findAllBySql($sql);
    }
    
    /**
     * @access public
     * @static
     */
    public static function get_ModelTotal($ids) 
    {
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina, SUM(b.MinutosCaptura) AS MinutosCaptura, SUM(b.TraficoCapturaDollar) AS TraficoCapturaDollar, SUM(p.Valor) AS Valor,
                     SUM(TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) AS CaptSoles,
                     SUM(TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2)) AS DifSoles,
                     SUM(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) AS DifDollar
              FROM balance AS b INNER JOIN cabina AS c ON c.id = b.CABINA_Id INNER JOIN paridad AS p ON p.id = b.PARIDAD_Id
              WHERE b.id IN ($ids) ";
        return Balance::model()->findBySql($sql); 
    }
}
?>