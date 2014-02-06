<?php
/* @var $this PabrightstarController */
/* @var $model Pabrightstar */

$this->breadcrumbs=array(
	'Pabrightstars'=>array('index'),
	'Manage',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Pabrightstar', 'url'=>array('index')),
//	array('label'=>'Create Pabrightstar', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pabrightstar-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button','style'=>'display:none')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<h1>
    <span class="enviar">
        Reporte P.A. Brightstar
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<?php
echo CHtml::beginForm(Yii::app()->createUrl('pabrightstar/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none'));
echo CHtml::textField('vista', 'admin', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte Portal Administrativo Brightstar Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->
<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_PA_Brightstar" method="post" target="_blank" id="FormularioExportacion">
<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'reportePaBrightstar',
        'htmlOptions'=>array(
            'class'=>'grid-view ReportePABrighstar',
            'rel'=>'total',
            'name'=>'vista',
        ),
	'dataProvider'=>$model->search(),
        'afterAjaxUpdate' => 'reinstallDatePicker',
	'filter'=>$model,
	'columns'=>array(
		//'Id',
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
		//'Compania',
                array(
                       'name'=>'Compania',
                       'value'=>'$data->compania->nombre',
                       'type'=>'text',
                       'filter'=>  Compania::getListCompania(),
                       'htmlOptions'=>array(
                                      'style'=>'text-align: center;',
                                      ),
                       ),
              array(
                'name'=>'SaldoAperturaPA',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;'
                  ),
                ),
              array(
                'name'=>'TransferenciaPA',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;'
                  ),
                ),
              array(
                'name'=>'ComisionPA',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;'
                  ),
                ),
		array(
                   'name'=>'RecargaPA',
                   'value'=>'Yii::app()->format->formatDecimal(
                             $data->TransferenciaPA+$data->ComisionPA
                             )',
                   'type'=>'text',
                   'htmlOptions'=>array(
                                  'style'=>'text-align: center;',
                                  ),
                   ),
		array(
                   'name'=>'SubtotalPA',
                   'value'=>'Yii::app()->format->formatDecimal(
                             $data->SaldoAperturaPA+$data->TransferenciaPA+$data->ComisionPA
                             )',
                   'type'=>'text',
                   'htmlOptions'=>array(
                                  'style'=>'text-align: center;',
                                  ),
                   ),
              array(
                'name'=>'SaldoCierrePA',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;'
                  ),
                ),
				
                array(
                   'header'=>'Detalle',
                   'class'=>'CButtonColumn',
                   'template'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
                    ),
	),
)); 
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>
