<?php
/**
 *
 */
class brightstar extends Reportes 
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
            $table='<table class="items">'.self::defineHeader("brightstar").'<tbody>';
            foreach($balance as $key => $registro)
            {
                $table.='<tr>
                            <td '.self::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                            <td '.self::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->RecargaMovistar).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->DifMov,$registro->DifMov).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->RecargaClaro).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::defineMonto($registro->DifClaro,$registro->DifClaro).'</td>
                         </tr>';

            }

            $balanceTotals=self::get_ModelTotal($ids);
            $table.=self::defineHeader("brightstar")
                    .'<tr>
                        <td '.self::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                        <td '.self::defineStyleTd(2).' id="todas">Todas</td>
                        <td '.self::defineStyleTd(2).' id="vistaAdmin1">'.self::defineTotals($balanceTotals->RecargaMovistar).'</td>
                        <td '.self::defineStyleTd(2).' id="vistaAdmin2">'.self::defineTotals($balanceTotals->DifMov,$balanceTotals->DifMov).'</td>
                        <td '.self::defineStyleTd(2).' id="totalTrafico">'.self::defineTotals($balanceTotals->RecargaClaro).'</td>
                        <td '.self::defineStyleTd(2).' id="totalRecargaMov">'.self::defineTotals($balanceTotals->DifClaro,$balanceTotals->DifClaro).'</td>
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
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina, b.RecargaVentasMov AS RecargaMovistar,
                     (IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))) AS DifMov,
                     b.RecargaVentasClaro AS RecargaClaro,
                     (IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))) AS DifClaro
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
                     SUM(b.RecargaVentasMov) AS RecargaMovistar,
                     SUM((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) AS DifMov,
                     SUM(b.RecargaVentasClaro) AS RecargaClaro,
                     SUM((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) AS DifClaro
              FROM balance b INNER JOIN cabina AS c ON c.id = b.CABINA_Id
              WHERE b.id IN ($ids) ";
        return Balance::model()->findBySql($sql); 
    }
}
?>