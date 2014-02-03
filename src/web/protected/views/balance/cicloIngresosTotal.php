<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = BalanceController::controlAcceso($tipoUsuario);
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
<h1>
    <span class="enviar">
        Ciclo de Ingresos Total <?php echo $_POST["formFecha"]; ?>
    </span>
    <span style="display: none">
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/print.png' class='printButton' />
    </span>
</h1>
<div>
    <div style="float: left;width: 40%;">
        <table width="200" border="1">
          <tr>
            <td width="64"><form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Ciclo_Ingresos_Total" method="post" target="_blank" id="FormularioExportacion">    
            <p>Exportar Resumido a Excel  <img title="Exportar Resumido a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" /></p>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
        </form></td>
            <td width="120" style="display: none"><form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Ciclo_Ingresos_Completo" method="post" target="_blank" id="FormularioExportacionCompleto">
            <p>Exportar Completo a Excel  <img title="Exportar a Excel COMPLETO" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcelCompleto" /></p>
            <input type="hidden" id="datos_a_enviar_completo" name="datos_a_enviar" />
        </form></td>
          </tr>
        </table>
    </div>
    <div style="float: left;width: 60%;padding-top: 2%;" >
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
    <div style="display: block;">&nbsp;</div>
</div>
    <div style="display: block;">&nbsp;</div>
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
<div style="display: block;">&nbsp;</div>
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
<?php

$mes = NULL;

if(isset($_POST["formFecha"]) && $_POST["formFecha"]!=""){
    Yii::app()->user->setState('fechaCicloIngresosTotal',$_POST["formFecha"]);
    $mes = $_POST["formFecha"];
}
elseif(strlen(Yii::app()->user->getState('fechaCicloIngresosTotal')) && Yii::app()->user->getState('fechaCicloIngresosTotal')!=""){
    $mes = Yii::app()->user->getState('fechaCicloIngresosTotal');
}

$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosResumido',
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
                    'id'=>'datepicker_for_Fecha',
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
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosResumidoOculta',
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
            'value'=>'Yii::app()->format->formatDecimal(2.64)',
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
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosCompletoActivas',
    'dataProvider'=>$model->searchEs('cicloIngresoTotal'),
    'filter'=>$model,
    'htmlOptions'=>array(
        'class'=>'grid-view balanceCicloIngresosCompleto oculta',
        'rel'=>'completa',
        'name'=>'vistaoculta',
        ),
    'columns'=>array(
        array(
            'name'=>'Fecha',
            'value'=>'$data->Fecha',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
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
            'name'=>'Trafico',
            'value'=>'$data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'RecargaMovistar',
            'value'=>'$data->RecargaCelularMov+$data->RecargaFonoYaMov',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'RecargaClaro',
            'value'=>'$data->RecargaCelularClaro+$data->RecargaFonoClaro',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'OtrosServicios',
            'value'=>'$data->OtrosServicios',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Total',
            'value'=>'$data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;  width:150px;'
                ),
            ),
        'FechaDep',
        array(
            'name'=>'FechaDep',
            'value'=>'$data->FechaDep',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'HoraDep',
            'value'=>'$data->HoraDep',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'MontoDeposito',
            'value'=>'$data->MontoDeposito',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'MontoBanco',
            'value'=>'$data->MontoBanco',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'DifBancoCI',
            'value'=>'$data->MontoBanco-($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array(
            'name'=>'ConciliacionBancaria',
            'value'=>'$data->MontoBanco-$data->MontoDeposito',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        'RecargaVentasMov',
        array(
            'name'=>'DifMov',
            'value'=>'$data->RecargaVentasMov-($data->RecargaCelularMov+$data->RecargaFonoYaMov)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        'RecargaVentasClaro',
        array(
            'name'=>'DifClaro',
            'value'=>'$data->RecargaVentasClaro-($data->RecargaCelularClaro+$data->RecargaFonoClaro)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        'TraficoCapturaDollar',
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'$data->TraficoCapturaDollar',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Paridad',
            'value'=>'2.64',
            'type'=>'text',
        ),
        array(
            'name'=>'CaptSoles',
            'value'=>'$data->TraficoCapturaDollar*2.64',
            'type'=>'text',
        ),
        array(
            'name'=>'DifSoles',
            'value'=>'($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*2.64)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        array(
            'name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*2.64)/2.64)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
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
));
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosCompletoInactivas',
    'dataProvider'=>$model->disable(),
    'filter'=>$model,
    'htmlOptions'=>array(
        'class'=>'grid-view balanceCicloIngresosCompleto oculta',
        'rel'=>'completa',
        'name'=>'ocultaoculta',
        ),
    'columns'=>array(
        array(
            'name'=>'Fecha',
            'value'=>'$data->Fecha',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
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
            'name'=>'Trafico',
            'value'=>'$data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'RecargaMovistar',
            'value'=>'$data->RecargaCelularMov+$data->RecargaFonoYaMov',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'RecargaClaro',
            'value'=>'$data->RecargaCelularClaro+$data->RecargaFonoClaro',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'OtrosServicios',
            'value'=>'$data->OtrosServicios',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Total',
            'value'=>'$data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;  width:150px;'
                ),
            ),
        'FechaDep',
        array(
            'name'=>'FechaDep',
            'value'=>'$data->FechaDep',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'HoraDep',
            'value'=>'$data->HoraDep',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'MontoDeposito',
            'value'=>'$data->MontoDeposito',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'MontoBanco',
            'value'=>'$data->MontoBanco',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'DifBancoCI',
            'value'=>'$data->MontoBanco-($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array(
            'name'=>'ConciliacionBancaria',
            'value'=>'$data->MontoBanco-$data->MontoDeposito',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        'RecargaVentasMov',
        array(
            'name'=>'DifMov',
            'value'=>'$data->RecargaVentasMov-($data->RecargaCelularMov+$data->RecargaFonoYaMov)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        'RecargaVentasClaro',
        array(
            'name'=>'DifClaro',
            'value'=>'$data->RecargaVentasClaro-($data->RecargaCelularClaro+$data->RecargaFonoClaro)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        'TraficoCapturaDollar',
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'$data->TraficoCapturaDollar',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Paridad',
            'value'=>'2.64',
            'type'=>'text',
        ),
        array(
            'name'=>'CaptSoles',
            'value'=>'$data->TraficoCapturaDollar*2.64',
            'type'=>'text',
        ),
        array(
            'name'=>'DifSoles',
            'value'=>'($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*2.64)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        array(
            'name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*2.64)/2.64)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
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
));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>
</div>
<!--</div>-->