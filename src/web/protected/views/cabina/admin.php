<?php
/* @var $this CabinaController */
/* @var $model Cabina */

Yii::import('webroot.protected.controllers.BalanceController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);

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

<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>

<h1>
  <span class="enviar">
    Horarios Cabinas
  </span>
  <span id="botones">
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton'/>
  </span>
</h1>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cabina-grid',
        'htmlOptions'=>array(
            'rel'=>'total',
            'name'=>'vista',
         ),
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
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
                array(
                            'header' => 'Detalle',
                            'class'=>'CButtonColumn',
                            'buttons'=>array
                            (
                                'view' => array
                                (
                                    'visible'=>'false',
                                ),
                                'update' => array
                                (
                                    'label'=>'Actualizar Empleado',
                                    'url'=>'Yii::app()->createUrl("Cabina/UpdateHours", array("id"=>$data->Id))',
                                    'imageUrl'=>Yii::app()->request->baseUrl."/themes/mattskitchen/img/update.png",
                                ), 
                                'delete' => array
                                (
                                    'visible'=>'false',
                                ),
                            ),
                    ),
	),
)); ?>
