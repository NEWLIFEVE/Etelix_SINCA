<?php
/* @var $this ComisionController */
/* @var $model Comision */

$this->breadcrumbs=array(
	'Comisions'=>array('index'),
	'Manage',
);

Yii::import('webroot.protected.controllers.PabrightstarController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Comision', 'url'=>array('index')),
//	array('label'=>'Create Comision', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#comision-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Comisiones P.A.</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comision-grid',
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
		'Valor',
		'COMPANIA_Id',
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); 
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>
