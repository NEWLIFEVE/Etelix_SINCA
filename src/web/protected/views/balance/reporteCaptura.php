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
<div id="fecha" style="display: none;"><?php echo date('Ym',strtotime($mes));?></div>
<?php
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'balanceReporteCaptura',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteCaptura',
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

        array(

            'name'=>'MinutosCaptura',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'minutos'
                )
            ),
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'Yii::app()->format->formatDecimal($data->TraficoCapturaDollar)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'traficoCapturaDollar',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Yii::app()->format->formatDecimal($data->pARIDAD->Valor)',
            'type'=>'text',
            ),
        array(
            'name'=>'CaptSoles',
            'value'=>'Yii::app()->format->formatDecimal($data->TraficoCapturaDollar*$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'traficoCapturaSoles',
                ),
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*$data->pARIDAD->Valor))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
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
                'style'=>'text-align: center;',
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
                ),
            ),
                        array(
            'name'=>'MinutosCaptura',
            'value'=>'$data->MinutosCaptura',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                )
            ),
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'Yii::app()->format->formatDecimal($data->TraficoCapturaDollar)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'id'=>'traficoCapturaDollar',
                ),
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Yii::app()->format->formatDecimal($data->pARIDAD->Valor)',
            'type'=>'text',
            ),
        array(
            'name'=>'CaptSoles',
            'value'=>'Yii::app()->format->formatDecimal($data->TraficoCapturaDollar*$data->pARIDAD->Valor)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'traficoCapturaSoles',
                ),
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Yii::app()->format->formatDecimal(($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*$data->pARIDAD->Valor))',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
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
                'style'=>'text-align: center;',
                'class'=>'dif',
                'name'=>'dif',
                'id'=>'diferencialCapturaDollar',
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
<table class="items">
    <thead>
        <tr>
            <th style="background:rgba(204,153,204,1); color:white;">Fecha</th>
            <th style="background:rgba(204,153,204,1); color:white;">Cabinas</th>
            <th id="totalMinutos" style="background:rgba(204,153,204,1); color:white;"></th>
            <th id="balanceTotalesCaptura1" style="background:rgba(204,153,204,1); color:white;"></th>
            <th style="background:rgba(204,153,204,1); color:white;">Paridad Cambiaria:</th>
            <th id="balanceTotalesCaptura2" style="background:rgba(204,153,204,1); color:white;"></th>
            <th id="totalesDiferencialCapturaSoles" style="background:rgba(204,153,204,1); color:white;"></th>
            <th id="totalesDiferencialCapturaDollar" style="background:rgba(204,153,204,1); color:white;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td id="totalFecha"></td>
            <td id="todas">Todas</td>
            <td id="totalMinutos"></td>
            <td id="balanceTotalesCaptura1"></td>
            <td>N/A</td>
            <td id="balanceTotalesCaptura2"></td>
            <td id="totalesDiferencialCapturaSoles" class="dif"></td>
            <td id="totalesDiferencialCapturaDollar" class="dif"></td>
        </tr>
    </tbody>
</table>
</div>
