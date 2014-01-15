<?php
/* @var $this ParidadController */
/* @var $data Paridad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->FechaIni); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valor')); ?>:</b>
	<?php echo CHtml::encode($data->Valor); ?>
	<br />


</div>