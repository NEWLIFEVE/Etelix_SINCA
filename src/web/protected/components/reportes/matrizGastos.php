 <?php

    /**
     * @package reportes
     */
    class matrizGastos extends Reportes 
    {
        public static function reporte($mes) 
        {
            
//            if(){
            $mes=NULL;
//            }else{
//                
//            }
            
            
            $sql="SELECT DISTINCT(d.TIPOGASTO_Id) as TIPOGASTO_Id,t.Nombre as nombreTipoDetalle
              FROM detallegasto d, tipogasto t 
              WHERE d.FechaMes='$mes' AND d.TIPOGASTO_Id=t.id 
              GROUP BY t.Nombre;";
            $model = Detallegasto::model()->findAllBySql($sql);
            
            
            $tr = '<table id="tabla" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
    <thead>
        <th><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></td>
        <th><h3>Chimbote</h3></th>
        <th><h3>Etelix-Peru</h3></th>
        <th><h3>Huancayo</h3></th>
        <th><h3>Iquitos 01</h3></th>
        <th><h3>Iquitos 03</h3></th>
        <th><h3>Piura</h3></th>
        <th><h3>Pucallpa</h3></th>
        <th><h3>Resto</h3></th>
        <th><h3>Surquillo</h3></th>
        <th><h3>Tarapoto</h3></th>
        <th><h3>Trujillo 01</h3></th>
        <th><h3>Trujillo 03</h3></th>
</thead>
<tbody>
    <tr style="background-color: #DADFE4;">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>';
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
                                  WHERE d.CABINA_Id=c.id AND d.FechaMes='$mes' AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina->Id
                                  GROUP BY d.status;";
                $MontoGasto = Detallegasto::model()->findBySql($sqlMontoGasto);
               
                if ($MontoGasto!=NULL){
                     $moneda = Detallegasto::monedaGasto($MontoGasto->moneda);
                    switch ($MontoGasto->status) {
                        case "1":
                            if ($count>0){
                                $opago.="<td style='color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            $aprobado.="<td></td>";
                            $pagado.="<td></td>";
                            break;
                        case "2":
                            
                            if ($count>0){
                                $opago.="<td></td>";
                                $aprobado.="<td style='color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
                                $aprobado.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            $pagado.="<td></td>";
                            break;
                        case "3":
                            
                            if ($count>0){
                                $opago.="<td ></td>";
                                $aprobado.="<td></td>";
                                $pagado.="<td style='color: #FFF; background: #00992B; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
                                $opago.="<td ></td>";
                                $aprobado.="<td></td>";
                                $pagado.="<td style='color: #FFF; background: #00992B; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            break;
                    }
                }  else {
                    if ($count>0){
                        $opago.="<td></td>";
                    }else{
                        $opago.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td></td>";
                    }
                    
                    $aprobado.="<td></td>";
                    $pagado.="<td></td>";
                }
                $count++;
            }
//         
    
     $tr.="<tr id='ordenPago'> 
            $opago
    </tr>
    <tr id='aprobado'> 
            $aprobado
    </tr>
    <tr id='pagado'> 
            $pagado
    </tr>
    <tr style='height: em; background-color: #DADFE4;'>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>";
     return $tr;
    }
            
            
            
            
            
            
            
    }
    
}
?>