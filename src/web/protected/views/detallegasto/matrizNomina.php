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
        
$sql="SELECT FechaMes, beneficiario, Monto, CABINA_Id 
      FROM detallegasto
      WHERE TIPOGASTO_Id = 75
      AND EXTRACT(YEAR FROM FechaMes) = '$año' 
      AND EXTRACT(MONTH FROM FechaMes) = '$mes2'
      AND status IN (2,3)
      ORDER BY beneficiario;";
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
        Matriz de Nomina
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes).' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoMatriz" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelMatriz" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonMatriz' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detallegasto/matrizNomina') ?>">
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
<table id="tablaNomina" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
    <thead>
        <th style="background-color: #ff9900;"><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></th>
        <th style="background-color: #ff9900;"><h3>Chimbote</h3></th>
        <th style="background-color: #ff9900;"><h3>Etelix-Peru</h3></th>
        <th style="background-color: #ff9900;"><h3>Huancayo</h3></th>
        <th style="background-color: #ff9900;"><h3>Iquitos 01</h3></th>
        <th style="background-color: #ff9900;"><h3>Iquitos 03</h3></th>
        <th style="background-color: #ff9900;"><h3>Piura</h3></th>
        <th style="background-color: #ff9900;"><h3>Pucallpa</h3></th>
        <th style="background-color: #ff9900;"><h3>Surquillo</h3></th>
        <th style="background-color: #ff9900;"><h3>Tarapoto</h3></th>
        <th style="background-color: #ff9900;"><h3>Trujillo 01</h3></th>
        <th style="background-color: #ff9900;"><h3>Trujillo 03</h3></th>
        <!-- <th style="background-color: #ff9900;"><h3>Comun Cabina</h3></th> -->
        
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
              </tr>";
 
        foreach ($model as $key => $gasto) {
        $tr="";
        $content="";
        $MTS="";
        $MTD="";
        
          
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                $sqlMontoGasto = "SELECT d.beneficiario, d.Monto as Monto, d.status, d.moneda
                                  FROM detallegasto d
                                  WHERE EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                                  AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2'
                                  AND d.TIPOGASTO_Id=75
                                  AND d.beneficiario = '$gasto->beneficiario'
                                  AND d.CABINA_Id = $cabina->Id
                                  AND d.status IN (2,3);";
                $MontoGasto = Detallegasto::model()->findBySql($sqlMontoGasto);
               
                if ($MontoGasto!=NULL){
                     $moneda = Detallegasto::monedaGasto($MontoGasto->moneda);
                                $fondo = '';
                                if($moneda == 'S/.'){
                                    $fondo = 'background: #1967B2;';
                                }else{
                                    $fondo = 'background: #00992B;';
                                }
                            if ($count>0){
                                
                                $content.="<td style='width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";

                            }else{
                                
                                $content.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->beneficiario</h3></td>";
                                $content.="<td style='width: 80px;color: #FFF; $fondo; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                                    
                            }
                }  else {
                    if ($count>0){
                        $content.="<td></td>";
                    }else{
                        $content.="<td rowspan='1' style='width: 200px; background: #1967B2'><h3>$gasto->beneficiario</h3></td>";
                    }
                }
                $count++;
            }
              
    
     $tr.="<tr id='ordenPago'> 
         
             $content     
                 
           </tr>";
 
     echo $tr;
         
    }
    echo $row;
    // TOTALES SOLES         
    echo "<tr>
        
            <td style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'><h3>Totales Soles</h3></td>";
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 AND id != 19 ORDER BY nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            foreach ($cabinas as $key => $cabina) {
                $sqlTotales = "SELECT  sum(d.Monto) as MontoS 
                               FROM detallegasto as d 
                               WHERE d.CABINA_Id = $cabina->Id 
                               AND d.TIPOGASTO_Id=75 AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                               AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                               AND d.moneda = 2 
                               AND d.status IN (2,3);";       
   
                $totales = Detallegasto::model()->findAllBySql($sqlTotales);
                foreach ($totales as $key => $total) {

                if($total->MontoS != null)
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #1967B2;'>".Detallegasto::montoGasto($total->MontoS)."</td>";
                else
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'></td>";            


                }
            }
  
    echo "</tr>";
 
    // TOTALES DOLARES         
    echo "<tr>
        
            <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'><h3>Totales Dolares</h3></td>";
         
            foreach ($cabinas as $key => $cabina) {
                $sqlTotales = "SELECT  sum(d.Monto) as MontoD 
                               FROM detallegasto as d 
                               WHERE d.CABINA_Id = $cabina->Id 
                               AND d.TIPOGASTO_Id=75 AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                               AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                               AND d.moneda = 1 
                               AND d.status IN (2,3);";        
                
                
                $totales = Detallegasto::model()->findAllBySql($sqlTotales);
                foreach ($totales as $key => $total) {

                if($total->MontoD != null){
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: #00992B;'>".Detallegasto::montoGasto($total->MontoD)."</td>";

                }else{
                    echo "<td style='padding:0;color: #FFFFFF;font-size:10px;background-color: none;'></td>";            
                }
            
        }
            }
       
                  
            echo "</tr>";     
    echo $row;        
    // GRAN TOTALES SOLES         
    echo "<tr>
        
            <td style='color: #FFF;width: 120px; background: #00992B;font-size:10px;'><h3>Gran Totales Soles</h3></td>";

                $sqlTotales = "SELECT  sum(d.Monto) as MontoS 
                               FROM detallegasto as d 
                               WHERE d.TIPOGASTO_Id=75 
                               AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                               AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                               AND d.moneda = 2 
                               AND d.status IN (2,3);";       
   
                $totales = Detallegasto::model()->findAllBySql($sqlTotales);
                foreach ($totales as $key => $total) {

                if($total->MontoS != null)
                    echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Detallegasto::montoGasto($total->MontoS)."</td>";
                else
                    echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            


                }

  
    echo "</tr>";
    
    // GRAN TOTALES DOLARES         
    echo "<tr>
        
            <td style='color: #FFF;width: 120px; background: #00992B;font-size:10px;'><h3>Gran Totales Dolares</h3></td>";

                $sqlTotales = "SELECT  sum(d.Monto) as MontoD 
                               FROM detallegasto as d 
                               WHERE d.TIPOGASTO_Id=75 
                               AND EXTRACT(YEAR FROM d.FechaMes) = '$año' 
                               AND EXTRACT(MONTH FROM d.FechaMes) = '$mes2' 
                               AND d.moneda = 1 
                               AND d.status IN (2,3);";       
   
                $totales = Detallegasto::model()->findAllBySql($sqlTotales);
                foreach ($totales as $key => $total) {

                if($total->MontoD != null)
                    echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>".Detallegasto::montoGasto($total->MontoD)."</td>";
                else
                    echo "<td style='padding:0;color: #000000;font-size:10px;background-color: #DADFE4;'>00.00</td>";            

                }

  
    echo "</tr>";
    ?>
    
    
</tbody>
</table>
<?php }?>
