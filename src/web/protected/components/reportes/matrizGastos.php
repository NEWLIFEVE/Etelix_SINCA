 <?php

    /**
     * @package reportes
     */
    class matrizGastos extends Reportes 
    {
        public static function reporte($mes) 
        {
            
            //Yii::app()->user->setState('mesSesion',$_POST["formFecha"]."-01");

            
            if($mes==NULL){
                
            $tr='Hubo un Error';
 
            }else{
                
           $año = date("Y", strtotime($mes));
           $mes = date("m", strtotime($mes));
           
           $ruta = $_SERVER["SERVER_NAME"];
                
            $sql="SELECT DISTINCT(d.TIPOGASTO_Id) as TIPOGASTO_Id, t.Nombre as nombreTipoDetalle
                    FROM detallegasto d, tipogasto t 
                    WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes' 
                    AND d.TIPOGASTO_Id=t.id 
                    GROUP BY t.Nombre;";
             $model = Detallegasto::model()->findAllBySql($sql);
            
            if($model != false){
            $tr = "<table id='tabla' class='matrizGastos' border='1' style='border-collapse:collapse;width:auto;'>
                    <thead>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' /></td>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Chimbote</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Etelix-Peru</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Huancayo</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 01</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 03</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Piura</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Pucallpa</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Resto</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Surquillo</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Tarapoto</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 01</h3></th>
                        <th style='width: 120px;background: #1967B2;text-align: center;'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 03</h3></th>
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
          
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                $sqlMontoGasto = "SELECT  SUM(d.Monto) as Monto, d.status 
                                  FROM detallegasto d, cabina c, tipogasto t 
                                  WHERE d.CABINA_Id=c.id 
                                  AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes'
                                  AND d.TIPOGASTO_Id=t.id 
                                  AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina->Id
                                  GROUP BY d.status;";
                $MontoGasto = Detallegasto::model()->findBySql($sqlMontoGasto);
               
                if ($MontoGasto!=NULL){
                     $moneda = Detallegasto::monedaGasto($MontoGasto->moneda);
                    switch ($MontoGasto->status) {
                        case "1":
                            if ($count>0){
                                $opago.="<td style='color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='1' style='width: 120px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle, ENT_QUOTES,'UTF-8')."</h3></td><td style='color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            //$aprobado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                            //$pagado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                            break;
                        case "2":
                            
                            if ($count>0){
                                //$opago.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                                $opago.="<td style='color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                //$opago.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3  style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->nombreTipoDetalle</h3></td>";
                                $opago.="<td rowspan='1' style='width: 120px; background: #1967B2'><h3  style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle, ENT_QUOTES,'UTF-8')."</h3></td><td style='color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            //$pagado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                            break;
                        case "3":
                            
                            if ($count>0){
                                //$opago.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                                //$aprobado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                                $opago.="<td style='color: #FFF; background: #00992B; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='1' style='width: 120px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle, ENT_QUOTES,'UTF-8')."</h3></td>";
                                //$opago.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                                //$aprobado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                                $opago.="<td style='color: #FFF; background: #00992B; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            break;
                    }
                }  else {
                    if ($count>0){
                        $opago.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                    }else{
                        $opago.="<td rowspan='1' style='width: 120px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>".htmlentities($gasto->nombreTipoDetalle, ENT_QUOTES,'UTF-8')."</h3></td><td></td>";
                    }
                    
                    //$aprobado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                    //$pagado.="<td border:  1px rgb(233, 224, 224) solid !important;  text-align: center;></td>";
                }
                $count++;
            }
//         
    
    $tr.="<tr id='ordenPago'> 
            $opago
    </tr>

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
     
     
    }
    
    return $tr;
            
            }else{
                return 'No Data';
            }
      }        
            
            
            
            
            
    }
    
}
?>