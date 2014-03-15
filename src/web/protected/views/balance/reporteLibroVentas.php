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
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
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