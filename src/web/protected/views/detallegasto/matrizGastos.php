<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=NULL;

if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesMatrizSesion',NULL);
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesMatrizSesion',$_POST["formFecha"]."-01");
        $mes=Yii::app()->user->getState('mesMatrizSesion');
    }
    elseif(strlen(Yii::app()->user->getState('mesMatrizSesion')) && Yii::app()->user->getState('mesMatrizSesion')!="")
    {
        $mes = Yii::app()->user->getState('mesMatrizSesion');
    } 
}
$sql="SELECT DISTINCT(d.TIPOGASTO_Id) as TIPOGASTO_Id,t.Nombre as nombreTipoDetalle
              FROM detallegasto d, tipogasto t 
              WHERE d.FechaMes='$mes' AND d.TIPOGASTO_Id=t.id 
              GROUP BY t.Nombre;";
$model = Detallegasto::model()->findAllBySql($sql);
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetallegastoController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        Matriz de Gastos
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes) : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detallegasto/matrizGastos') ?>">
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
<?php
echo CHtml::beginForm(Yii::app()->createUrl('detallegasto/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo', 'style' => 'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style' => 'display:none'));
echo CHtml::textField('vista', 'estadoGastos', array('id' => 'vista', 'style' => 'display:none'));
echo CHtml::textField('correoUsuario', Yii::app()->getModule('user')->user()->email, array('id' => 'email', 'style' => 'display:none'));
echo CHtml::textField('asunto', 'Reporte de Estado de Gastos Solicitado', array('id' => 'asunto', 'style' => 'display:none'));
echo CHtml::endForm();
echo "<form action='";
?>
<?php
echo Yii::app()->request->baseUrl;
?>
<?php
echo "/ficheroExcel.php?nombre=Estado_Gastos_".date("Y-m-d");
echo $mes != NULL ? "_". Utility::monthName($mes) : "";
echo "' name='excel' method='post' target='_blank' id='FormularioExportacion'>
        <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
     </form>";
echo CHtml::beginForm(Yii::app()->createUrl('detallegasto/updateGasto'), 'post', array('name' => 'actualizar', 'id' => 'Form'));
?>
<?php 

if (count($model)> 1) { ?>
<table id="tabla" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
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
    </tr>
 <?php    foreach ($model as $key => $gasto) {
        $tr="";
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
//                            var_dump($gasto->nombreTipoDetalle);
                            if ($count>0){
                                $opago.="<td style='color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $opago.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='color: #FFF; background: #ff9900; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            $aprobado.="<td></td>";
                            $pagado.="<td></td>";
                            break;
                        case "2":
//                            var_dump($gasto->nombreTipoDetalle);
                            $opago.="<td></td>";
                            if ($count>0){
                                $aprobado.="<td style='color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $aprobado.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='color: #FFF; background: #1967B2; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            
                            $pagado.="<td></td>";
                            break;
                        case "3":
//                            var_dump($gasto->nombreTipoDetalle);
                            $opago.="<td></td>";
                            $aprobado.="<td></td>";
                            if ($count>0){
                                $pagado.="<td style='color: #FFF; background: #00992B; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }else{
                                $pagado.="<td rowspan='3' style='width: 120px; background: #1967B2'><h3>$gasto->nombreTipoDetalle</h3></td><td style='color: #FFF; background: #00992B; font-size:10px;'>$MontoGasto->Monto $moneda</td>";
                            }
                            break;
                    }
                }  else {
//                    var_dump($gasto->nombreTipoDetalle);
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
    <tr style='height: em; background-color: #DADFE4; border=0 px white solid;'>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>";
     echo $tr;
    }
    ?>
</tbody>
</table>
<?php }?>

