<?php
/* @var $this LogController */
/* @var $model Log */
?>
<?php

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Listar Log', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1>
    <span class="enviar">
        Administrar Logs
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<p>
Puede ingresar de manera opcional operadores de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al principio de cada busqueda para indicar como deber ser realizada la busqueda.
</p>
<?php //echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
    echo CHtml::beginForm(Yii::app()->createUrl('log/enviarEmail'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
    echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
    echo CHtml::textField('vista','admin',array('id'=>'vista','style'=>'display:none'));
    echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
    echo CHtml::textField('asunto','Reporte Administrar Logs Solicitado',array('id'=>'asunto','style'=>'display:none'));
    echo CHtml::endForm();
?>

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Administrar_Logs" method="post" target="_blank" id="FormularioExportacion">
   
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

<div class="enviarTabla">
<?php   
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'log-grid',
    'htmlOptions'=>array(
      'rel'=>'total',
      ),
    'dataProvider'=>$model->search(),
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
        //'Fecha',
          array(
                   'name' => 'Fecha',
                   'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                               'model'=>$model, 
                               'attribute'=>'Fecha', 
                               'language' => 'ja',
                               'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
                               'htmlOptions' => array(
                                                'id' => 'datepicker_for_Fecha',
                                                'size' => '10',
                                             ),
                               'defaultOptions' => array(  // (#3)
                                                   'showOn' => 'focus', 
                                                   'dateFormat' => 'yy-mm-dd',
                                                   'showOtherMonths' => true,
                                                   'selectOtherMonths' => true,
                                                   'changeMonth' => true,
                                                   'changeYear' => true,
                                                   'showButtonPanel' => true,
                                                   )
                                           ), 
                               true),
                   'htmlOptions'=>array(
                                  'style'=>'text-align: center;',
                                  ),
                   ),
        
       array(
        'name'=>'Hora',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          ),
        ),
        //'FechaEsp',
          array(
                   'name' => 'FechaEsp',
                   'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                               'model'=>$model, 
                               'attribute'=>'FechaEsp', 
                               'language' => 'ja',
                               'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
                               'htmlOptions' => array(
                                                'id' => 'datepicker_for_FechaEsp',
                                                'size' => '15',
                                             ),
                               'defaultOptions' => array(  // (#3)
                                                   'showOn' => 'focus', 
                                                   'dateFormat' => 'yy-mm-dd',
                                                   'showOtherMonths' => true,
                                                   'selectOtherMonths' => true,
                                                   'changeMonth' => true,
                                                   'changeYear' => true,
                                                   'showButtonPanel' => true,
                                                   )
                                           ), 
                               true),
                   'htmlOptions'=>array(
                                  'style'=>'text-align: center;',
                                  ),
                   ),
        array(
            'name'=>'ACCIONLOG_Id',
            'value'=>'$data->aCCIONLOG->Nombre',
            'type'=>'text',
            'filter'=>  Accionlog::getListAccionLog(),
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                ),
            ),
        array(
            'header'=>'Usuario',
            'name'=>'USERS_Id',
            'value'=>'$data->uSERS->username',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),
            'filter' => User::getListNombre(),
            ),
        array(
            'name'=>'Cabina',
            'value'=>'Cabina::getNombreCabina($data->uSERS->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width' => '120px',
                'class'=>'cabina'
                ),
            'filter'=> Cabina::getListCabina(),
            ),
        ),
    ));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
    $('#datepicker_for_FechaEsp').datepicker();
}
");

?>
</div>