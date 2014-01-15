<?php
/* @var $this BalanceController */
/* @var $model Balance */

Yii::import('webroot.protected.controllers.CabinaController');
$tipoUsuario = Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
//$this->breadcrumbs=array(
//	//'Update Monto'=>array('/balance/updateMonto'),
//	'Balances'=>array('index'),
//        'Manage', 
//        //'UpdateMonto', 
//        //$model->Id,
//);

$this->menu=array(
	array('label'=>'Listar Balance', 'url'=>array('index')),
	//array('label'=>'Create Balance', 'url'=>array('create')),
        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
);

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

<h1>Administrar Balances</h1>

<p>
Puede ingresar de manera opcional operadores de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al principio de cada busqueda para indicar como deber ser realizada la busqueda.
</p>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'balance-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        //'ajaxUpdate'=>true,
	'columns'=>array(
		//'Id',
		'Fecha',
		'SaldoApMov',
		'SaldoApClaro',
		'FijoLocal',
		'FijoProvincia',
                array(
                    'name'=>'CABINA_Id',
                    'value'=>'$data->cABINA->Nombre',
                    'type'=>'text',
                    //'filter'=>Cabina::getListCabina(),
                ),

		/*

		/*'TraficoCapturaDollar',

		'FijoLima',
		'Rural',
		'Celular',
		'LDI',
		'RecargaCelularMov',
		'RecargaFonoYaMov',
		'RecargaCelularClaro',
		'RecargaFonoClaro',
		'OtrosServicios',
		'MontoDeposito',
		'NumRefDeposito',
		'MontoBanco',
		'ConciliacionBancaria',
		'FechaIngresoLlamadas',
		'FechaIngresoDeposito',

		//'CABINA_Id',
                 array ('name'=>'CABINA_Id','value'=>'$data->cABINA->Nombre','type'=>'text',),

            

		'CABINA_Id',*/

		array(
			'class'=>'CButtonColumn',
		),
	),
));

?>
