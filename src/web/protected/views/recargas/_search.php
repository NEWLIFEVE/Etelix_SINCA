<?php
/* @var $this RecargasController */
/* @var $model Recargas */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FechaHora'); ?>
		<?php echo $form->textField($model,'FechaHora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MontoRecarga'); ?>
		<?php echo $form->textField($model,'MontoRecarga',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BALANCE_Id'); ?>
		<?php echo $form->textField($model,'BALANCE_Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PABRIGHTSTAR_Id'); ?>
		<?php echo $form->textField($model,'PABRIGHTSTAR_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->