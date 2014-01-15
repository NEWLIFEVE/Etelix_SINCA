<?php
/* @var $this BalanceController */
/* @var $data Balance */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaldoApMov')); ?>:</b>
	<?php echo CHtml::encode($data->SaldoApMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaldoApClaro')); ?>:</b>
	<?php echo CHtml::encode($data->SaldoApClaro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FijoLocal')); ?>:</b>
	<?php echo CHtml::encode($data->FijoLocal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FijoProvincia')); ?>:</b>
	<?php echo CHtml::encode($data->FijoProvincia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FijoLima')); ?>:</b>
	<?php echo CHtml::encode($data->FijoLima); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Rural')); ?>:</b>
	<?php echo CHtml::encode($data->Rural); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Celular')); ?>:</b>
	<?php echo CHtml::encode($data->Celular); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LDI')); ?>:</b>
	<?php echo CHtml::encode($data->LDI); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RecargaCelularMov')); ?>:</b>
	<?php echo CHtml::encode($data->RecargaCelularMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RecargaFonoYaMov')); ?>:</b>
	<?php echo CHtml::encode($data->RecargaFonoYaMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RecargaCelularClaro')); ?>:</b>
	<?php echo CHtml::encode($data->RecargaCelularClaro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RecargaFonoClaro')); ?>:</b>
	<?php echo CHtml::encode($data->RecargaFonoClaro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OtrosServicios')); ?>:</b>
	<?php echo CHtml::encode($data->OtrosServicios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MontoDeposito')); ?>:</b>
	<?php echo CHtml::encode($data->MontoDeposito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NumRefDeposito')); ?>:</b>
	<?php echo CHtml::encode($data->NumRefDeposito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MontoBanco')); ?>:</b>
	<?php echo CHtml::encode($data->MontoBanco); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ConciliacionBancaria')); ?>:</b>
	<?php echo CHtml::encode($data->ConciliacionBancaria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaIngresoLlamadas')); ?>:</b>
	<?php echo CHtml::encode($data->FechaIngresoLlamadas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FechaIngresoDeposito')); ?>:</b>
	<?php echo CHtml::encode($data->FechaIngresoDeposito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NombreCabina')); ?>:</b>
	<?php echo CHtml::encode($data->cabina->Nombre); ?>
	<br />
         
        <b><?php echo CHtml::encode($data->getAttributeLabel('Nombre Cabina')); ?>:</b>
	<?php echo CHtml::encode($data->cabina->Nombre); ?>
	<br />

	 */?>

</div>