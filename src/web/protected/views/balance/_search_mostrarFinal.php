<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
/* @file _search_mostrarFinal */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Fecha'); ?>
		<?php echo $form->textField($model,'Fecha'); ?>
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
		<?php echo $form->label($model,'CABINA_Id'); ?>
		<?php echo $form->textField($model,'CABINA_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->