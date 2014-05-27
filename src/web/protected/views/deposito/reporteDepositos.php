<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DepositoController::controlAcceso($tipoUsuario);

$mes=null;


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
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
    <span class="enviar">
        Reporte de Depositos Bancarios <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
        <button id="cambio">Inactivas</button>
        <div>
            <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/ReporteDepositos') ?>">
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
<div id="fecha" style="display: none;"><?php echo $mes != NULL ? date('Ym',strtotime($mes)): "";?></div>
<div id="cabina2" style="display: none;"><?php echo $cabina != NULL ? Cabina::getNombreCabina2($cabina) : "";?></div>
<?php
$_POST['vista']='Depositos';
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteDepositos',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteDepositos',
        'rel'=>'total',
        'name'=>'vista',
        ),
    'dataProvider'=>$model->search($_POST,$mes,$cabina),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        array(
        'name'=>'id',
        'value'=>'$data->id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'ids',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        array(
            'name'=>'FechaCorrespondiente',
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'FechaCorrespondiente',
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
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->FechaCorrespondiente, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'MontoDep',
            'value'=>'Deposito::valueNull($data->MontoDep)',
            'htmlOptions'=>array(
                'id'=>'montoDeposito',
                ),
            ),
        'NumRef',
        array(
            'name'=>'MontoBanco',
            'value'=>'Deposito::valueNull($data->MontoBanco)',
            'htmlOptions'=>array(
                'id'=>'montoBanco',
                ),
            ),
        array(
            'name'=>'DiferencialBancario',
            'value'=>'Deposito::valueNull(round(($data->MontoBanco-Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->FechaCorrespondiente, $data->CABINA_Id)),2))',
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
            'value'=>'Deposito::valueNull(round(($data->MontoBanco-$data->MontoDep),2))',
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
    'afterAjaxUpdate'=>'reinstallDatePicker2',
    'filter'=>$model,
    'columns'=>array(
        array(
        'name'=>'id',
        'value'=>'$data->id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'ids',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        array(
            'name'=>'FechaCorrespondiente',
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'FechaCorrespondiente',
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
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->FechaCorrespondiente, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'totalVentas',
                ),
            ),
        array(
            'name'=>'MontoDep',
            'value'=>'Deposito::valueNull($data->MontoDep)',
            'htmlOptions'=>array(
                'id'=>'montoDeposito',
                ),
            ),
        'NumRef',
        array(
            'name'=>'MontoBanco',
            'value'=>'Deposito::valueNull($data->MontoBanco)',
            'htmlOptions'=>array(
                'id'=>'montoBanco',
                ),
            ),
        array(
            'name'=>'DiferencialBancario',
            'value'=>'Deposito::valueNull(round(($data->MontoBanco-Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->FechaCorrespondiente, $data->CABINA_Id)),2))',
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
            'value'=>'Deposito::valueNull(round(($data->MontoBanco-$data->MontoDep),2))',
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
Yii::app()->clientScript->registerScript('re-install-date-picker2', "
function reinstallDatePicker2(id, data) {
    $('#datepicker_for_Fecha_oculta').datepicker();
    $('div[name=".'"oculta"'."]').css('display','block');     
    $('div[name=".'"vista"'."]').css('display','none'); 
}
");
?>
<div id="totales" class="grid-view">
<table class="items" id="depositos">
    <thead>
        <tr>
            <th id="totalFecha"style="background:#1967B2; color:white;">Fecha</th>
            <th id="todas"style="background:#1967B2; color:white;width: 90px;">Cabinas</th>
            <th id="totalVentas2" style="background:#1967B2; color:white;"></th>
            <th id="totalMontoDeposito" style="background:#1967B2; color:white;"></th>
            <th style="background:#1967B2; color:white;">Numero de Ref. Deposito</th>
            <th id="balanceTotalesDepositos3" style="background:#1967B2; color:white;"></th>
            <th id="totalDiferencialBancario" style="background:#1967B2; color:white;"></th>
            <th id="totalConcilicacionBancaria" style="background:#1967B2; color:white;"></th>
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