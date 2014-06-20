<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
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
        Reporte de Trafico Captura <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png" class="printButton" />
        <button id="cambio">Inactivas</button>
        <div>
            <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/ReporteCaptura') ?>">
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
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceReporteCaptura',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteCaptura',
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
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'Fecha',
                'language'=>'ja',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_Fecha',
                    'size'=>'15',
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
                ),true),
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

//        array(
//
//            'name'=>'MinutosCaptura',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center;',
//                'id'=>'minutos'
//                )
//            ),
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'Detalleingreso::TraficoCapturaDollar($data->Fecha,$data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'traficoCapturaDollar',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Paridad::getParidad($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                ),
            ),
        array(
            'name'=>'CaptSoles',
            'value'=>'round((Detalleingreso::TraficoCapturaDollar($data->Fecha,$data->CABINA_Id)*Paridad::getParidad($data->Fecha)),2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'traficoCapturaSoles',
                'style'=>'text-align: center;',
                ),
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,2)',
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
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,1)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
            ),
        ),
        ),
    )
);

$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceReporteCapturaOculta',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteCaptura oculta',
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
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'Fecha',
                'language'=>'ja',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_Fecha',
                    'size'=>'15',
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
                ),true),
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

//        array(
//
//            'name'=>'MinutosCaptura',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center;',
//                'id'=>'minutos'
//                )
//            ),
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'Detalleingreso::TraficoCapturaDollar($data->Fecha,$data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'traficoCapturaDollar',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Paridad::getParidad($data->Fecha)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                ),
            ),
        array(
            'name'=>'CaptSoles',
            'value'=>'round((Detalleingreso::TraficoCapturaDollar($data->Fecha,$data->CABINA_Id)*Paridad::getParidad($data->Fecha)),2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'traficoCapturaSoles',
                'style'=>'text-align: center;',
                ),
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,2)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
                ),
            ),
        array(
            'name'=>'DifDollar',
            'value'=>'CicloIngresoModelo::getDifCaptura($data->Fecha,$data->CABINA_Id,1)',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'background: rgba(204,153,204,1) !important;'),
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'',
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
            <th style="background:rgba(204,153,204,1); color:white;">Fecha</th>
            <th style="background:rgba(204,153,204,1); color:white;">Cabinas</th>
            <!--<th id="totalMinutos" style="background:rgba(204,153,204,1); color:white;"></th>-->
            <th id="balanceTotalesCaptura1" style="background:rgba(204,153,204,1); color:white;"></th>
            <th style="background:rgba(204,153,204,1); color:white;">Paridad Cambiaria (S/.|$)</th>
            <th id="balanceTotalesCaptura2" style="background:rgba(204,153,204,1); color:white;"></th>
            <th id="totalesDiferencialCapturaSoles" style="background:rgba(204,153,204,1); color:white;"></th>
            <th id="totalesDiferencialCapturaDollar" style="background:rgba(204,153,204,1); color:white;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id="totalFecha" style="text-align: center;width: 97px;"></td>
            <td id="todas" style="text-align: center;width: 103px;">Todas</td>
            <!--<td id="totalMinutos"></td>-->
            <td id="totaltraficoCapturaDollar" style="text-align: center;"></td>
            <td style="text-align: center;">N/A</td>
            <td id="totaltraficoCapturaSoles" style="text-align: center;width: 100px;"></td>
            <td id="totaldiferencialCapturaSoles" class="dif" style="text-align: center;"></td>
            <td id="totaldiferencialCapturaDollar" class="dif" style="text-align: center;"></td>
        </tr>
    </tbody>
</table>
</div>
