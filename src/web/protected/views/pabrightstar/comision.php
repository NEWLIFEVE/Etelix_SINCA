<?php
/*
* @var $this BalanceController
* @var $model Balance 
*/
Yii::import('webroot.protected.controllers.BalanceController');
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = PabrightstarController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        P.D.V. <?php echo BalanceController::getHeader($compania); ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
        <div>
            <form method="post" action="<?php Yii::app()->createAbsoluteUrl('pabrightstar/comision/'.$compania) ?>">
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
echo CHtml::textField('vista', '/pabrightstar/comision/'.$compania, array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'RETESO P.D.V '.$compania.' Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->
<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=RETESO_P.D.V._<?php echo $compania; ?>" method="post" target="_blank" id="FormularioExportacion">
<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'comision',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteBrighstar',
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
            'header'=>'Saldo Apertura '.BalanceController::getHeader($compania),
            'value'=>'Yii::app()->format->formatDecimal(Utility::NotNull(Balance::Saldo($data->CABINA_Id,"'.$compania.'",$data->Fecha)))',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'header'=>"Recarga ".BalanceController::getHeader($compania),
            'value'=>'Yii::app()->format->formatDecimal(Utility::NotNull(Recargas::getMontoRecarga($data->CABINA_Id,"'.$compania.'",$data->Fecha)))',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'recarga',
                )
            ),
        array(
            'header'=>'Venta '.BalanceController::getHeader($compania),
            'value'=>'Yii::app()->format->formatDecimal(Utility::NotNull(Balance::getUltimoTotalVenta($data->CABINA_Id,"'.$compania.'",$data->Fecha)))',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'venta',
                )
            ),
        array(
            'header'=>'Saldo Cierre '.BalanceController::getHeader($compania),
            'value'=>'Yii::app()->format->formatDecimal(Utility::NotNull(Balance::saldoCierre($data->CABINA_Id,"'.$compania.'",$data->Fecha)))',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                )
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
<div id="totales" class="grid-view ReporteBrighstar">
<table class="items" id="comision">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cabina</th>
            <th>VentaMaxima</th>
            <th id="recargas"></th>
            <th id="ventas"></th>
            <th>Comision (S/.)</th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id=""><?php
            echo strtoupper(Balance::fecha($_POST['formFecha']));
            ?></td>
            <td id=""><?php
            if($_POST['formCabina'])
            {
                echo Cabina::getNombreCabina($_POST['formCabina']);
            }
            else
            {
                echo "Todas";
            }
            ?></td>
            <td><?php
            echo Balance::VtaMaxCabina($compania,$_POST['formCabina'],$_POST['formFecha']);
            ?></td>
            <td id="recargas"></td>
            <td id="ventas"></td>
            <td><?php
            echo Balance::comisionCabina($compania,$_POST['formCabina'],$_POST['formFecha']);
            ?></td>
        </tr>
    </tbody>
</table>
</div>