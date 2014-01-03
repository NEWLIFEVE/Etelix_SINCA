<?php
/* @var $this DetallegastoController */
/* @var $data Detallegasto */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Monto')); ?>:</b>
	<?php echo CHtml::encode($data->Monto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaMes')); ?>:</b>
	<?php echo CHtml::encode($data->FechaMes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaVenc')); ?>:</b>
	<?php echo CHtml::encode($data->FechaVenc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('USERS_Id')); ?>:</b>
	<?php echo CHtml::encode($data->USERS_Id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('TIPOGASTO_Id')); ?>:</b>
	<?php echo CHtml::encode($data->TIPOGASTO_Id); ?>
	<br />

	*/ ?>

</div>