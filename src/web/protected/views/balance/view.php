<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	$model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        Detalle de Balance # <?php echo $model->Id; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/sms-icon.png" class="botonCorreoDetail" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcelDetail" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/info-icon.png' class='printButtonDetail' />
    </span>
</h1>
<?php
    echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
    echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
    echo CHtml::textField('vista','view/'.$model->Id,array('id'=>'vista','style'=>'display:none'));
    echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
    echo CHtml::textField('asunto','Vista General del Balance # '.$model->Id.' Solicitado',array('id'=>'asunto','style'=>'display:none'));
    echo CHtml::endForm();
?>

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Detalle%20Balance" method="post" target="_blank" id="FormularioExportacion">
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<div id="detail" class="enviarTabla">
<?php
if(Yii::app()->getModule('user')->user()->CABINA_Id != '17')
{
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'Id',
            array(
                'name'=>'Cabina',
                'value'=>$model->cABINA->Nombre,
                ),
            'Fecha',
            array(
                'name'=>'SaldoApMov',
                'cssClass'=>'apertura',
                ),
            array(
                'name'=>'SaldoApClaro',
                'cssClass'=>'apertura',
                ),
            'SaldoCierreMov',
            'SaldoCierreClaro',
            'FijoLocal',
            'FijoProvincia',
            'FijoLima',
            'Rural',
            'Celular',
            'LDI',
            array(
                'name'=>'Total de llamadas',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI
                    ),
                'cssClass'=>'resaltado',
                ),
            'RecargaCelularMov',
            'RecargaFonoYaMov',
            'RecargaCelularClaro',
            'RecargaFonoClaro',
            array(
                'name'=>'Total en Recargas',
                'value' => Yii::app()->format->formatDecimal(
                    $model->RecargaCelularMov + $model->RecargaCelularClaro + $model->RecargaFonoYaMov + $model->RecargaFonoClaro
                    ),
                'cssClass'=>'resaltado',
                ),
            'OtrosServicios',
            array(
                'name'=>'Total a Depositar',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI + $model->RecargaCelularMov + $model->RecargaCelularClaro + $model->RecargaFonoYaMov + $model->RecargaFonoClaro + $model->OtrosServicios
                    ),
                'cssClass'=>'resaltado',
                ),
            'MontoDeposito',
            'NumRefDeposito',
            'Depositante',
            'FechaDep',
            'HoraDep',
            'TiempoCierre',
            ),
        )
    );
}
else if(Yii::app()->getModule('user')->user()->CABINA_Id == '17')
{
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'Id',
            array(
                'name'=>'Cabina',
                'value'=>$model->cABINA->Nombre,
                ),
            'Fecha',
            array(
                'name'=>'SaldoApMov',
                'htmlOptions'=>array(
                    'id'=>'apertura'
                    ),
                ),
            'SaldoCierreMov',
            'FijoLocal',
            'FijoProvincia',
            'FijoLima',
            'Rural',
            'Celular',
            'LDI',
            array(
                'name'=>'Total de llamadas',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI
                    ),
                'cssClass'=>'resaltado',
                ),
            'RecargaCelularMov',
            'RecargaFonoYaMov',
            array(
                'name'=>'Total en Recargas',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->RecargaCelularMov + $model->RecargaFonoYaMov
                    ),
                'cssClass'=>'resaltado',
                ),
            'OtrosServicios',
            array(
                'name'=>'Total de ventas',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI + $model->RecargaCelularMov + $model->RecargaFonoYaMov + $model->OtrosServicios
                    ),
                'cssClass'=>'resaltado',
                ),
            'MontoDepositoOp',
            'NumRefDeposito',
            'Depositante',
            'FechaDep',
            'HoraDep',
            'TiempoCierre',
            ),
        )
    );
}
?>
</div>