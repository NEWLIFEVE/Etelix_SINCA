<?php
/**
 * @package reportes
 */
class balanceAdmin extends Reportes 
{
    /**
     * @access public
     * @static
     */
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
            $table='<table class="items">'.Reportes::defineHeader("balance").'<tbody>';
            foreach($balance as $key => $registro)
            {
                $table.='<tr>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto2($registro->SaldoApMov).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto2($registro->SaldoApClaro).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto2($registro->Trafico).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto2($registro->RecargaMovistar).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto2($registro->RecargaClaro).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto2($registro->MontoDeposito).'</td>
                         </tr>';
            }
            $balanceTotals=self::get_ModelTotal($ids);
            $table.=Reportes::defineHeader("balance")
                    .'<tr>
                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::defineTotals2($balanceTotals->SaldoApMov).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::defineTotals2($balanceTotals->SaldoApClaro).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::defineTotals2($balanceTotals->Trafico).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::defineTotals2($balanceTotals->RecargaMovistar).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::defineTotals2($balanceTotals->RecargaClaro).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::defineTotals2($balanceTotals->MontoDeposito).'</td>
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
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina, b.SaldoApMov AS SaldoApMov, b.SaldoApClaro AS SaldoApClaro,
                     (b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI) AS Trafico,
                     (b.RecargaCelularMov+b.RecargaFonoYaMov) AS RecargaMovistar,
                     (b.RecargaCelularClaro+b.RecargaFonoClaro) AS RecargaClaro,
                     b.MontoDeposito AS MontoDeposito
              FROM balance b INNER JOIN cabina AS c ON c.id = b.CABINA_Id
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
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina,
                     IF(SUM(b.SaldoApMov)<0, -1 , SUM(IF(b.SaldoApMov<0,0,b.SaldoApMov))) AS SaldoApMov,
                     IF(SUM(b.SaldoApClaro)<0, -1 , SUM(IF(b.SaldoApClaro<0,0,b.SaldoApClaro))) AS SaldoApClaro,
                     SUM((b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI)) AS Trafico,
                     SUM((b.RecargaCelularMov+b.RecargaFonoYaMov)) AS RecargaMovistar,
                     SUM((b.RecargaCelularClaro+b.RecargaFonoClaro)) AS RecargaClaro,
                     SUM(b.MontoDeposito) AS MontoDeposito
              FROM balance b INNER JOIN cabina AS c ON c.id = b.CABINA_Id
              WHERE b.id IN ($ids)";
        return Balance::model()->findBySql($sql);
    }
}
?>