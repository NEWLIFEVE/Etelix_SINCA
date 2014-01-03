<?php
/* @var $this BancoController */
/* @var $data Banco */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaldoApBanco')); ?>:</b>
	<?php echo CHtml::encode($data->SaldoApBanco); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaldoCierreBanco')); ?>:</b>
	<?php echo CHtml::encode($data->SaldoCierreBanco); ?>
	<br />


</div>