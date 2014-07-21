<?php
/**
 * @package reportes
 */
class matrizIngresos extends Reportes
{
    public static function reporte($mes,$nombre,$type)
    {
        if($mes==NULL)
        {
            $tr='Hubo un Error';
        }
        else
        {
            $año=date("Y", strtotime($mes));
            $mes=date("m", strtotime($mes));
            $row="<td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style='background-color: #DADFE4;width: 20px;'></td>
                  <td style=' background-color: #DADFE4;'></td>
                  <td style=' background-color: #DADFE4;'></td>";

            $ruta=$_SERVER["SERVER_NAME"];
            $borde = 'border:1px;border-style:solid;border-color: #E9E0E0;';

            $sql="SELECT d.FechaMes, d.Monto, d.CABINA_Id, d.TIPOINGRESO_Id, t.Nombre as nombreTipoDetalle 
                    FROM detalleingreso as d, tipo_ingresos as t, cabina as c, users as u
                    WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                    AND d.TIPOINGRESO_Id=t.Id
                    AND d.CABINA_Id=c.Id
                    AND d.USERS_Id=u.id
                    AND u.tipo != 1
                    AND t.Id != 14
                    AND t.Id != 15
                    GROUP BY t.Nombre
                    ORDER BY t.Nombre;";
            
            
            
            $model=  Detalleingreso::model()->findAllBySql($sql);
            if($model!=false)
            {
                $tr="<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$nombre}</h2>
                    <br>
                    <table border='0' style='border-collapse:collapse;width:auto;border-color: #E9E0E0;'>
                        <tr>
                            <td style='width: 100px; background: #DADFE4;$borde'>
                                <h3 style='font-size:10px; color:#000000; background: none; text-align: center;'> Colores </h3>
                            </td>
                            <td style='width: 80px; background: #1967B2;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Azul</h3>
                            </td>
                            <td style='width: 80px; background: #00992B;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Verde</h3>
                            </td>
                        </tr>
                        <tr>
                            <td style='width: 100px; background: #DADFE4;$borde'>
                                <h3 style='font-size:10px; color:#000000; background: none; text-align: center;'> Monedas </h3>
                            </td>
                            <td style='width: 80px; background: #1967B2;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Soles</h3>
                            </td>
                            <td style='width: 80px; background: #00992B;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Dolares</h3>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id='tabla' class='matrizGastos' border='0' style='border-collapse:collapse;width:auto;border-style:solid;border-color: #DADFE4;'>
                        <thead>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <center>
                                    <img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' />
                                </center>
                            </th>";
                
                $nombre_cabinas = Cabina::model()->findAllBySQL("SELECT Nombre FROM cabina 
                                      WHERE status=1 AND Nombre!='ZPRUEBA' 
                                      ORDER BY Nombre='COMUN CABINA',Nombre;");
                
                foreach ($nombre_cabinas as $key => $value) {
                    $cabinass[$key] = $value->Nombre;
                    $tr.= "<th style='width: 80px;background: #ff9900;text-align: center;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".$cabinass[$key]."</h3></th>";
                }
                            
                            $tr.= "<th style='background: #DADFE4;width: 20px;'></th>
                            <th style='background-color: #ff9900;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Soles</h3>
                            </th>
                            <th style='background-color: #ff9900;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Dolares</h3>
                            </th>
                        </thead>
                        <tbody>
                        <tr>
                            $row
                        </tr>";
                foreach($model as $key => $gasto)
                {
                    $opago="";
                    $aprobado="";
                    $pagado="";

                    $sqlCabinas="SELECT * 
                                 FROM cabina 
                                 WHERE status=1 AND Id!=18
                                 ORDER BY Nombre = 'COMUN CABINA', Nombre";
                    $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                    $count=0;
                    foreach($cabinas as $key => $cabina)
                    {
                        $sqlMontoGasto = "SELECT SUM(d.Monto) as Monto, d.moneda,
                                    (
                                    SELECT SUM(d.Monto) as Monto
                                    FROM detalleingreso d, users as u, tipo_ingresos as t 
                                    WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                    AND d.CABINA_Id = $cabina->Id
                                    AND d.moneda = 1
                                    AND d.TIPOINGRESO_Id=t.Id
                                    AND d.USERS_Id=u.id
                                    AND u.tipo != 1
                                    AND d.TIPOINGRESO_Id = $gasto->TIPOINGRESO_Id
                                    GROUP BY d.moneda
                                    ) as MontoDolares, 

                                    (
                                    SELECT SUM(d.Monto) as Monto
                                    FROM detalleingreso d, users as u, tipo_ingresos as t 
                                    WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                    AND d.CABINA_Id = $cabina->Id
                                    AND d.moneda = 2
                                    AND d.TIPOINGRESO_Id=t.Id
                                    AND d.USERS_Id=u.id
                                    AND u.tipo != 1
                                    AND d.TIPOINGRESO_Id = $gasto->TIPOINGRESO_Id
                                    GROUP BY d.moneda
                                    )  as MontoSoles
                                    
                                  FROM detalleingreso d, users as u, tipo_ingresos as t 
                                  WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                  AND d.TIPOINGRESO_Id=t.Id
                                  AND d.USERS_Id=u.id
                                  AND u.tipo != 1 
                                  AND d.TIPOINGRESO_Id = $gasto->TIPOINGRESO_Id    
                                  AND d.CABINA_Id = $cabina->Id;";
                        $MontoGasto=Detalleingreso::model()->findBySql($sqlMontoGasto);

                        if($MontoGasto!=NULL)
                        {
                            $moneda=Detallegasto::monedaGasto($MontoGasto->moneda);

                                
                                    $fondo='';
                                    if($moneda=='S/.')
                                    {
                                        $fondo='background: #1967B2;';
                                    }
                                    else
                                    {
                                        $fondo='background: #00992B;';
                                    }
                                    if($count>0)
                                    {
                                        
                                        if($MontoGasto->MontoDolares!=null && $MontoGasto->MontoSoles!=null)
                                        {
                                            $opago.="<td style='padding:0;color: #FFF; font-size:10px;$borde'><table style='border-collapse:collapse;margin-bottom: 0px;margin-right: 0px;'><tr style='background: #1967B2;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoSoles.' S/.', $type)." </td></tr> <tr style='background: #00992B;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoDolares.' USD$', $type)." </td></tr></table></td>";
                                        }
                                        else
                                        {
                                            
                                            if($MontoGasto->Monto == '0.00' || $MontoGasto->Monto == NULL)
                                                $opago.="<td style='$borde'></td>";
                                            else
                                                $opago.="<td style='width: 80px;color: #FFF; $fondo font-size:10px;$borde'>". Reportes::format($MontoGasto->Monto.' '. $moneda, $type)."</td>";
                                        }
                                    }
                                    else
                                    {
                                        $opago.="<td width='80' style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td>";
                                        if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null)
                                        {
                                            $opago.="<td style='padding:0;color: #FFF; font-size:10px;$borde'><table style='border-collapse:collapse;margin-bottom: 0px;margin-right: 0px;'><tr style='background: #1967B2;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoSoles.' S/.', $type)." </td></tr> <tr style='background: #00992B;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoDolares.' USD$', $type)." USD$</td></tr></table></td>";
                                        }
                                        else
                                        {
                                            if($MontoGasto->Monto == '0.00' || $MontoGasto->Monto == NULL)
                                                $opago.="<td style='$borde'></td>";
                                            else
                                                $opago.="<td style='width: 80px;color: #FFF; $fondo font-size:10px;$borde'>". Reportes::format($MontoGasto->Monto.' '. $moneda, $type)."</td>";
                                        }
                                    }
                                    
                        }
                        else
                        {
                            if($count>0)
                            {
                                $opago.="<td style='$borde'></td>";
                            }
                            else
                            {
                                $opago.="<td style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td></td>";
                            }
                        }
                        $count++;
                    }

                    $sqlT = "select 
                            (SELECT SUM(d.Monto) AS Monto 
                                           FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id  
                                           INNER JOIN users AS u ON d.USERS_Id=u.id  
                                           WHERE t.Id=$gasto->TIPOINGRESO_Id AND EXTRACT(YEAR FROM d.FechaMes)='$año' AND EXTRACT(MONTH FROM d.FechaMes)='$mes' AND d.moneda=1 
                                            AND u.tipo != 1 ) as MontoD,
                            (SELECT SUM(d.Monto) AS Monto 
                                           FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id  
                                           INNER JOIN users AS u ON d.USERS_Id=u.id  
                                           WHERE t.Id=$gasto->TIPOINGRESO_Id AND EXTRACT(YEAR FROM d.FechaMes)='$año' AND EXTRACT(MONTH FROM d.FechaMes)='$mes' AND d.moneda=2 
                                            AND u.tipo != 1) as MontoS
                            FROM detallegasto as d
                            LIMIT 1;";
                    $monts=Detalleingreso::model()->findBySql($sqlT);
                    $tr.="<tr id='ordenPago'>
                            $opago
                        <td width='20' style='width:20px;background: #DADFE4;'></td>";

                    if($monts->MontoS!=null) $tr.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;$borde'>". Reportes::format($monts->MontoS, $type)."</td>";
                    else $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;$borde'>{$monts->MontoS}</td>";

                    if($monts->MontoD!=null) $tr.="<td style='width: 80px;color: #FFF; background: #00992B; font-size:10px;$borde'>". Reportes::format($monts->MontoD, $type)."</td>";
                    else $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;$borde'>$monts->MontoD</td>";

                    $tr.="</tr>";
                }
                $tr.="<tr>
                        $row
                      </tr>";
                //TOTAL SOLES
                $tr.="<tr>
                        
                        <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;$borde'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Soles</h3>
                        </td>";
                $sqlCabinas="SELECT * 
                             FROM cabina 
                             WHERE status=1 AND id!=18 
                             ORDER BY nombre='COMUN CABINA', nombre";
                $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                $count=0;
                foreach($cabinas as $key => $cabina)
                {
                    $sqlTotales="SELECT (SELECT SUM(d.Monto) AS Monto 
                                         FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id INNER JOIN users AS u ON d.USERS_Id=u.id  
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND t.Id != 14 AND t.Id != 15 AND u.tipo != 1 ) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto 
                                         FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id INNER JOIN users AS u ON d.USERS_Id=u.id  
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND t.Id != 14 AND t.Id != 15 AND u.tipo != 1  ) AS MontoS, 
                                        d.moneda
                                 FROM detalleingreso AS d";
                                         
 
                    $total=Detalleingreso::model()->findBySql($sqlTotales);
                    
                    if($total->MontoS!=null) $tr.= "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;$borde'>".Reportes::format(Detalleingreso::montoGasto($total->MontoS), $type)."</td>";
                    else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'></td>";
                }

                $sqlTS = "select (SELECT  sum(d.Monto) as Monto FROM detalleingreso as d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN users AS u ON d.USERS_Id=u.id   WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 1 AND u.tipo != 1 AND t.Id != 14 AND t.Id != 15  )
                    as MontoD,
                    (SELECT  sum(d.Monto) as Monto FROM detalleingreso as d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN users AS u ON d.USERS_Id=u.id   WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 2 AND u.tipo != 1 AND t.Id != 14 AND t.Id != 15  ) 
                    as MontoS
                    FROM detallegasto as d
                    LIMIT 1;";
                $montS=Detalleingreso::model()->findBySql($sqlTS);
                $tr.="<td style=' background-color: #DADFE4;$borde'></td>";

                if($montS->MontoS!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;$borde'>".Reportes::format($montS->MontoS, $type)."</td>";
                else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'>".Reportes::format($montS->MontoS, $type)."</td>";

                $tr.= "<td style='$borde'></td></tr>";

                // TOTALES DOLARES
                $tr.="<tr>
                        
                        <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;$borde'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Dolares</h3>
                        </td>";

                $sqlCabinas="SELECT * 
                             FROM cabina 
                             WHERE status=1 AND id!=18 
                             ORDER BY nombre='COMUN CABINA', nombre";
                $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                $count=0;

                foreach ($cabinas as $key => $cabina)
                {
                    $sqlTotales="SELECT (SELECT SUM(d.Monto) AS Monto 
                                         FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id INNER JOIN users AS u ON d.USERS_Id=u.id  
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND t.Id != 14 AND t.Id != 15 AND u.tipo != 1  ) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto 
                                         FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id INNER JOIN users AS u ON d.USERS_Id=u.id  
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND t.Id != 14 AND t.Id != 15 AND u.tipo != 1  ) AS MontoS, 
                                        d.moneda
                                 FROM detalleingreso AS d";
                    $total=Detalleingreso::model()->findBySql($sqlTotales);

                    if($total->MontoD!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;$borde'>".Reportes::format(Detalleingreso::montoGasto($total->MontoD), $type)."</td>";
                    else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'></td>";
                }      
                $sqlTS = "select (SELECT  sum(d.Monto) as Monto FROM detalleingreso as d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN users AS u ON d.USERS_Id=u.id   WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 1 AND u.tipo != 1 AND t.Id != 14 AND t.Id != 15  )
                    as MontoD,
                    (SELECT  sum(d.Monto) as Monto FROM detalleingreso as d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id INNER JOIN users AS u ON d.USERS_Id=u.id   WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 2 AND u.tipo != 1 AND t.Id != 14 AND t.Id != 15  ) 
                    as MontoS
                    FROM detallegasto as d
                    LIMIT 1;";
                $montS=Detalleingreso::model()->findBySql($sqlTS);

                $tr.="<td style=' width:80px;background-color: #DADFE4;'></td>
                      <td style='$borde'></td>";
                if($montS->MontoD!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;$borde'>".Reportes::format($montS->MontoD, $type)."</td>";
                else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'>".Reportes::format($montS->MontoD, $type)."</td>";

                $tr.="</tr>";

                return $tr;
            }
            else
            {
                return 'No Data';
            }
        }
    }
}
?>