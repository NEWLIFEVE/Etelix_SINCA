<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m").'-01';
$cabina = 1;
if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesionME',date("Y-m").'-01');
    Yii::app()->user->setState('cabinaSesion',1);
}
else
{
    //Fecha
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesionME',$_POST["formFecha"]."-01");
        $mes=Yii::app()->user->getState('mesSesionME');
    }
    elseif(strlen(Yii::app()->user->getState('mesSesionME')) && Yii::app()->user->getState('mesSesionME')!="")
    {
        $mes = Yii::app()->user->getState('mesSesionME');
    }
    //Cabina
    if(isset($_POST["formCabina"]) && $_POST["formCabina"] != "")
    {
        Yii::app()->user->setState('cabinaSesion',$_POST['formCabina']);
        $cabina = Yii::app()->user->getState('cabinaSesion');
    }
    elseif(strlen(Yii::app()->user->getState('cabinaSesion')) && Yii::app()->user->getState('cabinaSesion')!="")
    {
        $cabina = Yii::app()->user->getState('cabinaSesion');
    }
}                                                                       
    
$año = date("Y", strtotime($mes));
$mes2 = date("m", strtotime($mes));


        
$sql="SELECT DISTINCT(d.TIPOGASTO_Id) as TIPOGASTO_Id,t.Nombre as nombreTipoDetalle
        FROM detallegasto d, tipogasto t 
        WHERE d.TIPOGASTO_Id=t.id 
        AND EXTRACT(YEAR_MONTH FROM d.FechaMes) >= EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11 MONTH)) 
        AND EXTRACT(YEAR_MONTH FROM d.FechaMes) <= '".$año.$mes2."'
        AND d.status = 3
        AND d.CABINA_Id = $cabina
        GROUP BY t.Nombre
        ORDER BY t.Nombre ASC;";
$model = Detallegasto::model()->findAllBySql($sql);
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetallegastoController::controlAcceso($tipoUsuario);
?>
<script>
    $(document).ready(function(){

        $("#mostrarFormulas").click(function(){
            $("#tablaFormulas").slideToggle("slow");
        });
    });
</script>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
    <span class="enviar">
        Matriz de Gastos Evolucion
        <?php echo $cabina != NULL ? " - ". Cabina::getNombreCabina2($cabina) : ""; ?>
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes) .' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoMatriz" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelMatriz" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonMatriz' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detallegasto/matrizGastosEvolucion') ?>">
    <div style="float: left;width: 34%;padding-top: 1%;padding-left: 4%;">
        <div style="width: 40em;">
            
            <label for="dateMonth">
                Seleccione un mes:
            </label>
            <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>   
        </div>
    </div>
    <div style="float: left;width: 55%;padding-top: 1%;padding-left: 4%;">
            <div>
            <div class="buttons" style="float: right;">
                <input type="submit" name="boton" value="Actualizar"/>
                <input type="submit" name="boton" value="Resetear Valores"/>
            </div>    
                <label for="datepicker">
                    Seleccione una cabina:
                </label>
                <?php echo CHtml::dropDownList('formCabina', '', Cabina::getListCabinaResto(), array('empty' => 'Seleccionar...')) ?>
            </div>
    </div>
</form>
<div style="display: block;">&nbsp;</div>
<br><br>
<div id="mostrarFormulas">
    Leyenda
</div>

<div id="tablaFormulas" class="ocultar">
<table>
    <tr>
        <td> Azul = Soles </td>
    </tr>
    <tr>
        <td> Verde = Dolares </td>
    </tr>
</table>
</div>
<br>
<div id="fecha" style="display: none;"><?php echo date('Ym',strtotime($mes));?></div>
<div id="fecha2" style="display: none;"><?php echo $mes;?></div>
<div id="cabina" style="display: none;"><?php echo $cabina;?></div>
<div id="cabina2" style="display: none;"><?php echo Cabina::getNombreCabina2($cabina);?></div>
    <?php 

    $mes_array = Array();
    $fecha_consulta = Array();
    for($i=0;$i<=11;$i++){
        $mes_array[$i] = ucwords(strftime("%B", mktime(0, 0, 0, date('m',strtotime($mes))-$i)));
    } 

    ?>


<?php 

if (count($model)> 1) { ?>
<table id="tabla2" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
    <thead>
        <th style="background-color: #ff9900;"><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></td>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[11]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[10]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[9]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[8]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[7]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[6]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[5]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[4]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[3]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[2]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[1]; ?></h3></th>
        <th style="background-color: #ff9900;"><h3><?php echo $mes_array[0]; ?></h3></th>
        
</thead>
<tbody>
    <tr style="background-color: #DADFE4;">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
 <?php  
 
 
        foreach ($model as $key => $gasto) {
        $tr="";
        $opago="";
        $aprobado="";
        $pagado="";
        
//            $opago.="";
          
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre = 'COMUN CABINA', nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            for($i=0;$i<=11;$i++){
                $sqlMontoGasto = "SELECT  SUM(d.Monto) as Monto, d.status, d.moneda,
                                        (
                                        SELECT  d.Monto as Monto
                                        FROM detallegasto d, cabina c, tipogasto t 
                                        WHERE d.CABINA_Id=c.id
                                        AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count." MONTH))
                                        AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id AND d.CABINA_Id = $cabina
                                        AND d.status = 3
                                        AND d.moneda = 1
                                        GROUP BY d.moneda
                                        ) as MontoDolares, 
                                        
                                        (
                                        SELECT  d.Monto as Monto
                                        FROM detallegasto d, cabina c, tipogasto t 
                                        WHERE d.CABINA_Id=c.id
                                        AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count." MONTH))
                                        AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id  AND d.CABINA_Id = $cabina
                                        AND d.status = 3
                                        AND d.moneda = 2
                                        GROUP BY d.moneda
                                        )  as MontoSoles
                                        
                                  FROM detallegasto d, cabina c, tipogasto t 
                                  WHERE d.CABINA_Id=c.id
                                  AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count." MONTH)) 
                                  AND d.TIPOGASTO_Id=t.id AND d.TIPOGASTO_Id=$gasto->TIPOGASTO_Id 
                                  AND d.CABINA_Id = $cabina
                                  AND d.status = 3
                                  GROUP BY d.moneda;";
                $MontoGasto = Detallegasto::model()->findBySql($sqlMontoGasto);

                if ($MontoGasto!=NULL){
                     $moneda = Detallegasto::monedaGasto($MontoGasto->moneda);
                    switch ($MontoGasto->status) {
                        case "1":
                            if ($count>0){
                                $opago.="<td style='width: 200px;color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='width: 200px;color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            //$aprobado.="<td></td>";
                            //$pagado.="<td></td>";
                            break;
                        case "2":
                            
                            if ($count>0){
                                //$opago.="<td></td>";
                                $opago.="<td style='width: 200px;color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='1' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
//                                $opago.="<td></td>";
                                $opago.="<td style='width: 200px;color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
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
                                    $opago.="<td style='padding:0;color: #FFF; font-size:10px;'><table  style='border-collapse:collapse;margin-bottom: 0px;'><tr style='background: #1967B2;'><td >$MontoGasto->MontoSoles S/.</td></tr> <tr style='background: #00992B;'><td >$MontoGasto->MontoDolares USD$</td></tr></table></td>";
                                }else{
                                    $opago.="<td style='width: 200px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                }
                                
                                
                            }else{
                                $opago.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
//                                $opago.="<td ></td>";
//                                $opago.="<td></td>";
                                    if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null){
                                        $opago.="<td style='padding:0;color: #FFF; font-size:10px;'><table  style='border-collapse:collapse;margin-bottom: 0px;'><tr style='background: #1967B2;'><td >$MontoGasto->MontoSoles S/.</td></tr> <tr style='background: #00992B;'><td >$MontoGasto->MontoDolares USD$</td></tr></table></td>";
                                    }else{
                                        $opago.="<td style='width: 200px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                            }
                            break;
                    }
                }  else {
                    if ($count>0){
                        $opago.="<td></td>";
                    }else{
                        $opago.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td></td>";
                    }
                    
//                    $aprobado.="<td></td>";
//                    $pagado.="<td></td>";
                }
                $count++;
            }
//         
    
     $tr.="<tr id='ordenPago'> 
            $opago
    </tr>";
//    $tr.="<tr id='aprovada'> 
//            $aprobado
//    </tr>";
//    $tr.="<tr id='pagada'> 
//            $pagado
//    </tr>";

    $tr.="<tr style='height: em; background-color: #DADFE4;'>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>";
     echo $tr;
     
     
    }
    // TOTALES SOLES         
    echo "<tr>
        
            <td rowspan='1' style='color: #FFF;width: 120px; background: #1967B2;font-size:10px;'><h3>Totales Soles</h3></td>
            ";
            $count2 = 0;
            for($i=0;$i<=11;$i++){
                $sqlTotales = "select (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count2." MONTH)) AND d.moneda = 1 AND d.status = 3) 
                                as MontoD,
                                (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count2." MONTH)) AND (d.moneda = 2 OR d.moneda IS NULL) AND d.status = 3) 
                                as MontoS, d.moneda
                                FROM detallegasto as d
                                LIMIT 1";       
                
                
        $totales = Detallegasto::model()->findAllBySql($sqlTotales);
        foreach ($totales as $key => $total) {
 
        if($total->MontoD != null || $total->MontoS != null){
            echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Detallegasto::montoGasto($total->MontoS)."</td>";

        }else{
            echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            
        }
  
        }
            
        $count2++;
        }
            
            echo "</tr>";
 
    // TOTALES DOLARES         
    echo "<tr>
        
            <td rowspan='1' style='color: #FFF;width: 120px; background: #1967B2;font-size:10px;'><h3>Totales Dolares</h3></td>
            ";
            $count3 = 0;
            for($i=0;$i<=11;$i++){
                $sqlTotales = "select (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count3." MONTH)) AND d.moneda = 1 AND d.status = 3) 
                                as MontoD,
                                (SELECT  sum(d.Monto) as Monto FROM detallegasto as d INNER JOIN tipogasto as t ON d.TIPOGASTO_Id = t.id INNER JOIN cabina as c ON d.CABINA_Id = c.id  WHERE d.CABINA_Id = $cabina AND EXTRACT(YEAR_MONTH FROM d.FechaMes) = EXTRACT(YEAR_MONTH FROM DATE_SUB('$mes', INTERVAL 11-".$count3." MONTH)) AND (d.moneda = 2 OR d.moneda IS NULL) AND d.status = 3) 
                                as MontoS, d.moneda
                                FROM detallegasto as d
                                LIMIT 1";      
                
                
        $totales = Detallegasto::model()->findAllBySql($sqlTotales);
        foreach ($totales as $key => $total) {
 
        if($total->MontoD != null || $total->MontoS != null){
            echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Detallegasto::montoGasto($total->MontoD)."</td>";

        }else{
            echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            
        }


        
            
        }
            $count3++;
        
        }
            
            echo "</tr>";            
        
    ?>
    
    
</tbody>
</table>
<?php } ?>

