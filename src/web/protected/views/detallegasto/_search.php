<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */
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
		<?php echo $form->label($model,'Monto'); ?>
		<?php echo $form->textField($model,'Monto',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FechaMes'); ?>
		<?php echo $form->textField($model,'FechaMes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FechaVenc'); ?>
		<?php echo $form->textField($model,'FechaVenc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Descripcion'); ?>
		<?php echo $form->textField($model,'Descripcion',array('size'=>60,'maxlength'=>245)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

    <div class="row">
		<?php echo $form->label($model,'USERS_Id'); ?>
		<?php echo $form->textField($model,'USERS_Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TIPOGASTO_Id'); ?>
		<?php echo $form->textField($model,'TIPOGASTO_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->