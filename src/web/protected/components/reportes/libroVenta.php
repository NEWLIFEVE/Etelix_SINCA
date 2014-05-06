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
    public static function reporte($fecha,$cabina,$name,$type)
    {
        $fechas = explode(",", $fecha);
        $cabinas = explode(",", $cabina);
        
        $traficoTotal = 0;
        $recargaMovTotal = 0;
        $recargaClaroTotal = 0;
        $otrosServTotal = 0;
        $ventasTotal = 0;
        
        $balance=self::get_Model($fechas,$cabinas);
        
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
                            <td '.self::defineStyleTd($key+2).'>'.$fechas[$key].'</td>
                            <td '.self::defineStyleTd($key+2).'>'.Cabina::getNombreCabina($cabinas[$key]).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->Trafico), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->RecargaMovistar), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->RecargaClaro), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->OtrosServicios), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->TotalVentas), $type).'</td>
                        </tr>';
                
                $traficoTotal = $traficoTotal +$registro->Trafico;
                $recargaMovTotal = $recargaMovTotal + $registro->RecargaMovistar;
                $recargaClaroTotal = $recargaClaroTotal + $registro->RecargaClaro;
                $otrosServTotal = $otrosServTotal + $registro->OtrosServicios;
                $ventasTotal = $ventasTotal + $registro->TotalVentas;
            }

//            $balanceTotals=self::get_ModelTotal($ids);
            $table.=self::defineHeader("libroV")
                    .'<tr>
                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.end($fechas).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($traficoTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($recargaMovTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($recargaClaroTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalOtrosServicios">'.Reportes::format(Reportes::defineTotals($otrosServTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($ventasTotal), $type).'</td>    
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
    public static function get_Model($fechas,$cabinas)
    {
        $model = Array();
        
        for($i=0;$i<count($fechas);$i++){
            $sql="SELECT
                 (SELECT Monto FROM detalleingreso WHERE FechaMes = '$fechas[$i]' AND CABINA_Id = $cabinas[$i] AND TIPOINGRESO_Id = 8) as OtrosServicios,
                 (SELECT SUM(Monto) FROM detalleingreso WHERE FechaMes = '$fechas[$i]' AND CABINA_Id = $cabinas[$i] AND TIPOINGRESO_Id > 1 AND TIPOINGRESO_Id < 8) as Trafico,
                 (SELECT SUM(Monto) FROM detalleingreso WHERE FechaMes = '$fechas[$i]' AND CABINA_Id = $cabinas[$i] AND TIPOINGRESO_Id > 8 AND TIPOINGRESO_Id < 11) as RecargaMovistar,
                 (SELECT SUM(Monto) FROM detalleingreso WHERE FechaMes = '$fechas[$i]' AND CABINA_Id = $cabinas[$i] AND TIPOINGRESO_Id > 10 AND TIPOINGRESO_Id < 13) as RecargaClaro,
                 (SELECT SUM(Monto) FROM detalleingreso WHERE FechaMes = '$fechas[$i]' AND CABINA_Id = $cabinas[$i] AND TIPOINGRESO_Id > 1 AND TIPOINGRESO_Id < 13) as TotalVentas";
            $model[$i] = Detalleingreso::model()->findBySql($sql);
        }
        
        return $model;
        
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