<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = DetalleingresoController::controlAccesoBalance($tipoUsuario);

$mes=null;
$cabina=NULL;
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        $mes=$_POST["formFecha"];
    }
    
    if(isset($_POST["formCabina"]) && $_POST["formCabina"] != "")
    {
        $cabina=$_POST["formCabina"];
    }
$año = date("Y", strtotime($mes));  
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
<h1>Ciclo de Ingresos <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año  : ""; ?></h1>
<div id="cicloingresosbotons">
    <div id="botonsExport">
    <ul>
        <li style="width: 200px;">
            <form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Ciclo_Ingresos_Resumido" method="post" target="_blank" id="FormularioExportacion" style="margin-left: 2em;">
            Resumido      <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
                    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
                    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton'/>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
            </form>
        </li>
        <li style="width: 200px;">
            <form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Ciclo_Ingresos_Completo" method="post" target="_blank" id="FormularioExportacionCompleto">
                Completo      <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoComplete" />
                        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelComplete" />
                        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonComplete'/>
                <input type="hidden" id="datos_a_enviar_completo" name="datos_a_enviar" />
            </form>
        </li>
        <li><button id="cambio" style="margin-left: -2em;">Inactivas</button></li>
    </ul>
    <div>
        <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/CicloIngresos') ?>">
            <label for="dateMonth">
                Seleccione un mes:
            </label>
            <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>
            <?php echo CHtml::dropDownList('formCabina', '', Cabina::getListCabina(), array('empty' => 'Seleccionar...')) ?>
            <span class="buttons">
                <input type="submit" value="Actualizar"/>
            </span>
        </form>
    </div>
    </div>
</div>
<div id="fecha" style="display: none;"><?php echo $mes != NULL ? date('Ym',strtotime($mes)): "";?></div>
<div id="cabina2" style="display: none;"><?php echo $cabina != NULL ? Cabina::getNombreCabina2($cabina) : "";?></div>
<?php
$this->widget('application.extensions.fancybox.EFancyBox',array(
    'target'=>'a[rel^="fancybox"]',
    'config'=>array(),
    )
);
?>
<div id="cicloingresosbotons" class="fancyboxLinks">
    <ul>
        <li>| <?php echo CHtml::link('Libro de Ventas', '/detalleingreso/pop/1',array('rel'=>'fancybox1')); ?></li>
        <li>| <?php echo CHtml::link('Depositos Bancarios', '/detalleingreso/pop/2',array('rel'=>'fancybox2')); ?></li>
        <li>| <?php echo CHtml::link('FullCarga', '/detalleingreso/pop/3',array('rel'=>'fancybox3')); ?></li>
        <li>| <?php echo CHtml::link('Captura', '/detalleingreso/pop/4',array('rel'=>'fancybox4')); ?> |</li>
    </ul>
</div>

<div id="mostrarFormulas">
    F&oacute;rmulas
</div>

<div id="tablaFormulas" class="ocultar">
<table>
    <tr>
        <td> Total  Ventas (S/.) </td>
        <td> = </td>
        <td> Fijo Local (S/.)      + Fijo Provincia (S/.)           + Fijo Lima (S/.) + Rural (S/.)  + Celular (S/.)               + LDI (S/.) +
             Otros Servicios (S/.) + Recarga Celular Movistar (S/.) + Recarga Fono Ya Movistar (S/.) + Recarga Celular Claro (S/.) + Recarga Fono Claro (S/.)
        </td>
    </tr>
    <tr>
        <td> Total Llamadas (S/.) </td>
        <td> = </td>
        <td> Fijo Local (S/.) + Fijo Provincia (S/.) + Fijo Lima (S/.) + Rural (S/.) + Celular (S/.) + LDI (S/.) </td>
    </tr>
    <tr>
        <td> Diferencial Bancario (S/.) </td>
        <td> = </td>
        <td> Monto Banco (S/.) - Total  Ventas (S/.) </td>
    </tr>
    <tr>
        <td> Conciliación Bancaria (S/.) </td>
        <td> = </td>
        <td> Monto Banco (S/.) - Monto Deposito (S/.) </td>
    </tr>
    <tr>
        <td> Diferencial Brightstar Movistar (S/.) </td>
        <td> = </td>
        <td> Recarga Ventas Movistar (S/.) -(Recarga Celular Movistar (S/.) + Recarga Fono Ya Movistar (S/.)) </td>
    </tr>
    <tr>
        <td> Diferencial Brightstar Claro (S/.) </td>
        <td> = </td>
        <td> Recarga Ventas Claro (S/.) - (Recarga Celular Claro (S/.) + Recarga Fono Claro (S/.)) </td>
    </tr>
    <tr>
        <td> Diferencial Captura Soles (S/.) </td>
        <td> = </td>
        <td> Total Llamadas (S/.) - Trafico Captura (USD $) * Paridad Cambiaria (S/.|$) </td>
    </tr>
    <tr>
        <td> Diferencial Captura Dollar (USD $) </td>
        <td> = </td>
        <td> (Total Llamadas (S/.) - Trafico Captura (USD $) * Paridad Cambiaria (S/.|$)) / Diferencial Captura Dollar (USD $) </td>
    </tr>
</table>
</div>
<div class="output" style="overflow: auto;">
<?php

/*****************************************CICLO DE INGRESOS RESUMIDO ACTIVAS*******************************************************************/

$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosResumido',
    'htmlOptions'=>array(
        'class'=>'grid-view CicloIngresosResumido',
        'rel'=>'total',
        'name'=>'vista',
        ),
    'dataProvider'=>$model->search($_POST,$mes,$cabina),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        array(
        'name'=>'Id',
        'value'=>'$data->Id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'ids',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        array(
            'name'=>'Fecha',
            'header'=>'Fecha',
            'headerHtmlOptions' => array('style' => 'width: 9%'),
            'htmlOptions'=>array(
                'id'=>'fecha',
                ),
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'Fecha',    
                'language'=>'ja',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_Fecha',
                    'size'=>'25',
                    ),
                'defaultOptions'=>array(
                    'showOn'=>'focus',
                    'dateFormat'=>'yy-mm-dd',
                    'showOtherMonths'=>true,
                    'selectOtherMonths'=>true,
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'showButtonPanel'=>true,
                    )
                ),
                true)),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;width: 100px;',
                'size'=>'35',
                )
            ),
        array(
            'name'=>'TotalVentas',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'width: 6%'),
            'htmlOptions'=>array(
                'style'=>'text-align: center;  width:150px;',
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'DiferencialBan',
            'value'=>'CicloIngresoModelo::getDifConBancario($data->Fecha,$data->CABINA_Id,1)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBancario',
                ),
            ),
        array(
            'name'=>'ConciliacionBan',
            'value'=>'CicloIngresoModelo::getDifConBancario($data->Fecha,$data->CABINA_Id,2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'concilicacionBancaria',
                ),
            ),
//        array(
//            'name'=>'DifFullCarga',
//            'value'=>'Detalleingreso::getDifFullCarga($data->Fecha, $data->CABINA_Id)',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style' => '',
//                'class'=>'dif',
//                'name'=>'dif',
//                'id'=>'diferencialFullCarga',
//                ),
//            ),
        array(
            'name'=>'DifMov',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 1)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarMovistar',
                ),
            ),
        array(
            'name'=>'DifClaro',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 2)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarClaro',
                ),
            ),
        array(
            'name'=>'DifDirecTv',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 4)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarDirecTv',
                ),
            ),
        array(
            'name'=>'DifNextel',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 3)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarNextel',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Paridad::getParidad($data->Fecha)',
            'type'=>'text',
            'headerHtmlOptions' => array('background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'paridad',
                ),
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaSoles',
                ),
            ),
        array(
            'name'=>'DifDollar',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,1)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
                ),
            ),
        array(
            'name'=>'Acumulado',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,3)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'acumuladoCI',
                ),
            ),
        array(
            'name'=>'Sobrante',
            'value'=>'CicloIngresoModelo::getSobrante($data->Fecha,$data->CABINA_Id,false)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(46,135,255,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobrante',
                ),
            ),
        array(
            'name'=>'SobranteAcum',
            'value'=>'CicloIngresoModelo::getSobrante($data->Fecha,$data->CABINA_Id,true)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(46,135,255,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobranteAcumCI',
                ),
            ),
        ),
    )
);
/**********************************************************************************************************************************************/
/*****************************************CICLO DE INGRESOS RESUMIDO INACTIVAS*****************************************************************/

    
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosResumidoOculta',
    'htmlOptions'=>array(
        'class'=>'grid-view CicloIngresosResumido oculta',
        'rel'=>'total',
        'name'=>'oculta',
        ),
    'dataProvider'=>$model->disable(),
    'afterAjaxUpdate'=>'reinstallDatePicker2',
    'filter'=>$model,
    'columns'=>array(
        array(
        'name'=>'Id',
        'value'=>'$data->Id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'ids',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        array(
            'name'=>'Fecha',
            'header'=>'Fecha',
            'htmlOptions'=>array(
                'id'=>'fecha',
                ),
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'Fecha',    
                'language'=>'ja',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_Fecha',
                    'size'=>'25',
                    ),
                'defaultOptions'=>array(
                    'showOn'=>'focus',
                    'dateFormat'=>'yy-mm-dd',
                    'showOtherMonths'=>true,
                    'selectOtherMonths'=>true,
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'showButtonPanel'=>true,
                    )
                ),
                true)),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;width: 100px;',
                'size'=>'35',
                )
            ),
        array(
            'name'=>'TotalVentas',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;  width:150px;',
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'DiferencialBan',
            'value'=>'CicloIngresoModelo::getDifConBancario($data->Fecha,$data->CABINA_Id,1)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBancario',
                ),
            ),
        array(
            'name'=>'ConciliacionBan',
            'value'=>'CicloIngresoModelo::getDifConBancario($data->Fecha,$data->CABINA_Id,2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'concilicacionBancaria',
                ),
            ),
//        array(
//            'name'=>'DifFullCarga',
//            'value'=>'Detalleingreso::getDifFullCarga($data->Fecha, $data->CABINA_Id)',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style' => '',
//                'class'=>'dif',
//                'name'=>'dif',
//                'id'=>'diferencialFullCarga',
//                ),
//            ),
        array(
            'name'=>'DifMov',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 1)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarMovistar',
                ),
            ),
        array(
            'name'=>'DifClaro',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 2)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarClaro',
                ),
            ),
        array(
            'name'=>'DifDirecTv',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 4)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarDirecTv',
                ),
            ),
        array(
            'name'=>'DifNextel',
            'value'=>'CicloIngresoModelo::getDifFullCarga($data->Fecha, $data->CABINA_Id, 3)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(255,153,51,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarNextel',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Paridad::getParidad($data->Fecha)',
            'type'=>'text',
            'headerHtmlOptions' => array('background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'id'=>'paridad',
                ),
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
                ),
            ),
        array(
            'name'=>'DifDollar',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,1)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
            ),
        ),
        array(
            'name'=>'Acumulado',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,3)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
                ),
            ),
        array(
            'name'=>'Sobrante',
            'value'=>'CicloIngresoModelo::getSobrante($data->Fecha,$data->CABINA_Id,false)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(46,135,255,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
                ),
            ),

        array(
            'name'=>'SobranteAcum',
            'value'=>'CicloIngresoModelo::getSobrante($data->Fecha,$data->CABINA_Id,true)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(46,135,255,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
                ),
            ),
        ),
    )
);

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_FechaInactiva').datepicker();
}
");
?>
<div id="totales" class="grid-view">
<table class="items" style="text-align: center;">
    <thead>
        <tr>
            <th id="totalFecha" style="background:rgba(0, 153, 0, 1);color:white;width: 64px;">Fecha</th>
            <th id="totalCabinas" style="background:rgba(0, 153, 0, 1);color:white;width: 107px;">Cabinas</th>
            <th id="totalVentas2" style="width: 12em;background:rgba(255,187,0,1);color:white;"></th>
            <th id="totalDiferencialBancario" style="background:#1967B2;color:white;"></th>
            <th id="totalConcilicacionBancaria" style="background:#1967B2;color:white;"></th>
            <th id="totalesDiferencialBrightstarMovistar" style="background:rgba(255,153,51,1);color:white;"></th>
            <th id="totalesDiferencialBrightstarClaro" style="background:rgba(255,153,51,1);color:white;"></th>
            <th id="totalesDiferencialBrightstarDirecTv" style="background:rgba(255,153,51,1);color:white;">Diferencial DirecTv (S/.)</th>
            <th id="totalesDiferencialBrightstarNextel" style="background:rgba(255,153,51,1);color:white;">Direfencial FullCarga (S/.)</th>
            <th id="paridad" style="background:rgba(204,153,204,1);color:white;">Paridad Cambiaria</th>
            <th id="totalesDiferencialCapturaSoles" style="background:rgba(204,153,204,1);color:white;"></th>
            <th id="totalesDiferencialCapturaDollar" style="background:rgba(204,153,204,1);color:white;"></th>
            <th id="totalAcumulado" style='background:#cc99cc; color:white;'></th>
            <th id="totalSobrante" style='background:#2e87ff; color:white;'></th>
            <th id="totalSobranteAcum" style='background:#2e87ff; color:white;'></th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id="totalFecha"></td>
            <td id="todas">Todas</td>
            <td id="totaltotalVentas"></td>
            <td id="totaldiferencialBancario" class="dif" style="text-align: center;"></td>
            <td id="totalconcilicacionBancaria" style="text-align: center;"></td> 
            <td id="totaldiferencialBrightstarMovistar" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialBrightstarClaro" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialBrightstarDirecTv" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialBrightstarNextel" class="dif" style="text-align: center;"></td>
            <td style="text-align: center;">N/A</td>
            <td id="totaldiferencialCapturaSoles" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialCapturaDollar" class="dif" style="text-align: center;"></td>
            <!--<td id="totalacumuladoCI" style="text-align: center;">N/A</td>-->
            <td id="" style="text-align: center;">N/A</td>
            <td id="totalsobrante" class="dif" style="text-align: center;"></td>
            <!--<td id="totalsobranteAcumCI" style="text-align: center;">N/A</td>-->
            <td id="" style="text-align: center;">N/A</td>
        </tr>
    </tbody>
</table>
</div>
<?php
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
Yii::app()->clientScript->registerScript('re-install-date-picker2', "
function reinstallDatePicker2(id, data) {
    $('#datepicker_for_Fecha_oculta').datepicker();
    $('div[name=".'"oculta"'."]').css('display','block');     
    $('div[name=".'"vista"'."]').css('display','none'); 
}
");
?>
</div>
<!--</div>-->
