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
        $servDirecTvTotal = 0;
        $servNextelTotal = 0;
        $otrosServTotal = 0;
        $ventasTotal = 0;
        $OtrosServiciosFullCarga = 0;
        
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
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->ServMov), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->ServClaro), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->ServDirecTv), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->ServNextel), $type).'</td>    
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->OtrosServiciosFullCarga), $type).'</td>
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->OtrosServicios), $type).'</td>    
                            <td '.self::defineStyleTd($key+2).'>'.self::format(self::defineMonto($registro->TotalVentas), $type).'</td>
                        </tr>';
                
                $traficoTotal = $traficoTotal +$registro->Trafico;
                $recargaMovTotal = $recargaMovTotal + $registro->ServMov;
                $recargaClaroTotal = $recargaClaroTotal + $registro->ServClaro;
                $servDirecTvTotal = $servDirecTvTotal + $registro->ServDirecTv;
                $servNextelTotal = $servNextelTotal + $registro->ServNextel;        
                $otrosServTotal = $otrosServTotal + $registro->OtrosServicios;
                $ventasTotal = $ventasTotal + $registro->TotalVentas;
                $OtrosServiciosFullCarga = $OtrosServiciosFullCarga + $registro->OtrosServiciosFullCarga;
            }

//            $balanceTotals=self::get_ModelTotal($ids);
            $table.=self::defineHeader("libroV")
                    .'<tr>
                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.end($fechas).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($traficoTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($recargaMovTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($recargaClaroTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($servDirecTvTotal), $type).'</td>
                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($servNextelTotal), $type).'</td>    
                        <td '.Reportes::defineStyleTd(2).' id="totalOtrosServicios">'.Reportes::format(Reportes::defineTotals($OtrosServiciosFullCarga), $type).'</td>
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
                
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 6 AND u.tipo = 1) as OtrosServicios,
                  
                 (SELECT SUM(d.Monto) as TotalVentas 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id > 6 AND t.COMPANIA_Id != 12 AND u.tipo = 1) as OtrosServiciosFullCarga,
                  
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 5 AND u.tipo = 1) as Trafico,

                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 1 AND u.tipo = 1) as ServMov,

                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 2 AND u.tipo = 1) as ServClaro,
                  
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 3 AND u.tipo = 1) as ServNextel,
                  
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 4 AND u.tipo = 1) as ServDirecTv,

                 (SELECT SUM(d.Monto) as TotalVentas 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id > 0 AND t.COMPANIA_Id != 12 AND u.tipo = 1) as TotalVentas";
            
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