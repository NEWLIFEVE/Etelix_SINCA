<?php
/**
 * @package reportes
 */
class matrizGastos extends Reportes
{
    public static function reporte($mes)
    {
        if($mes==NULL)
        {
            $tr='Hubo un Error';
        }
        else
        {
            $año=date("Y", strtotime($mes));
            $mes=date("m", strtotime($mes));
            $ruta=$_SERVER["SERVER_NAME"];

            $sql="SELECT DISTINCT(d.TIPOGASTO_Id) as TIPOGASTO_Id,t.Nombre as nombreTipoDetalle
                  FROM detallegasto d, tipogasto t
                  WHERE d.TIPOGASTO_Id=t.id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.status = 3
                  GROUP BY t.Nombre;";

            $model=Detallegasto::model()->findAllBySql($sql);

            if($model!=false)
            {
                $tr="<table id='tabla' class='matrizGastos' border='1' style='border-collapse:collapse;width:auto;'>
                        <thead>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><center><img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' /></center></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Chimbote</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Etelix-Peru</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Huancayo</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 01</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 03</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Piura</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Pucallpa</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Surquillo</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Tarapoto</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 01</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 03</h3></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Comun Cabina</h3></th>
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
                            </tr>";
                foreach ($model as $key => $gasto)
                {
                    $opago="";
                    $aprobado="";
                    $pagado="";

                    $sqlCabinas="SELECT * 
                                 FROM cabina 
                                 WHERE status=1  AND id !=18 
                                 ORDER BY nombre='COMUN CABINA', nombre";
                    $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                    $count=0;
                    foreach ($cabinas as $key => $cabina)
                    {
                        $sqlMontoGasto="SELECT SUM(d.Monto) AS Monto, d.status, d.moneda
                                        FROM detallegasto d, cabina c, tipogasto t
                                        WHERE d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina->Id AND d.status = 3
                                        GROUP BY d.status";
                        $MontoGasto=Detallegasto::model()->findBySql($sqlMontoGasto);
               
                        if($MontoGasto!=NULL)
                        {
                            $moneda=Detallegasto::monedaGasto($MontoGasto->moneda);
                            switch ($MontoGasto->status)
                            {
                                case "1":
                                    if ($count>0)
                                    {
                                        $opago.="<td style='width: 80px;color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                                    else
                                    {
                                        $opago.="<td rowspan='1' style='width: 80px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='width: 200px;color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                                    break;
                                case "2":
                                    if ($count>0)
                                    {
                                        $opago.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                                    else
                                    {
                                        $opago.="<td rowspan='1' style='width: 80px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
                                        $opago.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }                        
                                    break;
                                case "3":
                                    if ($count>0)
                                    {
                                        $fondo = '';
                                        if($moneda == 'S/.')
                                        {
                                            $fondo = 'background: #1967B2;';
                                        }
                                        else
                                        {
                                            $fondo = 'background: #00992B;';
                                        }
                                        $opago.="<td style='width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                                    else
                                    {
                                        $opago.="<td rowspan='1' style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td>";
                                        $opago.="<td style='width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                                    break;
                            }
                        }
                        else
                        {   
                            if ($count>0)
                            {
                                $opago.="<td></td>";
                            }
                            else
                            {
                                $opago.="<td rowspan='1' style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td></td>";
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
                          </tr>";
                }
                //TOTAL SOLES
                $tr.="<tr>
                        <td rowspan='1' style='color: #FFF;width: 80px; background: #1967B2;font-size:10px;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Totales S/.</h3></td>";

                $sqlCabinas="SELECT * 
                             FROM cabina 
                             WHERE status=1  AND id !=18 
                             ORDER BY nombre = 'COMUN CABINA', nombre";
                $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                $count=0;
                foreach ($cabinas as $key => $cabina)
                {
                    $sqlTotales="SELECT (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id WHERE d.CABINA_Id=$cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 1 AND d.status = 3) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina AS c ON d.CABINA_Id = c.id WHERE d.CABINA_Id = $cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 2 AND d.status = 3) AS MontoS, d.moneda
                                 FROM detallegasto AS d
                                 LIMIT 1";
                    $totales=Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach ($totales as $key => $total)
                    {
                        if($total->MontoD != null || $total->MontoS != null)
                        {
                            $tr.="<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;text-align: center;'>".Detallegasto::montoGasto($total->MontoS)."</td>";
                        }
                        else
                        {
                            $tr.="<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;text-align: center;'>00.00</td>";
                        }
                    }
                }
                $tr.="</tr>";
                // TOTALES DOLARES
                $tr.= "<tr>
                        <td rowspan='1' style='color: #FFF;width: 80px; background: #1967B2;font-size:10px;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Totales USD$</h3></td>";
         
                $sqlCabinas="SELECT * 
                             FROM cabina 
                             WHERE status=1 AND id !=18 
                             ORDER BY nombre";
                $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                $count=0;
                foreach ($cabinas as $key => $cabina)
                {
                    $sqlTotales="SELECT (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN cabina AS c ON d.CABINA_Id=c.id 
                                         WHERE d.CABINA_Id=$cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 1 AND d.status = 3) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina AS c ON d.CABINA_Id = c.id WHERE d.CABINA_Id = $cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 2 AND d.status = 3) AS MontoS, d.moneda
                                 FROM detallegasto AS d
                                 LIMIT 1";
                    $totales=Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach ($totales as $key => $total)
                    {
                        if($total->MontoD != null || $total->MontoS != null)
                        {
                            $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;text-align: center;'>".Detallegasto::montoGasto($total->MontoD)."</td>";
                        }
                        else
                        {
                            $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;text-align: center;'>00.00</td>";
                        }
                    }
                }
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