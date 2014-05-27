<?php
/* @var $this BalanceController */
/* @var $model Balance */
$this->breadcrumbs=array(
	'Balances'=>array('index'),
        'id'=>$model->id,
);
Yii::import('webroot.protected.controllers.BancoController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#balance-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Verificar Depositos Bancarios</h1>


<?php //echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search_checkBanco',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
echo CHtml::beginForm('','post',array('name'=>'monto', 'id'=>'banco'));
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balance-grid',
    'dataProvider'=>$model->search('MontoBanco',$mes,$cabina),
    'columns'=>array(
            'Fecha',
    'Hora',
		'FechaCorrespondiente',
    array(
        'name'=>'CABINA_Id',
        'value'=>'$data->cABINA->Nombre',
        'type'=>'text',
        ),
    'MontoDep',
    'NumRef',

    array(
        'name'=>'MontoBanco',
        'type'=>'raw',
        'value'=>'CHtml::textField("MontoBanco$data->id",$data->MontoBanco,array("style"=>"width:50px;"))',
        'htmlOptions'=>array(
            "width"=>"50px"
            ),
        ),
    ),
    ) 
);?>
<div class="row buttons">
		<?php
echo CHTML::button('Actualizar',  array('submit' => Yii::app()->createUrl("balance/updateMonto")));
echo CHtml::endForm();


?>
	</div>

