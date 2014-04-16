<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m-d");

if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesionM',date("Y-m-d"));
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesionM',$_POST["formFecha"]);
        $mes=Yii::app()->user->getState('mesSesionM');
    }
    elseif(strlen(Yii::app()->user->getState('mesSesionM')) && Yii::app()->user->getState('mesSesionM')!="")
    {
        $mes = Yii::app()->user->getState('mesSesionM');
    } 
}
        
$sql="SELECT t.Nombre as TipoNovedad
FROM novedad as n
INNER JOIN tiponovedad as t ON t.Id = n.TIPONOVEDAD_Id
WHERE n.Fecha = '$mes'
GROUP BY t.Nombre
ORDER BY t.Nombre;";
$model = Novedad::model()->findAllBySql($sql);
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NovedadController::controlAcceso($tipoUsuario);
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
        Matriz General de Fallas  
        <?php echo $mes; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoMatriz" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelMatriz" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonMatriz' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('novedad/matrizNovedad') ?>">
    <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
        <div style="width: 40em;">
            <div class="buttons" style="float: right;">
                <input type="submit" name="boton" value="Actualizar"/>
                <input type="submit" name="boton" value="Resetear Valores"/>
            </div>
            <label for="dateMonth">
                Seleccione un Día:
            </label>
            <?php
            
            $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                        'language' => 'es', 
                        'model' =>$model,
                        //'value' =>date('d/m/Y',strtotime($model->admission_date)),
                        'attribute'=>'Fecha', 
                        'options' => array(
                        'dateFormat'=>'yy-mm-dd',
                        'changeMonth' => 'true',//para poder cambiar mes
                        'changeYear' => 'true',//para poder cambiar año
                        'showButtonPanel' => 'false', 
                        'constrainInput' => 'false',
                        'showAnim' => 'show',
                        //'minDate'=>'-30D', //fecha minima
                        'maxDate'=> "-0D", //fecha maxima
                         ),
                            'htmlOptions'=>array(
                                'readonly'=>'readonly',
                                'name'=>'formFecha',
                                ),
                    ));
            
            
            ?>  
        </div>
    </div>
</form>
<div style="display: block;">&nbsp;</div>
<div style="display: block;">&nbsp;</div>
<br>
<!--
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
-->
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
                <td style='background-color: none;'></td>
                <td ></td>
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
        
          
            $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND id !=18 ORDER BY nombre";
            $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
            $count = 0;
            foreach ($cabinas as $key => $cabina) {
                
                $MontoGasto = Novedad::getLocutorioOldTable($cabina->Id,$gasto->TipoNovedad,$mes);
                if($MontoGasto == false)
                    $MontoGasto = Novedad::getLocutorioNewTable($cabina->Id,$gasto->TipoNovedad,$mes);
               
                if ($MontoGasto!=NULL){
                                $fondo = '';

                            if ($count>0){
                                
                                $content.="<td style='width: 80px;color: #; $fondo; font-size:10px;'>$MontoGasto</td>";

                            }else{
                                
                                $content.="<td style='width: 200px; background: #1967B2'><h3>$gasto->TipoNovedad</h3></td>";
                                $content.="<td style='width: 80px;color: #; $fondo; font-size:10px;'>$MontoGasto</td>";
                            }
                }  else {
                    if ($count>0){
                        $content.="<td></td>";
                    }else{
                        $content.="<td style='width: 200px; background: #1967B2'><h3>$gasto->TipoNovedad</h3></td>";
                    }
                }
                $count++;
            }
              
    
     $tr.="<tr id='ordenPago'> 
         
             $content     
                 
           </tr>";
 
     echo $tr;
         
    }

    ?>
    
    
</tbody>
</table>
<?php }?>

