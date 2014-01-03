<?php
/* @var $this PabrightstarController */
/* @var $model Pabrightstar */
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
		<?php echo $form->label($model,'Compania'); ?>
		<?php echo $form->textField($model,'Compania'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SaldoAperturaPA'); ?>
		<?php echo $form->textField($model,'SaldoAperturaPA',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TransferenciaPA'); ?>
		<?php echo $form->textField($model,'TransferenciaPA',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ComisionPA'); ?>
		<?php echo $form->textField($model,'ComisionPA',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SaldoCierrePA'); ?>
		<?php echo $form->textField($model,'SaldoCierrePA',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->