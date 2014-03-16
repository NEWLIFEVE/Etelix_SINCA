<?php
/**
 * @package reportes
 */
class libroVenta extends Reportes
{
    /**
     * @access public
     * @static
     */
    public static function reporte($ids,$name,$type)
    {
        $balance=self::get_Model($ids);
        if($balance!=NULL)
        {
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        self::defineHeader("libroV")
                        .'<tbody>';
            foreach ($balance as $key => $registro)
            {
                $table.='<tr>
                            <td '.self::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                            <td '.self::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->Trafico), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->RecargaMovistar), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->RecargaClaro), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->OtrosServicios), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->TotalVentas), $type).'</td>
                        </tr>';
            }

            $balanceTotals=self::get_ModelTotal($ids);
            $table.=self::defineHeader("libroV")
                    .'<tr>
                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($balanceTotals->Trafico), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaMovistar), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaClaro), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalOtrosServicios">'.Reportes::format(Reportes::defineTotals($balanceTotals->OtrosServicios), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($balanceTotals->TotalVentas), $type).'</td>    
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
     * @return array
     */
    public static function get_Model($ids)
    {
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina, 
                    (b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI) AS Trafico, 
                    (b.RecargaCelularMov+b.RecargaFonoYaMov) AS RecargaMovistar,
                    (b.RecargaCelularClaro+b.RecargaFonoClaro) AS RecargaClaro,
                    b.OtrosServicios AS OtrosServicios,  
                    (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) AS TotalVentas  
              FROM balance b INNER JOIN cabina AS c ON c.id=b.CABINA_Id
              WHERE b.id IN ($ids)
              ORDER BY b.fecha DESC, c.nombre ASC";
        return Balance::model()->findAllBySql($sql);
    }

    /**
     * @access public
     * @static
     * @return object
     */
    public static function get_ModelTotal($ids)
    {
        $sql="SELECT b.id AS id, b.fecha AS Fecha, c.nombre AS cabina,
                     SUM((b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI)) AS Trafico,
                     SUM((b.RecargaCelularMov+b.RecargaFonoYaMov)) AS RecargaMovistar,
                     SUM((b.RecargaCelularClaro+b.RecargaFonoClaro)) AS RecargaClaro,
                     SUM(b.OtrosServicios) AS OtrosServicios,
                     SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) AS TotalVentas
              FROM balance b INNER JOIN cabina AS c ON c.id=b.CABINA_Id
              WHERE b.id IN ($ids)";
        return Balance::model()->findBySql($sql);
    }
}
?>