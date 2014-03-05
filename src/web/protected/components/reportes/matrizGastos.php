 <?php

    /**
     * @package reportes
     */
    class matrizGastos extends Reportes 
    {
        public static function reporte($mes,$nombre) 
        {
            
            //Yii::app()->user->setState('mesSesion',$_POST["formFecha"]."-01");

            
            if($mes==NULL){
                
            $tr='Hubo un Error';
 
            }else{
                
           $año = date("Y", strtotime($mes));
           $mes = date("m", strtotime($mes));
           
           $ruta = $_SERVER["SERVER_NAME"];
                
            $sql="SELECT DISTINCT(d.TIPOGASTO_Id) as TIPOGASTO_Id,t.Nombre as nombreTipoDetalle
              FROM detallegasto d, tipogasto t 
              WHERE d.TIPOGASTO_Id=t.id 
              AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
              AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
              AND d.status = 3
              GROUP BY t.Nombre;";
             $model = Detallegasto::model()->findAllBySql($sql);
            
            if($model != false){
            $tr = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>$nombre</h2><br>
                <table border='1' style='border-collapse:collapse;width:auto;'>
                        <tr>
                            <td style='width: 100px; background: #DADFE4'><h3 style='font-size:10px; color:#000000; background: none; text-align: center;'> Colores </h3> </td>

                            <td style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Azul</h3> </td>

                            <td style='width: 80px; background: #00992B'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Verde</h3> </td>
                        </tr>
                        <tr>
                            <td style='width: 100px; background: #DADFE4'><h3 style='font-size:10px; color:#000000; background: none; text-align: center;'> Monedas </h3> </td>

                            <td style='width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Soles</h3> </td>

                            <td style='width: 80px; background: #00992B'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'> Dolares</h3> </td>
                        </tr>
                    </table><br>
                    <table id='tabla' class='matrizGastos' border='1' style='border-collapse:collapse;width:auto;'>
                    <thead>
                        <th style='width: 80px;background: #ff9900;text-align: center;'><center><img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' /></center></td>
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
                        <tr >
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
    foreach ($model as $key => $gasto) {
        //$tr="";
        $opago="";
        $aprobado="";
        $pagado="";
        
//            $opago.="";
          
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre = 'COMUN CABINA', nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                $sqlMontoGasto = "SELECT  SUM(d.Monto) as Monto, d.status, d.moneda,
                                        (
                                        SELECT  d.Monto as Monto
                                        FROM detallegasto d, cabina c, tipogasto t 
                                        WHERE d.CABINA_Id=c.id
                                        AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                        AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                        AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina->Id
                                        AND d.status = 3
                                        AND d.moneda = 1
                                        GROUP BY d.moneda
                                        ) as MontoDolares, 
                                        
                                        (
                                        SELECT  d.Monto as Monto
                                        FROM detallegasto d, cabina c, tipogasto t 
                                        WHERE d.CABINA_Id=c.id
                                        AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                        AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                        AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina->Id
                                        AND d.status = 3
                                        AND d.moneda = 2
                                        GROUP BY d.moneda
                                        )  as MontoSoles
                                        
                                  FROM detallegasto d, cabina c, tipogasto t 
                                  WHERE d.CABINA_Id=c.id
                                  AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                  AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina->Id
                                  AND d.status = 3
                                  GROUP BY d.status;";
                $MontoGasto = Detallegasto::model()->findBySql($sqlMontoGasto);
               
                if ($MontoGasto!=NULL){
                     $moneda = Detallegasto::monedaGasto($MontoGasto->moneda);
                    switch ($MontoGasto->status) {
                        case "1":
                            if ($count>0){
                                $opago.="<td style='width: 80px;color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td style='width: 80px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='width: 200px;color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            //$aprobado.="<td></td>";
                            //$pagado.="<td></td>";
                            break;
                        case "2":
                            
                            if ($count>0){
                                //$opago.="<td></td>";
                                $opago.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='1' style='width: 80px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
//                                $opago.="<td></td>";
                                $opago.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
//                            $pagado.="<td></td>";
                            break;
                        case "3":
                            
                                $fondo = '';
                                if($moneda == 'S/.'){
                                    $fondo = 'background: #1967B2;';
                                }else{
                                    $fondo = 'background: #00992B;';
                                }
                                
                            if ($count>0){
//                                $opago.="<td ></td>";
//                                $opago.="<td></td>";
                                
                                    if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null){
                                        $opago.="<td style='height: em;padding:0;color: #FFF; font-size:10px;'><table style='border-collapse:collapse;margin-bottom: 0px;width: auto;'><tr style='background: #1967B2;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$MontoGasto->MontoSoles </td></tr> <tr style='background: #00992B;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$MontoGasto->MontoDolares </td></tr></table></td>";
                                    }else{
                                        $opago.="<td style='height: em;width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto </td>";
                                    }

                            }else{
                                $opago.="<td  style='height: em;width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td>";
//                                $opago.="<td ></td>";
//                                $opago.="<td></td>";
                                    if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null){
                                        $opago.="<td style='height: em;padding:0;color: #FFF; font-size:10px;'><table style='border-collapse:collapse;margin-bottom: 0px;width: auto;'><tr style='background: #1967B2;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$MontoGasto->MontoSoles </td></tr> <tr style='background: #00992B;'><td style='width: 80px;font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$MontoGasto->MontoDolares </td></tr></table></td>";
                                    }else{
                                        $opago.="<td style='height: em;width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto </td>";
                                    }
                            }
                            break;
                    }
                }  else {
                    if ($count>0){
                        $opago.="<td></td>";
                    }else{
                        $opago.="<td style='height: em;width: 80px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle)."</h3></td><td></td>";
                    }
                    
//                    $aprobado.="<td></td>";
//                    $pagado.="<td></td>";
                }
                $count++;
            }
//         
    
     $tr.="<tr id='ordenPago' > 
            $opago
    </tr>";
//    $tr.="<tr id='aprovada'> 
//            $aprobado
//    </tr>";
//    $tr.="<tr id='pagada'> 
//            $pagado
//    </tr>";

    $tr.="<tr >
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
        
            <td rowspan='1' style='color: #FFF;width: 120px; background: #1967B2;font-size:10px;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Totales Soles</h3></td>
            ";
         
           $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre = 'COMUN CABINA', nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                $sqlTotales = "select (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 1 AND d.status = 3) 
                                as MontoD,
                                (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 2 AND d.status = 3) 
                                as MontoS, d.moneda
                                FROM detallegasto as d
                                LIMIT 1;";       
                
                
        $totales = Detallegasto::model()->findAllBySql($sqlTotales);
        foreach ($totales as $key => $total) {
 
        if($total->MontoD != null || $total->MontoS != null){
            $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Detallegasto::montoGasto($total->MontoS)."</td>";

        }else{
            $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            
        }


        
            
        }
            }
       
            $tr.= "</tr>";
 
    // TOTALES DOLARES         
    $tr.= "<tr>
        
            <td rowspan='1' style='color: #FFF;width: 120px; background: #1967B2;font-size:10px;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Totales Dolares</h3></td>
            ";
         
    $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre = 'COMUN CABINA', nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                $sqlTotales = "select (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 1 AND d.status = 3) 
                                as MontoD,
                                (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina->Id AND EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' AND d.moneda = 2 AND d.status = 3) 
                                as MontoS, d.moneda
                                FROM detallegasto as d
                                LIMIT 1;";       
                
                
        $totales = Detallegasto::model()->findAllBySql($sqlTotales);
        foreach ($totales as $key => $total) {
 
        if($total->MontoD != null || $total->MontoS != null){
            $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Detallegasto::montoGasto($total->MontoD)."</td>";

        }else{
            $tr.= "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            
        }


        
            
        }
            }
       
            $tr.= "</tr>";    
     
     
    
    return $tr;
            
            }else{
                return 'No Data';
            }
      }        
            
            
            
            
            
    }
    
}
?>