<?php
/* @var $this NovedadController */
/* @var $data Novedad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users_id')); ?>:</b>
	<?php echo CHtml::encode($data->users->username);//CHtml::encode($data->users_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TIPONOVEDAD_Id')); ?>:</b>
	<?php echo CHtml::encode($data->tIPONOVEDAD->Nombre);//CHtml::encode($data->TIPONOVEDAD_Id); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('Num')); ?>:</b>
	<?php echo CHtml::encode($data->tIPONOVEDAD->Nombre);//CHtml::encode($data->TIPONOVEDAD_Id); ?>
	<br />


</div>