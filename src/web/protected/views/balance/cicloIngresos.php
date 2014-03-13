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
            <form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Ciclo_Ingresos_Resumido" method="post" target="_blank" id="FormularioExportacion">
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
        <li><button id="cambio">Inactivas</button></li>
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
<div id="fecha" style="display: none;"><?php echo date('Ym',strtotime($mes));?></div>
<?php
$this->widget('application.extensions.fancybox.EFancyBox',array(
    'target'=>'a[rel^="fancybox"]',
    'config'=>array(),
    )
);
?>
<div id="cicloingresosbotons">
    <ul>
        <li>| <?php echo CHtml::link('Libro de Ventas', '/balance/pop/1',array('rel'=>'fancybox1')); ?></li>
        <li>| <?php echo CHtml::link('Depositos Bancarios', '/balance/pop/2',array('rel'=>'fancybox2')); ?></li>
        <li>| <?php echo CHtml::link('Brightstar', '/balance/pop/3',array('rel'=>'fancybox3')); ?></li>
        <li>| <?php echo CHtml::link('Captura', '/balance/pop/4',array('rel'=>'fancybox4')); ?> |</li>
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
    'dataProvider'=>$model->search($_POST,$mes),
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
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)))',
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
            'value'=>'Yii::app()->format->formatDecimal($data->pARIDAD->Valor)',
            'type'=>'text',
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*$data->pARIDAD->Valor))',
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
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*$data->pARIDAD->Valor)/$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
            ),
        ),
        array('name'=>'Acumulado',
            'value'=>'$data->Acumulado',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'acumulado',
                ),
            ),
        array('name'=>'Sobrante',
            'value'=>'Balance::sobrante($data->Fecha,$data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobrante',
                ),
            ),
        array('name'=>'SobranteAcum',
            'value'=>'$data->SobranteAcum',
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
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)))',
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
            'value'=>'Yii::app()->format->formatDecimal($data->pARIDAD->Valor)',
            'type'=>'text',
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*$data->pARIDAD->Valor))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaSoles',
                ),
            ),
        array('name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*$data->pARIDAD->Valor)/$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
                ),
            ),
        array('name'=>'Acumulado',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'acumulado',
                ),
            ),
        array('name'=>'Sobrante',
            'value'=>'Balance::sobrante($data->Fecha,$data->CABINA_Id,"inactivas")',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'sobrante',
                ),
            ),
        array('name'=>'SobranteAcum',
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
<table class="items">
    <thead>
        <tr>
            <th id="" style="background:rgba(0, 153, 0, 1);color:white;">Fecha</th>
            <th id="totalCabinas" style="background:rgba(0, 153, 0, 1);color:white;">Cabinas</th>
            <th id="totalVentas2" style="background:rgba(255,187,0,1);color:white;"></th>
            <th id="totalDiferencialBancario" style="background:rgba(51,153,153,1);color:white;"></th>
            <th id="totalConcilicacionBancaria" style="background:rgba(51,153,153,1);color:white;"></th>
            <th id="totalesDiferencialBrightstarMovistar" style="background:rgba(255,153,51,1);color:white;"></th>
            <th id="totalesDiferencialBrightstarClaro" style="background:rgba(255,153,51,1);color:white;"></th>
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
            <td id="totalVentas2"></td>
            <td id="totalDiferencialBancario" class="dif"></td>
            <td id="totalConcilicacionBancaria"></td> 
            <td id="totalesDiferencialBrightstarMovistar" class="dif"></td>
            <td id="totalesDiferencialBrightstarClaro" class="dif"></td>
            <td>N/A</td>
            <td id="totalesDiferencialCapturaSoles" class="dif"></td>
            <td id="totalesDiferencialCapturaDollar" class="dif"></td>
            <td id="totalAcumulado"></td>
            <td id="totalSobrante" class="dif"></td>
            <td id="totalSobranteAcum"></td>
        </tr>
    </tbody>
</table>
</div>
<?php
/*****************************************CICLO DE INGRESOS COMPLETO ACTIVAS******************************************************************/
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceCicloIngresosCompletoActivas',
    'dataProvider'=>$model->search($_POST,$mes),
    'filter'=>$model,
    'htmlOptions'=>array(
        'class'=>'grid-view balanceCicloIngresosCompleto oculta',
        'rel'=>'completa',
        'name'=>'vistaoculta',
        ),
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
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios))',
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
            'value'=>'$data->pARIDAD->Valor',
            'type'=>'text',
        ),
        array(
            'name'=>'CaptSoles',
            'value'=>'$data->TraficoCapturaDollar*$data->pARIDAD->Valor',
            'type'=>'text',
        ),
        array(
            'name'=>'DifSoles',
            'value'=>'($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        array(
            'name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*$data->pARIDAD->Valor)/$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        array('name'=>'Acumulado',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array('name'=>'Sobrante',
            'value'=>'Balance::sobrante($data->Fecha,$data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array('name'=>'SobranteAcum',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
    ),
));

/*********************************************************************************************************************************************/
/*****************************************CICLO DE INGRESOS COMPLETO INACTIVAS****************************************************************/
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
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios))',
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
            'value'=>'$data->pARIDAD->Valor',
            'type'=>'text',
        ),
        array(
            'name'=>'CaptSoles',
            'value'=>'$data->TraficoCapturaDollar*$data->pARIDAD->Valor',
            'type'=>'text',
        ),
        array(
            'name'=>'DifSoles',
            'value'=>'($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        array(
            'name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*$data->pARIDAD->Valor)/$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
            ),
        ),
        array('name'=>'Acumulado',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array('name'=>'Sobrante',
            'value'=>'Balance::sobrante($data->Fecha,$data->CABINA_Id,"inactivas")',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array('name'=>'SobranteAcum',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
    ),
));
/*********************************************************************************************************************************************/
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>
</div>
<!--</div>-->
