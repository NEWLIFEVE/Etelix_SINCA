<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Id'); ?>
		<?php echo $form->textField($model,'Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fecha'); ?>
		<?php echo $form->textField($model,'Fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SaldoApMov'); ?>
		<?php echo $form->textField($model,'SaldoApMov',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SaldoApClaro'); ?>
		<?php echo $form->textField($model,'SaldoApClaro',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FijoLocal'); ?>
		<?php echo $form->textField($model,'FijoLocal',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FijoProvincia'); ?>
		<?php echo $form->textField($model,'FijoProvincia',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FijoLima'); ?>
		<?php echo $form->textField($model,'FijoLima',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Rural'); ?>
		<?php echo $form->textField($model,'Rural',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Celular'); ?>
		<?php echo $form->textField($model,'Celular',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LDI'); ?>
		<?php echo $form->textField($model,'LDI',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RecargaCelularMov'); ?>
		<?php echo $form->textField($model,'RecargaCelularMov',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RecargaFonoYaMov'); ?>
		<?php echo $form->textField($model,'RecargaFonoYaMov',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RecargaCelularClaro'); ?>
		<?php echo $form->textField($model,'RecargaCelularClaro',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RecargaFonoClaro'); ?>
		<?php echo $form->textField($model,'RecargaFonoClaro',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'OtrosServicios'); ?>
		<?php echo $form->textField($model,'OtrosServicios',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MontoDeposito'); ?>
		<?php echo $form->textField($model,'MontoDeposito',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NumRefDeposito'); ?>
		<?php echo $form->textField($model,'NumRefDeposito',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MontoBanco'); ?>
		<?php echo $form->textField($model,'MontoBanco',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ConciliacionBancaria'); ?>
		<?php echo $form->textField($model,'ConciliacionBancaria',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FechaIngresoLlamadas'); ?>
		<?php echo $form->textField($model,'FechaIngresoLlamadas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FechaIngresoDeposito'); ?>
		<?php echo $form->textField($model,'FechaIngresoDeposito'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CABINA_Id'); ?>
		<?php echo $form->textField($model,'CABINA_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->