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
<h1>Horarios Cabinas</h1>


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
                'name'=>'Nombre',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;',
                  ),
                ),
                array(
                'name'=>'HoraIni',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;',
                  ),
                ),
                array(
                'name'=>'HoraFin',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;',
                  ),
                ),
                array(
                'name'=>'HoraIniDom',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;',
                  ),
                ),
                array(
                'name'=>'HoraFinDom',
                'htmlOptions'=>array(
                  'style'=>'text-align: center;',
                  ),
                ),
//                  array(
//        'header'=>'Detalle',
//        'class'=>'CButtonColumn',
//        'template'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
//        ),
	),
)); ?>
