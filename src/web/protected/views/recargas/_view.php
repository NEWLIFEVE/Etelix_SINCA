<?php
/* @var $this RecargasController */
/* @var $data Recargas */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaHora')); ?>:</b>
	<?php echo CHtml::encode($data->FechaHora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MontoRecarga')); ?>:</b>
	<?php echo CHtml::encode($data->MontoRecarga); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BALANCE_Id')); ?>:</b>
	<?php echo CHtml::encode($data->BALANCE_Id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PABRIGHTSTAR_Id')); ?>:</b>
	<?php echo CHtml::encode($data->PABRIGHTSTAR_Id); ?>
	<br />


</div>