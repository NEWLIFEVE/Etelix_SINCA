<?php
/* @var $this LogController */
/* @var $data Log */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Hora')); ?>:</b>
	<?php echo CHtml::encode($data->Hora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaEsp')); ?>:</b>
	<?php echo CHtml::encode($data->FechaEsp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ACCIONLOG_Id')); ?>:</b>
	<?php echo CHtml::encode($data->aCCIONLOG->Nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('USERS_Id')); ?>:</b>
	<?php echo CHtml::encode($data->uSERS->username); ?>
	<br />


</div>