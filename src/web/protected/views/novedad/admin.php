<?php
/* @var $this NovedadController */
/* @var $model Novedad */


$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = NovedadController::controlAcceso($tipoUsuario);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#novedad-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>

<h1>
    <span class="enviar">
        Administrar Fallas
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'novedad-grid',
    'htmlOptions'=>array(
      'rel'=>'total',
      ),
    'dataProvider' => $model->searchEs('admin'),
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'filter' => $model,
    'columns' => array(
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
        //'users_id',
        //'TIPONOVEDAD_Id',
        array(
            'name' => 'Fecha',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'Fecha',
                'language' => 'ja',
                'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
                'htmlOptions' => array(
                    'id' => 'datepicker_for_Fecha',
                    'size' => '25',
                ),
                'defaultOptions' => array(// (#3)
                    'showOn' => 'focus',
                    'dateFormat' => 'yy-mm-dd',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showButtonPanel' => true,
                )
                    ), true),
            'htmlOptions' => array(
                'style' => 'text-align: center;',
                'id'=>'fecha',
            ),
        ),
        array(
            'name' => 'Hora',
            'value' => '$data->Hora',
            'type' => 'text',
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'name' => 'TIPONOVEDAD_Id',
            'value' => '$data->tIPONOVEDAD->Nombre',
            'type' => 'text',
            'filter' => Tiponovedad::getListNombre(),
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'name' => 'users_id',
            'value' => '$data->users->username',
            'type' => 'text',
            'filter' => User::getListNombre(),
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'name' => 'Descripcion',
            'value' => '$data->Descripcion',
            'type' => 'text',
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'name' => 'Num',
            'value' => '$data->Num',
            'type' => 'text',
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'name' => 'Puesto',
            'value' => 'NovedadLocutorio::getLocutorioRow($data->Id)',
            'type' => 'text',
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'header'=>'Detalle',
            'class' => 'CButtonColumn',
            'buttons' => Utility::verParcial(1),
        ),
    ),
));



Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>