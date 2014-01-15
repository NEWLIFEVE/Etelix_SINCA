<?php
/* @var $this PabrightstarController */
/* @var $data Pabrightstar */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Compania')); ?>:</b>
	<?php echo CHtml::encode($data->Compania); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaldoAperturaPA')); ?>:</b>
	<?php echo CHtml::encode($data->SaldoAperturaPA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TransferenciaPA')); ?>:</b>
	<?php echo CHtml::encode($data->TransferenciaPA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ComisionPA')); ?>:</b>
	<?php echo CHtml::encode($data->ComisionPA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaldoCierrePA')); ?>:</b>
	<?php echo CHtml::encode($data->SaldoCierrePA); ?>
	<br />


</div>