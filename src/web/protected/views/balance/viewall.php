<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	$model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'Listar Balance', 'url'=>array('index')),
//	//array('label'=>'Create Balance', 'url'=>array('create')),
//	array('label'=>'Actualizar Balance', 'url'=>array('update', 'id'=>$model->Id)),
//	array('label'=>'Eliminar Balance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Administrar Balance', 'url'=>array('admin')),
//        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
//	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
//	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
//);
?>

<h1>Vista General del Balance #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
        
        //$model->SaldoApMov->afterRequiredLabel,
	'data'=>$model,
	'attributes'=>array(
		'Id',
                  array(
                    'name'=>'Cabina',
                    'value'=>$model->cABINA->Nombre,
                ),
		'Fecha',
		'SaldoApMov',
		'SaldoApClaro',
		'SaldoCierreMov',
		'SaldoCierreClaro',
		'FijoLocal',
		'FijoProvincia',
		'FijoLima',
		'Rural',
		'Celular',
		'LDI',
		'RecargaCelularMov',
		'RecargaFonoYaMov',
		'RecargaCelularClaro',
		'RecargaFonoClaro',
		'OtrosServicios',
		'MontoDepositoOp',
		'NumRefDeposito',
		'MontoBanco',
		'ConciliacionBancaria',
		'FechaIngresoLlamadas',
		'FechaIngresoDeposito',
                'TraficoCapturaDollar',
                'RecargaVentasMov',
                'RecargaVentasClaro',
            
		//'CABINA_Id',
            
            
	),
));

?>
