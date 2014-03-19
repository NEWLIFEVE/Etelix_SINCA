<?php
/* @var $this NovedadController */
/* @var $model Novedad */

$this->breadcrumbs = array(
    'Novedads' => array('index'),
    'Manage',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = NovedadController::controlAcceso($tipoUsuario);
/* $this->menu=array(
  array('label'=>'List Novedad', 'url'=>array('index')),
  array('label'=>'Create Novedad', 'url'=>array('create')),
  ); */

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
        Administrar Novedades/Fallas
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<?php
//echo CHtml::beginForm(Yii::app()->createUrl('novedad/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
//echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none'));
//echo CHtml::textField('vista', 'novedad/admin', array('id' => 'vista', 'style'=>'display:none'));
//echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
//echo CHtml::textField('asunto', 'Reporte Administrar Novedades Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
//echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->

<!--<form action="<?php // echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Administrar_Novedades" method="post" target="_blank" id="FormularioExportacion">

<p>Exportar a Excel  </p>
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

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
                    'size' => '15',
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
            'value' => '$data->Puesto',
            'type' => 'text',
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'header'=>'Detalle',
            'class' => 'CButtonColumn',
            'template' => Utility::ver(Yii::app()->getModule('user')->user()->tipo),
        ),
    ),
));



Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>