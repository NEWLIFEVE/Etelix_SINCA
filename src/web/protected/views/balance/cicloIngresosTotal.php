<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = BalanceController::controlAcceso($tipoUsuario);

$mes=null;


    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        $mes=$_POST["formFecha"];
    }
    
//    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
//    {
//        Yii::app()->user->setState('fechaCicloIngresosTotal',$_POST["formFecha"]);
//        $mes=Yii::app()->user->getState('fechaCicloIngresosTotal');
//    }
//    elseif(strlen(Yii::app()->user->getState('fechaCicloIngresosTotal')) && Yii::app()->user->getState('fechaCicloIngresosTotal')!="")
//    {
//        $mes = Yii::app()->user->getState('fechaCicloIngresosTotal');
//    } 
$año = date("Y", strtotime($mes));  
?>

<script>

    $(document).ready(function(){

        $("#datepicker").datepicker({
            dateFormat: 'mm-yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function(dateText, inst) {  
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        });

        $("#datepicker").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });    
        });

    });
  
    $(function($){
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });

    $(document).ready(function()
    {
        $("#mostrarFormulas").click(function()
        {
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
        Ciclo de Ingresos Total <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año : ""; ?>
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoTotal" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelTotal" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonTotal'/>
        <div style="margin-top: 8px;">  
            <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/cicloIngresosTotal') ?>">
                <label for="datepicker">
                    Seleccione un mes:
                </label>
                <input type="text" id="datepicker" name="formFecha" size="30" readonly/>
                <span class="buttons">
                <input type="submit" value="Actualizar"/>
                </span>
            </form>
        </div>
    </span>
</h1>
<div id="cicloingresosbotons">
<!--        <div style="float: left;width: 50%;" >
        <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/cicloIngresosTotal') ?>">
            <label for="datepicker">
                Seleccione un mes:
            </label>
            <input type="text" id="datepicker" name="formFecha" size="30" readonly/>
            <span class="buttons">
            <input type="submit" value="Actualizar"/>
            </span>
        </form>
    </div>-->
    <div id="botonsExport">
    <ul>
        <li style="display:none;">
            Resumido      <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoTotal" />
                    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelTotal" />
                    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonTotal'/>

        </li>
        <li style="display:none;">
            <form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Ciclo_Ingresos_Completo" method="post" target="_blank" id="FormularioExportacionCompleto">
                Completo      <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoComplete" />
                        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelComplete" />
                        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonComplete'/>
                <input type="hidden" id="datos_a_enviar_completo" name="datos_a_enviar" />
            </form>
        </li>
    </div>
</div>
<button id="cambio" style="display: none">Inactivas</button>

<?php
$this->widget('application.extensions.fancybox.EFancyBox',array(
    'target'=>'a[rel^="fancybox"]',
    'config'=>array(),
    )
);
?>

<table style="display: none" class="items">
    <thead>
        <tr>
            <th><?php echo CHtml::link('Libro de Ventas', '/balance/pop/1',array('rel'=>'fancybox1')); ?></th>
            <th><?php echo CHtml::link('Depositos Bancarios', '/balance/pop/2',array('rel'=>'fancybox2')); ?></th>
            <th><?php echo CHtml::link('Brighstar', '/balance/pop/3',array('rel'=>'fancybox3')); ?></th>
            <th><?php echo CHtml::link('Captura', '/balance/pop/4',array('rel'=>'fancybox4')); ?></th>
        </tr>
    </thead>
</table>
<div>
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
</div>
<div class="output" style="overflow: auto;">
<div id="fecha" style="display: none;"><?php echo $mes != NULL ? date('Ym',strtotime($mes)): "";?></div>   
<?php

$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosTotalResumido',
    'htmlOptions'=>array(
        'class'=>'grid-view CicloIngresosResumido',
        'rel'=>'total',
        'name'=>'vista',
        ),
    'dataProvider'=>$model->searchEs('cicloIngresoTotal',$mes),
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
            'name' => 'Fecha',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'Fecha',
                'language' => 'ja',
                'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
                'htmlOptions' => array(
                    'id' => 'datepicker_for_Fecha',
                    'size' => '25',
                ),
                'defaultOptions' => array(// (#3)
                    'showOn' => 'focus',
                    'dateFormat' => 'yy-mm-dd',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showButtonPanel' => true,
                )
                    ), true),
            'htmlOptions' => array(
                'style' => 'text-align: center;',
                'id'=>'fecha',
            ),
        ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->tagTodasLasCabina',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Total',
            'value'=> 'Balance::totalVentas($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;  width:150px;',
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'DifBancoCI',
            'value'=> 'Balance::diferencialBancario($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBancario',
                ),
            ),
        array(
            'name'=>'ConciliacionBancariaCI',
            'value'=>'Balance::conciliacionBancaria($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'concilicacionBancaria',
                ),
            ),
        array(
            'name'=>'DifMov',
            'value'=>'Balance::diferencialBrightstarMovistar($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarMovistar',
                ),
            ),
        array(
            'name'=>'DifClaro',
            'value'=>'Balance::diferencialBrightstarClaro($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarClaro',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Balance::paridadCambiaria($data->Fecha)',
            'type'=>'text',
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Balance::diferencialCapturaSoles($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaSoles',
                ),
            ),
        array('name'=>'DifDollar',
            'value'=>'Balance::diferencialCapturaDollar($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
                ),
            ),
        /*array('name'=>'Acumulado',
            'value'=>'Balance::acumuladoTotal($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'Acumulado',
                ),
            ),*/
        array('name'=>'Acumulado',
            'value'=>'Balance::Acumulado($data->Fecha,$data->CABINA_Id,true)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'acumulado',
                ),
            ),
        array('name'=>'Sobrante',
            'value'=>'Balance::sobranteTotal($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobrante',
                ),
            ),
        /*array('name'=>'SobranteAcum',
            'value'=>'Balance::sobranteAcumTotal($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobranteAcum',
                ),
            ),*/
        array('name'=>'SobranteAcum',
            'value'=>'Balance::SobranteAcumulado($data->Fecha,$data->CABINA_Id,true)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobranteAcum',
                ),
            ),
        ),
    )
);
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosTotalResumidoOculta',
    'htmlOptions'=>array(
        'class'=>'grid-view CicloIngresosResumido oculta',
        'rel'=>'total',
        'name'=>'oculta',
        ),
    'dataProvider'=>$model->disable(),
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
            'htmlOptions'=>array(
                'id'=>'fecha',
                ),
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'Fecha',
                'language'=>'ja',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_FechaInactiva',
                    'size'=>'10',
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
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Total',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;  width:150px;',
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'DifBancoCI',
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBancario',
                ),
            ),
        array(
            'name'=>'ConciliacionBancariaCI',
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-$data->MontoDeposito)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'concilicacionBancaria',
                ),
            ),
        array(
            'name'=>'DifMov',
            'value'=>'Yii::app()->format->formatDecimal($data->RecargaVentasMov-($data->RecargaCelularMov+$data->RecargaFonoYaMov))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarMovistar',
                ),
            ),
        array(
            'name'=>'DifClaro',
            'value'=>'Yii::app()->format->formatDecimal($data->RecargaVentasClaro-($data->RecargaCelularClaro+$data->RecargaFonoClaro))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBrightstarClaro',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Balance::paridadCambiaria($data->Fecha)',
            'type'=>'text',
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*2.64))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaSoles',
                ),
            ),
        array('name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*2.64)/2.64)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
                ),
            ),
        array('name'=>'Acumulado',
            'value'=>'Balance::acumuladoTotal($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'Acumulado',
                ),
            ),
        array('name'=>'Sobrante',
            'value'=>'Balance::sobranteTotal($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'Sobrante',
                ),
            ),
        array('name'=>'SobranteAcum',
            'value'=>'Balance::sobranteAcumTotal($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'SobranteAcum',
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
<div style="display: none">
<table class="items">
    <thead>
        <tr>
            <th id="totalFecha" style="background:rgba(0, 153, 0, 1);color:white;"></th>
            <th id="totalCabinas" style="background:rgba(0, 153, 0, 1);color:white;">Todas las cabinas</th>
            <th id="totalVentas2" style="background:rgba(255,187,0,1);color:white;"></th>
            <th id="totalDiferencialBancario" style="background:rgba(51,153,153,1);color:white;"></th>
            <th id="totalConcilicacionBancaria" style="background:rgba(51,153,153,1);color:white;"></th>
            <th id="totalesDiferencialBrightstarMovistar" style="background:rgba(255,153,51,1);color:white;"></th>
            <th id="totalesDiferencialBrightstarClaro" style="background:rgba(255,153,51,1);color:white;"></th>
            <th id="paridad" style="background:rgba(204,153,204,1);color:white;">Paridad Cambiaria: N/A</th>
            <th id="totalesDiferencialCapturaSoles" style="background:rgba(204,153,204,1);color:white;"></th>
            <th id="totalesDiferencialCapturaDollar" style="background:rgba(204,153,204,1);color:white;"></th>
        </tr>
    </thead>
</table>
</div>
<?php
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>
</div>
<!--</div>-->