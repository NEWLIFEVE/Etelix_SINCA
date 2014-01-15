<?php
/* @var $this CabinaController */
/* @var $model Cabina */

$this->breadcrumbs=array(
	'Cabinas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Listar Cabina', 'url'=>array('index')),
	array('label'=>'Crear Cabina', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cabina-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<head>
    
    <script>
        
        $(document).ready(function() {
            $('.items').dataTable();
        } );
    
    </script>
    
</head>
<h1>Administrar Cabinas</h1>

<p>
Puede ingresar de manera opcional operadores de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al principio de cada busqueda para indicar como deber ser realizada la busqueda.
</p>

<?php echo CHtml::link('Busquedas Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cabina-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Id',
		'Nombre',
		'Codigo',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
