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
        Reporte Libro de Ventas <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoNew" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelNew" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonNew' />
        <button id="cambio">Inactivas</button>
        <div>
            <form method="post" name="balance" action="<?php Yii::app()->createAbsoluteUrl('balance/ReporteLibroVentas') ?>">
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
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceLibroVentas',
    'htmlOptions'=>array(
        'class'=>'grid-view LibroVentas',
        'rel'=>'total',
        'name'=>'vista',
    ),
    'dataProvider'=>$model->search($_POST,$mes,$cabina),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
      /*Columnas Ocultas*/  
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
        'name'=>'CABINA_Id',
        'value'=>'$data->CABINA_Id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'cabinas',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        /*  Fin Cabinas Ocultas */
        array(
            'name'=>'Fecha',
            'header'=>'Fecha',
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
                'style'=>'text-align: center;',
                'id'=>'cabina',
                )
            ),
        array(
            'name'=>'Trafico',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","trafico", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'trafico',
                ),
            ),
        array(
            'name'=>'ServMov',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServMov", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                ),
            ),
        array(
            'name'=>'ServClaro',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServClaro", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                ),
            ),
        array(
            'name'=>'ServDirecTv',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServDirecTv", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServDirecTv',
                ),
            ),
        array(
            'name'=>'ServNextel',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServNextel", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServNextel',
                ),
            ),
        array(
            'name'=>'OtrosServicios',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","servicio", $data->Fecha, $data->CABINA_Id, 8)',
            'htmlOptions'=>array(
                'id'=>'otrosServicios',
                ),
            ),
        array(
            'name'=>'TotalVentas',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->Fecha, $data->CABINA_Id)',
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
    'afterAjaxUpdate'=>'reinstallDatePicker2',
    'filter'=>$model,
    'columns'=>array(
      /*Columnas Ocultas*/  
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
        'name'=>'CABINA_Id',
        'value'=>'$data->CABINA_Id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'cabinas',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        /*  Fin Cabinas Ocultas */
        array(
            'name'=>'Fecha',
            'header'=>'Fecha',
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
                'style'=>'text-align: center;',
                'id'=>'cabina',
                )
            ),
        array(
            'name'=>'Trafico',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","trafico", $data->FechaMes, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'trafico',
                ),
            ),
        array(
            'name'=>'ServMov',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServMov", $data->FechaMes, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                ),
            ),
        array(
            'name'=>'ServClaro',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServClaro", $data->FechaMes, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                ),
            ),
        array(
            'name'=>'ServDirecTv',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServDirecTv", $data->FechaMes, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServDirecTv',
                ),
            ),
        array(
            'name'=>'ServNextel',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServNextel", $data->FechaMes, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServNextel',
                ),
            ),
        array(
            'name'=>'OtrosServicios',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","servicio", $data->FechaMes, $data->CABINA_Id, 8)',
            'htmlOptions'=>array(
                'id'=>'otrosServicios',
                ),
            ),
        array(
            'name'=>'TotalVentas',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $data->FechaMes, $data->CABINA_Id)',
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
Yii::app()->clientScript->registerScript('re-install-date-picker2', "
function reinstallDatePicker2(id, data) {
    $('#datepicker_for_Fecha_oculta').datepicker();
    $('div[name=".'"oculta"'."]').css('display','block');     
    $('div[name=".'"vista"'."]').css('display','none'); 
}
");
?>
<div id="totales" class="grid-view">
<table class="items totals" id="ventas">
    <thead>
        <tr>
            <th id="totalFechaLV" style="background:rgba(255,187,0,1); color:white;">Fecha</th>
            <th id="todasLV" style="background:rgba(255,187,0,1); color:white;">Cabina</th>
            <th id="totalTrafico" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalRecargaMov" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalRecargaClaro" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalServDirecTv" style="background:rgba(255,187,0,1); color:white;"></th>
            <th id="totalServNextel" style="background:rgba(255,187,0,1); color:white;"></th>
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
            <td id="totalServDirecTv"></td>
            <td id="totalServNextel"></td>
            <td id="balanceTotalesVentas4"></td>
            <td id="totalVentas2"></td>
        </tr>
    </tbody>
</table>
</div>