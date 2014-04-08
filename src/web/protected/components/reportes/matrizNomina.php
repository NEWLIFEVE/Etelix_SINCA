<?php
/**
 * @package reportes
 */
class matrizNomina extends Reportes
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
            //Cambiar nombre a variable
            $mes2=date("m", strtotime($mes));

            $sql="SELECT d.FechaMes as FechaMes, d.beneficiario as beneficiario, d.Monto as Monto, 
                    d.CABINA_Id as CABINA_Id, t.Nombre as nombreTipoDetalle
                    FROM detallegasto as d
                    INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                    INNER JOIN category as c ON c.id = t.category_id
                    WHERE c.name = 'NOMINA'
                    AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
                    AND d.status IN (2,3)
                    ORDER BY d.beneficiario;";
            $model=Detallegasto::model()->findAllBySql($sql);
            
            if($model!=false)
            {
                $tr="<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>$nombre</h2>
                    <br>
                    <table border='1' style='border-collapse:collapse;width:auto;'>
                        <tr>
                            <td style='width: 100px; background: #DADFE4'>
                                <h3 style='font-size:10px; color:#000000; background: none; text-align: center;'> Colores </h3>
                            </td>
                            <td style='width: 80px; background: #1967B2'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Azul</h3>
                            </td>
                            <td style='width: 80px; background: #00992B'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Verde</h3>
                            </td>
                        </tr>
                        <tr>
                            <td style='width: 100px; background: #DADFE4'>
                                <h3 style='font-size:10px; color:#000000; background: none; text-align: center;'> Monedas </h3>
                            </td>
                            <td style='width: 80px; background: #1967B2'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Soles</h3>
                            </td>
                            <td style='width: 80px; background: #00992B'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Dolares</h3>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id='tabla' class='matrizGastos' border='1' style='border-collapse:collapse;width:auto;'>
                        <thead>
                            <th style='border:  0px rgb(233, 224, 224) solid !important;'></th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <center>
                                    <img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' />
                                </center>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Chimbote</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Etelix-Peru</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Huancayo</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 01</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 03</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Piura</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Pucallpa</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Surquillo</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Tarapoto</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 01</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 03</h3>
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
                            </tr>";
                foreach($model as $key => $gasto)
                {
                    $opago="";
                    $aprobado="";
                    $pagado="";

                    $sqlCabinas="SELECT * FROM cabina WHERE status = 1  AND id !=18 AND id != 19 ORDER BY nombre";
                    $cabinas=Cabina::model()->findAllBySql($sqlCabinas);
                    $count=0;
                    foreach($cabinas as $key => $cabina)
                    {
                        $sqlMontoGasto = "SELECT d.beneficiario as beneficiario, d.Monto as Monto, d.moneda
                                  FROM detallegasto as d
                                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                                  INNER JOIN category as c ON c.id = t.category_id
                                  WHERE c.name = 'NOMINA'
                                  AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
                                  AND d.beneficiario = '$gasto->beneficiario'
                                  AND d.CABINA_Id = $cabina->Id
                                  AND d.status IN (2,3);";
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

                                            $opago.="<td style='width: 80px;color: #FFF; $fondo font-size:10px;'>". Reportes::format($MontoGasto->Monto.' '. $moneda, $type)."</td>";
                                        
                                    }
                                    else
                                    {
                                        $opago.="<td style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td rowspan='1' style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->beneficiario)."</h3></td>";
                                        $opago.="<td style='width: 80px;color: #FFF; $fondo font-size:10px;'>". Reportes::format($MontoGasto->Monto.' '. $moneda, $type)."</td>";
                                        
                                    }
                                    
                        }
                        else
                        {
                            if($count>0)
                            {
                                $opago.="<td></td>";
                            }
                            else
                            {
                                $opago.="<td style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->beneficiario)."</h3></td><td></td>";
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
                $tr.= "<tr>
                        <td style='border:  0px rgb(233, 224, 224) solid !important; '></td>
                        <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Soles</h3>
                        </td>";
                $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 AND id != 19 ORDER BY nombre";
                $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
                foreach ($cabinas as $key => $cabina) {
                    $sqlTotales = "SELECT sum(d.Monto) as MontoS
                                  FROM detallegasto as d
                                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                                  INNER JOIN category as c ON c.id = t.category_id
                                  WHERE d.CABINA_Id = $cabina->Id 
                                  AND c.name = 'NOMINA' AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                                  AND d.moneda = 2 
                                  AND d.status IN (2,3);";
                    $totales=Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach($totales as $key => $total)
                    {
                        if($total->MontoS!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;'>".Reportes::format($total->MontoS, $type)."</td>";
                        else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'></td>";
                    }
                }
                $tr.="</tr>";
                // TOTALES DOLARES
                $tr.="<tr>
                        <td style='border:  0px rgb(233, 224, 224) solid !important; '></td>
                        <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total Dolares</h3>
                        </td>";

                foreach ($cabinas as $key => $cabina) {
                    $sqlTotales = "SELECT sum(d.Monto) as MontoD
                                  FROM detallegasto as d
                                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                                  INNER JOIN category as c ON c.id = t.category_id
                                  WHERE d.CABINA_Id = $cabina->Id 
                                  AND c.name = 'NOMINA' AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                                  AND d.moneda = 1 
                                  AND d.status IN (2,3);";
                    $totales=Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach($totales as $key => $total)
                    {
                        if($total->MontoD!=null) $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;'>".Reportes::format(Detallegasto::montoGasto($total->MontoD), $type)."</td>";
                        else $tr.="<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'></td>";
                    }
 
                }
                
                
                $tr.="<tr>
                            <td style='border:  0px rgb(233, 224, 224) solid !important; '></td>
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
                
                // GRAN TOTALES SOLES         
                $tr.= "<tr>
        
                <td style='border:  0px rgb(233, 224, 224) solid !important; '></td>
                <td style='color: #FFF;width: 120px; background: #00992B;font-size:10px;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Gran Total Soles</h3></td>";

                    $sqlTotales = "SELECT sum(d.Monto) as MontoS
                                  FROM detallegasto as d
                                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                                  INNER JOIN category as c ON c.id = t.category_id
                                  WHERE c.name = 'NOMINA' 
                                  AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                                  AND d.moneda = 2 
                                  AND d.status IN (2,3);";       

                    $totales = Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach ($totales as $key => $total) {

                    if($total->MontoS != null)
                        $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Reportes::format(Detallegasto::montoGasto($total->MontoS), $type)."</td>";
                    else
                        $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            


                    }

  
                $tr.= "</tr>";
                
                
                // GRAN TOTALES DOLARES         
                $tr.= "<tr>
        
                <td style='border:  0px rgb(233, 224, 224) solid !important; '></td>
                <td style='color: #FFF;width: 120px; background: #00992B;font-size:10px;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Gran Total Dolares</h3></td>";

                    $sqlTotales = "SELECT sum(d.Monto) as MontoD
                                  FROM detallegasto as d
                                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                                  INNER JOIN category as c ON c.id = t.category_id
                                  WHERE c.name = 'NOMINA' 
                                  AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                                  AND d.moneda = 1 
                                  AND d.status IN (2,3);";       

                    $totales = Detallegasto::model()->findAllBySql($sqlTotales);
                    foreach ($totales as $key => $total) {

                    if($total->MontoD != null)
                        $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Reportes::format(Detallegasto::montoGasto($total->MontoD), $type)."</td>";
                    else
                        $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            

                    }

  
                $tr.= "</tr>";
                
                
                
                
                $tr.="</tr></tbody></table>";
                return $tr;
            }

        }
    }
  
}
?>