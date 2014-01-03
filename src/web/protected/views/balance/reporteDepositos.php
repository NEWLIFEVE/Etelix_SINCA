<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        Reporte de Depositos Bancarios
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/sms-icon.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/info-icon.png' class='printButton' />
        <button id="cambio">Inactivas</button>
        <div>
            <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/reportecaptura') ?>">
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
    </span>
</h1>

<?php
echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none'));
echo CHtml::textField('vista', 'reporteDepositos', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte de Depositos Bancarios Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->
<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Depositos" method="post" target="_blank" id="FormularioExportacion">
<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<!--<p>Imprimir <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/sms-icon.png" class="botonImprimir" /></p>-->
<p>
<?php
$_POST['vista']='Depositos';
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteDepositos',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteDepositos',
        'rel'=>'total',
        'name'=>'vista',
        ),
    'dataProvider'=>$model->search($_POST),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'Fecha',
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
            true),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'fecha',
                ),
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                ),
            ),
        array(
            'name'=>'TotalVentas',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'MontoDeposito',
            'htmlOptions'=>array(
                'id'=>'montoDeposito',
                ),
            ),
        'NumRefDeposito',
        array(
            'name'=>'MontoBanco',
            'htmlOptions'=>array(
                'id'=>'montoBanco',
                ),
            ),
        array(
            'name'=>'DiferencialBancario',
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBancario'
                ),
            ),
        array(
            'name'=>'ConciliacionBancaria',
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-$data->MontoDeposito)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'concilicacionBancaria'
                ),
            ),
        ),
    )
);
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteDepositosOculta',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteDepositos oculta',
        'rel'=>'total',
        'name'=>'oculta',
        ),
    'dataProvider'=>$model->disable(),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'Fecha',
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
            true),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'fecha',
                ),
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                ),
            ),
        array(
            'name'=>'TotalVentas',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'MontoDeposito',
            'htmlOptions'=>array(
                'id'=>'montoDeposito',
                ),
            ),
        'NumRefDeposito',
        array(
            'name'=>'MontoBanco',
            'htmlOptions'=>array(
                'id'=>'montoBanco',
                ),
            ),
        array(
            'name'=>'DiferencialBancario',
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialBancario'
                ),
            ),
        array(
            'name'=>'ConciliacionBancaria',
            'value'=>'Yii::app()->format->formatDecimal($data->MontoBanco-$data->MontoDeposito)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'concilicacionBancaria'
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
?>
<div id="totales" class="grid-view">
<table class="items" id="depositos">
    <thead>
        <tr>
            <th id="totalFecha"style="background:rgba(51,153,153,1); color:white;">Fecha</th>
            <th id="todas"style="background:rgba(51,153,153,1); color:white;">Cabinas</th>
            <th id="totalVentas2" style="background:rgba(51,153,153,1); color:white;"></th>
            <th id="totalMontoDeposito" style="background:rgba(51,153,153,1); color:white;"></th>
            <th style="background:rgba(51,153,153,1); color:white;">Num de Ref:</th>
            <th id="balanceTotalesDepositos3" style="background:rgba(51,153,153,1); color:white;"></th>
            <th id="totalDiferencialBancario" style="background:rgba(51,153,153,1); color:white;"></th>
            <th id="totalConcilicacionBancaria" style="background:rgba(51,153,153,1); color:white;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id="totalFecha"></td>
            <td id="todas"> Todas </td>
            <td id="totalVentas2"></td>
            <td id="totalMontoDeposito"></td>
            <td id="nunref"> N/A </td>
            <td id="balanceTotalesDepositos3"></td>
            <td id="totalDiferencialBancario" class="dif"></td>
            <td id="totalConcilicacionBancaria" class="dif"></td>
        </tr>
    </tbody>
</table>
</div>