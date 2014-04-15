<?php
/**
 * @package reportes
 */
class matrizGastos extends Reportes
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

            $sql="SELECT DISTINCT(d.TIPOGASTO_Id) AS TIPOGASTO_Id,t.Nombre AS nombreTipoDetalle, a.name AS categoria
                  FROM detallegasto d, tipogasto t, category a
                  WHERE d.TIPOGASTO_Id=t.id 
                  AND a.id=t.category_id 
                  AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' 
                  AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' 
                  AND d.status IN (2,3) 
                  AND a.name!='RECARGAS'
                  AND t.Id != 72
                  GROUP BY t.Nombre
                  ORDER BY a.id, t.Nombre;";
            $model=Detallegasto::model()->findAllBySql($sql);
            if($model!=false)
            {
                $tr="<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$nombre}</h2>
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
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Chimbote</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Etelix-Peru</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Huancayo</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 01</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 03</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Piura</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Pucallpa</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Surquillo</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Tarapoto</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 01</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 03</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Comun Cabina</h3>
                            </th>
                            <th style='background: #DADFE4;width: 20px;'></th>
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
                                 WHERE status=1 AND id!=18 
                                 ORDER BY nombre='COMUN CABINA', nombre";
                    $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                    $count=0;
                    foreach($cabinas as $key => $cabina)
                    {
                        $sqlMontoGasto="SELECT SUM(d.Monto) AS Monto, d.status, d.moneda,
                                               (SELECT d.Monto AS Monto
                                                FROM detallegasto d, tipogasto t, category a, cabina c
                                                WHERE a.id=t.category_id AND d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina->Id} AND d.status IN (2,3) AND d.moneda=1 AND a.name!='RECARGAS' AND t.Id != 72
                                                GROUP BY d.moneda) AS MontoDolares,
                                               (SELECT d.Monto AS Monto
                                                FROM detallegasto d, tipogasto t, category a, cabina c
                                                WHERE a.id=t.category_id AND d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina->Id} AND d.status IN (2,3) AND d.moneda=2 AND a.name!='RECARGAS' AND t.Id != 72
                                                GROUP BY d.moneda) AS MontoSoles
                                        FROM detallegasto d, tipogasto t, category a, cabina c
                                        WHERE a.id=t.category_id AND d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina->Id} AND d.status IN (2,3) AND a.name!='RECARGAS' AND t.Id != 72
                                        GROUP BY d.status;";
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
                                        $opago.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->categoria</h3></td><td rowspan='1' style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td>";
                                        if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null)
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
                                $opago.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->categoria</h3></td><td style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td style='$borde'></td>";
                            }
                        }
                        $count++;
                    }

                    $sqlT="SELECT (SELECT SUM(d.Monto) AS Monto 
                                   FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id = t.category_id 
                                   WHERE t.Id={$gasto->TIPOGASTO_Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoD,
                                  (SELECT SUM(d.Monto) AS Monto 
                                   FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id = t.id INNER JOIN category AS a ON a.id = t.category_id 
                                   WHERE t.Id={$gasto->TIPOGASTO_Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoS
                           FROM detallegasto AS d";
                    $monts=Detallegasto::model()->findBySql($sqlT);
                    $tr.="<tr id='ordenPago'>
                            $opago
                        <td style='background: #DADFE4;'></td>";

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
                        <td style='border:0px rgb(233, 224, 224) solid !important;background-color: #DADFE4;$borde'></td>
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
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoS, 
                                        d.moneda
                                 FROM detallegasto AS d";
                    $total=Detallegasto::model()->findBySql($sqlTotales);
                    
                    if($total->MontoS!=null) $tr.= "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;$borde'>".Reportes::format(Detallegasto::montoGasto($total->MontoS), $type)."</td>";
                    else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'></td>";
                }

                $sqlTS="SELECT (SELECT SUM(d.Monto) AS Monto 
                                FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id 
                                WHERE EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoD,
                               (SELECT SUM(d.Monto) AS Monto 
                                FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id 
                                WHERE EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoS
                        FROM detallegasto AS d";
                $montS=Detallegasto::model()->findBySql($sqlTS);
                $tr.="<td style=' background-color: #DADFE4;'></td>";

                if($montS->MontoS!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;$borde'>".Reportes::format($montS->MontoS, $type)."</td>";
                else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'>".Reportes::format($montS->MontoS, $type)."</td>";

                $tr.= "<td style='$borde'></td></tr>";

                // TOTALES DOLARES
                $tr.="<tr>
                        <td style='border:  0px rgb(233, 224, 224) solid !important; background-color: #DADFE4;'></td>
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
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoD,
                                        (SELECT SUM(d.Monto) AS Monto 
                                         FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id INNER JOIN cabina AS c ON d.CABINA_Id=c.id
                                         WHERE d.CABINA_Id={$cabina->Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoS,
                                        d.moneda
                                        FROM detallegasto AS d";
                    $total=Detallegasto::model()->findBySql($sqlTotales);

                    if($total->MontoD!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;$borde'>".Reportes::format(Detallegasto::montoGasto($total->MontoD), $type)."</td>";
                    else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'></td>";
                }      
                $sqlTS="SELECT (SELECT SUM(d.Monto) AS Monto 
                                FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id 
                                WHERE EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoD,
                               (SELECT SUM(d.Monto) AS Monto 
                                FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id 
                                WHERE EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND a.name!='RECARGAS' AND t.Id != 72 AND d.status IN (2,3)) AS MontoS
                        FROM detallegasto as d";
                $montS=Detallegasto::model()->findBySql($sqlTS);

                $tr.="<td style=' background-color: #DADFE4;'></td>
                      <td style='$borde'></td>";
                if($montS->MontoD!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;$borde'>".Reportes::format($montS->MontoD, $type)."</td>";
                else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;$borde'>".Reportes::format($montS->MontoD, $type)."</td>";

                $tr.="</tr>";

                //RECARGAS
                $sql="SELECT DISTINCT(d.TIPOGASTO_Id) AS TIPOGASTO_Id,t.Nombre AS nombreTipoDetalle, a.name AS categoria
                      FROM detallegasto d, tipogasto t, category a
                      WHERE d.TIPOGASTO_Id=t.id AND a.id=t.category_id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.status IN (2,3) AND (a.name = 'RECARGAS' OR t.Id = 72) 
                      GROUP BY t.Nombre
                      ORDER BY t.Nombre";
                $model=Detallegasto::model()->findAllBySql($sql); 
                
                if(count($model) >0)
                    $tr.="<tr>$row</tr>";
                
                foreach ($model as $key => $gasto)
                {
                    $opago="";
                    $MTS="";
                    $MTD="";
                    $sqlCabinas="SELECT * 
                                 FROM cabina 
                                 WHERE status=1 AND id!=18 
                                 ORDER BY nombre='COMUN CABINA', nombre";
                    $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                    $count=0;
                    foreach ($cabinas as $key => $cabina)
                    {
                        $sqlMontoGasto="SELECT SUM(d.Monto) AS Monto, d.status, d.moneda,
                                               (SELECT d.Monto AS Monto
                                                FROM detallegasto d, tipogasto t, category a, cabina c
                                                WHERE a.id=t.category_id AND d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina->Id} AND d.status IN (2,3) AND d.moneda=1 AND (a.name = 'RECARGAS' OR t.Id = 72)
                                                GROUP BY d.moneda) AS MontoDolares,
                                               (SELECT d.Monto AS Monto
                                                FROM detallegasto d, tipogasto t, category a, cabina c    
                                                WHERE a.id=t.category_id AND d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina->Id} AND d.status IN (2,3) AND d.moneda=2 AND (a.name = 'RECARGAS' OR t.Id = 72)
                                                GROUP BY d.moneda) AS MontoSoles
                                        FROM detallegasto d, tipogasto t, category a, cabina c
                                        WHERE a.id=t.category_id AND d.CABINA_Id=c.id AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id={$gasto->TIPOGASTO_Id} AND d.CABINA_Id={$cabina->Id} AND d.status IN (2,3) AND (a.name = 'RECARGAS' OR t.Id = 72)
                                        GROUP BY d.status";
                        $MontoGasto=Detallegasto::model()->findBySql($sqlMontoGasto);
                        if($MontoGasto!=NULL)
                        {
                            $moneda=Detallegasto::monedaGasto($MontoGasto->moneda);
                            $fondo='';

                            if($moneda == 'S/.') $fondo='background: #1967B2;';
                            else $fondo='background: #00992B;';

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
                                $opago.="<td style='width: 200px; background: #1967B2;$borde'>
                                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>{$gasto->categoria}</h3>
                                        </td>
                                        <td rowspan='1' style='width: 80px; background: #1967B2;$borde'>
                                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3>
                                        </td>";
                                if($MontoGasto->MontoDolares!=null && $MontoGasto->MontoSoles!=null)
                                {
                                    $opago.="<td style='padding:0;color: #FFF; font-size:10px;$borde'>
                                                <table style='border-collapse:collapse;margin-bottom: 0px;margin-right: 0px;'>
                                                    <tr style='background: #1967B2;'>
                                                        <td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoSoles.' S/.', $type)." </td>
                                                    </tr>
                                                    <tr style='background: #00992B;'>
                                                        <td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>". Reportes::format($MontoGasto->MontoDolares.' USD$', $type)." USD$</td>
                                                    </tr>
                                                </table>
                                            </td>";
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
                                $opago.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->categoria</h3></td><td style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td style='$borde'></td>";
                            }
                        }
                        $count++;
                    }
                    $sqlT="SELECT (SELECT SUM(d.Monto) AS Monto 
                                   FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id 
                                   WHERE t.Id={$gasto->TIPOGASTO_Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=1 AND (a.name = 'RECARGAS' OR t.Id = 72) AND d.status IN (2,3)) AS MontoD,
                                  (SELECT SUM(d.Monto) AS Monto 
                                   FROM detallegasto AS d INNER JOIN tipogasto AS t ON d.TIPOGASTO_Id=t.id INNER JOIN category AS a ON a.id=t.category_id 
                                   WHERE t.Id={$gasto->TIPOGASTO_Id} AND EXTRACT(YEAR FROM d.FechaMes)='{$año}' AND EXTRACT(MONTH FROM d.FechaMes)='{$mes}' AND d.moneda=2 AND (a.name = 'RECARGAS' OR t.Id = 72) AND d.status IN (2,3)) AS MontoS
                           FROM detallegasto AS d";
                    $mont=Detallegasto::model()->findBySql($sqlT);

                    $tr.="<tr id='ordenPago'>
                            $opago
                        <td style='background: #DADFE4;'></td>";

                    if($mont->MontoS!=null) $tr.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;'>".Reportes::format($mont->MontoS, $type)."</td>";
                    else $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;$borde'>$mont->MontoS</td>";

                    if($mont->MontoD!=null) $tr.="<td style='width: 80px;color: #FFF; background: #00992B; font-size:10px;'>".Reportes::format($mont->MontoD, $type)."</td>";
                    else $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;$borde'>$mont->MontoD</td>";

                    $tr.="</tr>";
                }
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