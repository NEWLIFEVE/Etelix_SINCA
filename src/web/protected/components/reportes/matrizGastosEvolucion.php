<?php
/**
 * @package reportes
 */
class matrizGastosEvolucion extends Reportes
{
    public static function reporte($mes,$cabina,$nombre,$type)
    {
        if($mes==NULL)
        {
            $tr='Hubo un Error';
        }
        else
        {
            $año=date("Y", strtotime($mes));
            //Cambiar nombre a variable
            $mes2=date("m", strtotime($mes));
            $ruta=$_SERVER["SERVER_NAME"];
            $borde = 'border:1px;border-style:solid;border-color: #E9E0E0;';

            $sql="SELECT DISTINCT(d.TIPOGASTO_Id) AS TIPOGASTO_Id, t.Nombre AS nombreTipoDetalle, a.name AS categoria
                  FROM detallegasto d, tipogasto t, category a
                  WHERE d.TIPOGASTO_Id=t.id 
                  AND a.id=t.category_id 
                  AND EXTRACT(YEAR_MONTH FROM d.FechaMes) >= EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11 MONTH))
                  AND EXTRACT(YEAR_MONTH FROM d.FechaMes) <= '{$año}{$mes2}' AND d.status IN (2,3) AND d.CABINA_Id={$cabina}
                  GROUP BY t.Nombre
                  ORDER BY a.id, t.Nombre;";
            $model=Detallegasto::model()->findAllBySql($sql);
            setlocale(LC_TIME, 'spanish'); 
            $fecha_consulta=$mes_array=Array();

            for($i=0;$i<=11;$i++)
            {
                $mes_array[$i]=ucwords(strftime("%B", mktime(0, 0, 0, date('m',strtotime($mes))-$i)));
            }
            
            if($model!=false)
            {
                $tr="<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>$nombre</h2>
                    <br>
                    <table border='0' style='border-collapse:collapse;width:auto;border-color: #DADFE4;'>
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
                    <table id='tabla' class='matrizGastos' border='0' style='border-collapse:collapse;width:auto;border-color: #DADFE4;'>
                        <thead>
                            <th style='background-color: #DADFE4;'></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <center>
                                    <img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' />
                                </center>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[11]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[10]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[9]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[8]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[7]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[6]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[5]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[4]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[3]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[2]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[1]</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$mes_array[0]</h3>
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                            </tr>";
                foreach($model as $key => $gasto)
                {
                    $opago="";
                    $aprobado="";
                    $pagado="";

                    $sqlCabinas="SELECT * 
                                 FROM cabina 
                                 WHERE status=1 AND id !=18
                                 ORDER BY nombre='COMUN CABINA', nombre";
                    $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                    $count=0;
                    for($i=0;$i<=11;$i++)
                    {
                        $sqlMontoGasto="SELECT SUM(d.Monto) AS Monto, d.status, d.moneda,
                                               (SELECT d.Monto AS Monto
                                                FROM detallegasto d, cabina c, tipogasto t
                                                WHERE d.CABINA_Id=c.id AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count} MONTH)) AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina} AND d.status IN (2,3) AND d.moneda=1
                                                GROUP BY d.moneda) AS MontoDolares,
                                               (SELECT d.Monto AS Monto
                                                FROM detallegasto d, cabina c, tipogasto t
                                                WHERE d.CABINA_Id=c.id AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count} MONTH)) AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina} AND d.status IN (2,3) AND d.moneda=2
                                                GROUP BY d.moneda) AS MontoSoles
                                        FROM detallegasto d, cabina c, tipogasto t
                                        WHERE d.CABINA_Id=c.id AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count} MONTH)) AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina} AND d.status IN (2,3)
                                        GROUP BY d.moneda;";
                        $MontoGasto=Detallegasto::model()->findBySql($sqlMontoGasto);

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
                                            $opago.="<td style='width: 80px;color: #FFF; $fondo font-size:10px;$borde'>". Reportes::format($MontoGasto->Monto.' '. $moneda, $type)."</td>";
                                        }
                                    }
                                    else
                                    {
                                        $opago.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->categoria)."</h3></td><td rowspan='1' style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td>";
                                        if($MontoGasto->MontoDolares!=null && $MontoGasto->MontoSoles!=null)
                                        {
                                            $opago.="<td style='padding:0;color: #FFF; font-size:10px;$borde'><table style='border-collapse:collapse;margin-bottom: 0px;margin-right: 0px;'><tr style='background: #1967B2;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoSoles.' S/.', $type)." </td></tr> <tr style='background: #00992B;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoDolares.' USD$', $type)." USD$</td></tr></table></td>";
                                        }
                                        else
                                        {
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
                                $opago.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->categoria)."</h3></td><td rowspan='1' style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td></td>";
                            }
                        }
                        $count++;
                    }
                    $tr.="<tr id='ordenPago'>
                            $opago
                        </tr>";

                    $tr.="<tr>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                            <td style='height: em; background-color: #DADFE4;'></td>
                        </tr>";
                }
            //TOTAL SOLES
                $tr.= "<tr>
                        <td style='border:  0px rgb(233, 224, 224) solid !important; border:0;background-color: #DADFE4;'></td>
                        <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;$borde'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Soles</h3>
                        </td>";
                $sqlCabinas="SELECT * 
                             FROM cabina 
                             WHERE status=1 AND id!=18 
                             ORDER BY nombre='COMUN CABINA', nombre";
                $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                $count2=0;
                for($i=0;$i<=11;$i++)
                {
                    $sqlTotales="SELECT (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina} AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count2} MONTH)) AND d.moneda=1 AND d.status = 3) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina} AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count2} MONTH)) AND (d.moneda=2 OR d.moneda IS NULL) AND d.status IN (2,3)) AS MontoS,
                                        d.moneda
                                 FROM detallegasto AS d
                                 LIMIT 1";
                    $totales=Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach($totales as $key => $total)
                    {
                        if($total->MontoS!=null) $tr.="<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;$borde'>".Reportes::format($total->MontoS, $type)."</td>";
                        else $tr.="<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;$borde'>".Reportes::format(Detallegasto::montoGasto('00.00'), $type)."</td>";
                    }
                    $count2++;
                }
                $tr.="</tr>";
                // TOTALES DOLARES
                $tr.="<tr>
                        <td style='border:  0px rgb(233, 224, 224) solid !important; border:0;background-color: #DADFE4;'></td>
                        <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;$borde'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Dolares</h3>
                        </td>";
                $sqlCabinas="SELECT * 
                             FROM cabina 
                             WHERE status=1 AND id!=18 
                             ORDER BY nombre='COMUN CABINA', nombre";
                $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                $count3=0;
                for($i=0;$i<=11;$i++)
                {
                    $sqlTotales="SELECT (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina} AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count3} MONTH)) AND d.moneda=1 AND d.status IN (2,3)) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina} AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-{$count3} MONTH)) AND (d.moneda=2 OR d.moneda IS NULL) AND d.status IN (2,3)) AS MontoS,
                                        d.moneda
                                 FROM detallegasto AS d
                                 LIMIT 1";
                    $totales=Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach($totales as $key => $total)
                    {
                        if($total->MontoD!=null) $tr.="<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;$borde'>".Reportes::format(Detallegasto::montoGasto($total->MontoD), $type)."</td>";
                        else $tr.="<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;$borde'>".Reportes::format(Detallegasto::montoGasto('00.00'), $type)."</td>";
                    }
                    $count3++;
                }
                $tr.="</tr></tbody></table>";
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