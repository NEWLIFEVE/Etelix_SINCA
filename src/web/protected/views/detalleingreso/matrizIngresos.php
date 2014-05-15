<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m").'-01';

if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesionM',date("Y-m").'-01');
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesionM',$_POST["formFecha"]."-01");
        $mes=Yii::app()->user->getState('mesSesionM');
    }
    elseif(strlen(Yii::app()->user->getState('mesSesionM')) && Yii::app()->user->getState('mesSesionM')!="")
    {
        $mes = Yii::app()->user->getState('mesSesionM');
    } 
}

$año = date("Y", strtotime($mes));
$mes2 = date("m", strtotime($mes));
        
$sql="SELECT d.FechaMes, d.Monto, d.CABINA_Id, d.TIPOINGRESO_Id, t.Nombre as nombreTipoDetalle 
      FROM detalleingreso as d, tipo_ingresos as t, cabina as c
      WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
      AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
      AND d.TIPOINGRESO_Id=t.Id
      AND d.CABINA_Id=c.Id
      GROUP BY t.Nombre
      ORDER BY t.Nombre = 'COMUN CABINA', c.Nombre;";


$model = Detalleingreso::model()->findAllBySql($sql);
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetalleIngresoController::controlAcceso($tipoUsuario);
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
        Matriz de Ingresos
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes).' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoMatriz" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelMatriz" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonMatriz' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detalleingreso/matrizIngresos') ?>">
    <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
        <div style="width: 40em;">
            <div class="buttons" style="float: right;">
                <input type="submit" name="boton" value="Actualizar"/>
                <input type="submit" name="boton" value="Resetear Valores"/>
            </div>
            <label for="dateMonth">
                Seleccione un mes:
            </label>
            <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>   
        </div>
    </div>
</form>
<div style="display: block;">&nbsp;</div>
<div style="display: block;">&nbsp;</div>
<br>
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
<?php 

if (count($model)> 0) { ?>
<table id="tablaIngresos" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
    <thead>
        <th style="background-color: #ff9900;"><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></th>
        <?php 

        $nombre_cabinas = Cabina::model()->findAllBySQL("SELECT Id, Nombre FROM cabina 
                                      WHERE status=1 AND id !=18
                                      ORDER BY Nombre = 'COMUN CABINA', Nombre;");
        
        foreach ($nombre_cabinas as $key => $value) {
            $cabinass[$key] = $value->Nombre;
            echo "<th style='background-color: #ff9900;'><h3>".$cabinass[$key]."</h3></th>";
        }

        ?>
        <th style='background: #DADFE4;width: 0px;'></th>
        <th style="background-color: #ff9900;"><h3>Total Soles</h3></th>
        <th style="background-color: #ff9900;"><h3>Total Dolares</h3></th>
        
</thead>
<tbody>
    <tr style="background-color: #DADFE4;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
 <?php    
 
        $row="<tr style='height: em; background-color: #DADFE4;'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>";
 
        foreach ($model as $key => $gasto) {
        $tr="";
        $content="";
        $MTS="";
        $MTD="";
          
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND Id !=18 ORDER BY Nombre = 'COMUN CABINA', Nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                $sqlMontoGasto = "SELECT d.Monto as Monto, d.moneda,
                                    (
                                    SELECT  d.Monto as Monto
                                    FROM detalleingreso d  
                                    WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
                                    AND d.CABINA_Id = $cabina->Id
                                    AND d.moneda = 1
                                    AND d.TIPOINGRESO_Id = $gasto->TIPOINGRESO_Id
                                    GROUP BY d.moneda
                                    ) as MontoDolares, 

                                    (
                                    SELECT  d.Monto as Monto
                                    FROM detalleingreso d 
                                    WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                    AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
                                    AND d.CABINA_Id = $cabina->Id
                                    AND d.moneda = 2
                                    AND d.TIPOINGRESO_Id = $gasto->TIPOINGRESO_Id
                                    GROUP BY d.moneda
                                    )  as MontoSoles
                                    
                                  FROM detalleingreso d
                                  WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
                                  AND d.TIPOINGRESO_Id = $gasto->TIPOINGRESO_Id    
                                  AND d.CABINA_Id = $cabina->Id;";
                $MontoGasto = Detalleingreso::model()->findBySql($sqlMontoGasto);
               
                if ($MontoGasto!=NULL){
                     $moneda = Detallegasto::monedaGasto($MontoGasto->moneda);
                                $fondo = '';
                                if($moneda == 'S/.'){
                                    $fondo = 'background: #1967B2;';
                                }else{
                                    $fondo = 'background: #00992B;';
                                }
                            if ($count>0){
                                    $content.="<td></td>";
                                    if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null){
                                        $content.="<td style='padding:0;color: #FFF; font-size:10px;'><table style='border-collapse:collapse;margin-bottom: 0px;'><tr style='background: #1967B2;'><td >$MontoGasto->MontoSoles S/.</td></tr> <tr style='background: #00992B;'><td >$MontoGasto->MontoDolares USD$</td></tr></table></td>";
                                    }else{
                                        $content.="<td style='width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }

                            }else{
                                
                                $content.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->nombreTipoDetalle</h3></td>";
                                    if($MontoGasto->MontoDolares != null && $MontoGasto->MontoSoles != null){
                                        $content.="<td style='padding:0;color: #FFF; font-size:10px;'><table style='border-collapse:collapse;margin-bottom: 0px;'><tr style='background: #1967B2;'><td >$MontoGasto->MontoSoles S/.</td></tr> <tr style='background: #00992B;'><td >$MontoGasto->MontoDolares USD$</td></tr></table></td>";
                                    }else{
                                        $content.="<td style='width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    }
                                    
                            }
                }  else {
                    if ($count>0){
                        $content.="<td></td>";
                    }else{
                        $content.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td>";
                    }
                }
                $count++;
            }
            
            $sqlT = "select 
                    (SELECT SUM(d.Monto) AS Monto 
                                   FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id  
                                   WHERE t.Id=$gasto->TIPOINGRESO_Id AND EXTRACT(YEAR FROM d.FechaMes)='$año' AND EXTRACT(MONTH FROM d.FechaMes)='$mes2' AND d.moneda=1 ) as MontoD,
                    (SELECT SUM(d.Monto) AS Monto 
                                   FROM detalleingreso AS d INNER JOIN tipo_ingresos AS t ON d.TIPOINGRESO_Id=t.id  
                                   WHERE t.Id=$gasto->TIPOINGRESO_Id AND EXTRACT(YEAR FROM d.FechaMes)='$año' AND EXTRACT(MONTH FROM d.FechaMes)='$mes2' AND d.moneda=2) as MontoS
                    FROM detallegasto as d
                    LIMIT 1;";
            $monts = Detalleingreso::model()->findAllBySql($sqlT);
            foreach ($monts as $key => $mont) {
                $MS = $mont->MontoS;
                $MD = $mont->MontoD;
            } 
    
     $tr.="<tr id='ordenPago'> 
         
             $content <td style='background: #DADFE4;'></td>";
                 
             if($MS!=null){
                 $tr.="<td style='width: 80px;color: #FFF; background: #1967B2; font-size:10px;'>$MS</td>";
             }else{
                 $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;'>$MS</td>";
             }
             
             if($MD!=null){
                 $tr.="<td style='width: 80px;color: #FFF; background: #00992B; font-size:10px;'>$MD</td>";
             }else{
                 $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;'>$MD</td>";
             }
    
     $tr.="</tr>";
 
     echo $tr;
         
    }
    echo $row;
    // TOTALES SOLES         
    echo "<tr>
        
            <td style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'><h3>Total Soles</h3></td>";
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY Nombre = 'COMUN CABINA', Nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            foreach ($cabinas as $key => $cabina) {
                $sqlTotales = "SELECT  sum(d.Monto) as MontoS 
                               FROM detalleingreso as d 
                               WHERE d.CABINA_Id = $cabina->Id 
                               AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                               AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                               AND d.moneda = 2;";       
   
                $totales = Detalleingreso::model()->findAllBySql($sqlTotales);
                foreach ($totales as $key => $total) {

                if($total->MontoS != null)
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;'>".Detallegasto::montoGasto($total->MontoS)."</td>";
                else
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'></td>";            


                }
            }
            
            $sqlTS = "select (SELECT  sum(d.Monto) as Monto FROM detalleingreso as d WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' AND d.moneda = 1)
                    as MontoD,
                    (SELECT  sum(d.Monto) as Monto FROM detalleingreso as d WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' AND d.moneda = 2) 
                    as MontoS
                    FROM detallegasto as d
                    LIMIT 1;";
        $montsS = Detallegasto::model()->findAllBySql($sqlTS);
        foreach ($montsS as $key => $montS) {
            $MTS = $montS->MontoS;
        }    
       
            echo "<td style='height: em; background-color: #DADFE4;'></td>";
            
            if($MTS!=null){
                 echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;'>$MTS</td><td></td>";
             }else{
                 echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'>$MTS</td><td></td>";
             }
  
    echo "</tr>";
 
    // TOTALES DOLARES         
    echo "<tr>
        
            <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'><h3>Total Dolares</h3></td>";
         
            foreach ($cabinas as $key => $cabina) {
                $sqlTotales = "SELECT  sum(d.Monto) as MontoD 
                               FROM detalleingreso as d 
                               WHERE d.CABINA_Id = $cabina->Id 
                               AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                               AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                               AND d.moneda = 1;";        
                
                
                $totales = Detalleingreso::model()->findAllBySql($sqlTotales);
                foreach ($totales as $key => $total) {

                if($total->MontoD != null){
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;'>".Detallegasto::montoGasto($total->MontoD)."</td>";

                }else{
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'></td>";            
                }
            
        }
            }
            foreach ($montsS as $key => $montS) {
                $MTD = $montS->MontoD;
            }
            
            echo "<td style='height: em; background-color: #DADFE4;'></td><td></td>";
            if($MTD!=null){
                 echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;'>$MTD</td>";
             }else{
                 echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'>$MTD</td>";
             }
       
                  
            echo "</tr>";     
          
    
    ?>
    
    
</tbody>
</table>
<?php }?>

