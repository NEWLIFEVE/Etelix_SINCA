<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m-d");

if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesionMS',date("Y-m-d"));
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesionMS',$_POST["formFecha"]);
        $mes=Yii::app()->user->getState('mesSesionMS');
    }
    elseif(strlen(Yii::app()->user->getState('mesSesionMS')) && Yii::app()->user->getState('mesSesionMS')!="")
    {
        $mes = Yii::app()->user->getState('mesSesionMS');
    } 
}
        
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
        Reporte Consolidado de Fallas 
        <?php echo $mes; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoConsolidado" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelConsolidado" />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('novedad/reporteConsolidado') ?>">
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
<div id="fecha" style="display: none;"><?php echo '('.date('Y-m-j',strtotime("-6 day",strtotime($mes))).'/'.$mes.')';?></div>
<div id="fecha2" style="display: none;"><?php echo $mes;?></div>

