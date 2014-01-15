<?php
/* @var $this ComparativosController */
/* @var $data Comparativos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RecargaVentasMov')); ?>:</b>
	<?php echo CHtml::encode($data->RecargaVentasMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RecargaVentasClaro')); ?>:</b>
	<?php echo CHtml::encode($data->RecargaVentasClaro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TraficoCapturaDollar')); ?>:</b>
	<?php echo CHtml::encode($data->TraficoCapturaDollar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CABINA_Id')); ?>:</b>
	<?php echo CHtml::encode($data->CABINA_Id); ?>
	<br />


</div>