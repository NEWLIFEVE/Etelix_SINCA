<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = BalanceController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        Reporte Libro de Ventas
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
echo CHtml::textField('vista', 'reporteLibroVentas', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte Libro de Ventas Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->
<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_LibroVentas" method="post" target="_blank" id="FormularioExportacion">
<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceLibroVentas',
    'htmlOptions'=>array(
        'class'=>'grid-view LibroVentas',
        'rel'=>'total',
        'name'=>'vista',
    ),
    'dataProvider'=>$model->search($_POST),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'Fecha',
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Trafico',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'trafico',
                ),
            ),
        array(
            'name'=>'RecargaMovistar',
            'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularMov+$data->RecargaFonoYaMov)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                ),
            ),
        array(
            'name'=>'RecargaClaro',
            'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularClaro+$data->RecargaFonoClaro)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                ),
            ),
        array(
            'name'=>'OtrosServicios',
            'htmlOptions'=>array(
                'id'=>'otrosServicios',
                ),
            ),
        array(
            'name'=>'Total',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'totalVentas',
                ),
            ),
        ),
    )
);
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceLibroVentasOculta',
    'htmlOptions'=>array(
        'class'=>'grid-view LibroVentas oculta',
        'rel'=>'total',
        'name'=>'oculta',
    ),
    'dataProvider'=>$model->disable(),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'Fecha',
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Trafico',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'trafico',
                ),
            ),
        array(
            'name'=>'RecargaMovistar',
            'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularMov+$data->RecargaFonoYaMov)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                ),
            ),
        array(
            'name'=>'RecargaClaro',
            'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularClaro+$data->RecargaFonoClaro)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                ),
            ),
        array(
            'name'=>'OtrosServicios',
            'htmlOptions'=>array(
                'id'=>'otrosServicios',
                ),
            ),
        array(
            'name'=>'Total',
            'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'totalVentas',
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
<table class="items" id="ventas">
    <thead>
        <tr>
            <th id="totalFechaLV" style="background:rgba(255,187,0,1); color:white;">Fecha</th>
            <th id="todasLV" style="background:rgba(255,187,0,1); color:white;">Cabina</th>
            <th id="totalTrafico" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalRecargaMov" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalRecargaClaro" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="balanceTotalesVentas4" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalVentas2" style="background:rgba(255,187,0,1); color:white;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id="totalFecha"></td>
            <td id="todas">Todas</td>
            <td id="totalTrafico"></td>
            <td id="totalRecargaMov"></td>
            <td id="totalRecargaClaro"></td>
            <td id="balanceTotalesVentas4"></td>
            <td id="totalVentas2"></td>
        </tr>
    </tbody>
</table>
</div>