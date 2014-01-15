<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'log-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php echo $form->textField($model,'Fecha'); ?>
		<?php echo $form->error($model,'Fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Hora'); ?>
		<?php echo $form->textField($model,'Hora'); ?>
		<?php echo $form->error($model,'Hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FechaEsp'); ?>
		<?php echo $form->textField($model,'FechaEsp'); ?>
		<?php echo $form->error($model,'FechaEsp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ACCIONLOG_Id'); ?>
		<?php echo $form->textField($model,'ACCIONLOG_Id'); ?>
		<?php echo $form->error($model,'ACCIONLOG_Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'USERS_Id'); ?>
		<?php echo $form->textField($model,'USERS_Id'); ?>
		<?php echo $form->error($model,'USERS_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('confirm'=>  SiteController::mensajesConfirm(4))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->