<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetalleingresoController::controlAccesoBalance($tipoUsuario);

if(isset($fancybox)){
    $this->layout=$this->getLayoutFile('mainfancybox');
}

$mes=null;
$cabina=null;


    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        $mes=$_POST["formFecha"];
    }
    
    if(isset($_POST["formCabina"]) && $_POST["formCabina"] != "")
    {
        $cabina=$_POST["formCabina"];
    }
    
    
$año = date("Y", strtotime($mes));   

if(!isset($fancybox)){
?>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
    <span class="enviar">
        Reporte de Ventas Recargas FullCarga <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año : ""; ?>
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
        <button id="cambio">Inactivas</button>
        <div>
            <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/ReporteBrightstar') ?>">
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
}
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteBrighstar',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteBrighstar',
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
                'style'=>'text-align: center;width: 56px;',
                'id'=>'fecha',
                ),
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;width: 80px;'
                ),
            ),
        array(
            'name'=>'ServMov',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServMovEtelix", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                'style'=>'text-align: center;',
                ),
            ),
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
            'name'=>'ServClaro',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServClaroEtelix", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                'style'=>'text-align: center;',
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
            'name'=>'ServDirecTv',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServDirecTvEtelix", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServDirecTv',
                'style'=>'text-align: center;',
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
            'name'=>'ServNextel',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServNextelEtelix", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServNextel',
                'style'=>'text-align: center;',
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
        ),
    )
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteBrighstarOculta',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteBrighstar oculta',
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
                'style'=>'text-align: center;width: 56px;',
                'id'=>'fecha',
                ),
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;width: 80px;'
                ),
            ),
        array(
            'name'=>'ServMov',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServMov", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                'style'=>'text-align: center;',
                ),
            ),
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
            'name'=>'ServClaro',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServClaro", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                'style'=>'text-align: center;',
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
            'name'=>'ServDirecTv',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServDirecTv", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServDirecTv',
                'style'=>'text-align: center;',
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
            'name'=>'ServNextel',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServNextel", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServNextel',
                'style'=>'text-align: center;',
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
<table class="items">
    <thead>
        <tr>
            <th style="background:#ff9900; color:white;">Fecha</th>
            <th style="background:#ff9900; color:white;">Cabinas</th>
            <!--<th id="balanceTotalesBrightstar1" style="background:#ff9900; color:white;"></th>-->
            <th id="totalRecargaMov" style="background:#ff9900; color:white;">Servicios Movistar (S/.)</th>
            <th id="totalesDiferencialBrightstarMovistar" style="background:#ff9900; color:white;"></th>
            
            <th id="totalRecargaClaro" style="background:#ff9900; color:white;">Servicios Claro (S/.)</th>
            <th id="totalesDiferencialBrightstarClaro" style="background:#ff9900; color:white;"></th>
            
            <th id="totalServDirecTv" style="background:#ff9900; color:white;">Servicios DirecTv (S/.)</th>
            <th id="totalesDiferencialBrightstarDirecTv" style="background:#ff9900; color:white;">Diferencial DirecTv (S/.)</th>
            
            <th id="totalServNextel" style="background:#ff9900; color:white;">Servicios Nextel (S/.)</th>
            <th id="totalesDiferencialBrightstarNextel" style="background:#ff9900; color:white;">Diferencial Nextel (S/.)</th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id="totalFecha" style="width: 56px;"></td>
            <td id="todas" style="width: 80px; text-align: center;"> Todas </td>
            <!--<td id="balanceTotalesBrightstar1"></td>-->
            <td id="totalRecargaMov" class="dif" style="text-align: center;"></td>
            <td id="totalesDiferencialBrightstarMovistar" class="dif" style="text-align: center;"></td>
            
            <td id="totalRecargaClaro" class="dif" style="text-align: center;"></td>
            <td id="totalesDiferencialBrightstarClaro" class="dif" style="text-align: center;"></td>
            
            <td id="totalServDirecTv" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialBrightstarDirecTv" class="dif" style="text-align: center;"></td>
            
            <td id="totalServNextel" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialBrightstarNextel" class="dif" style="text-align: center;"></td>
            
            
        </tr>
    </tbody>
</table>
</div>