<?php
/* @var $this RecargasController */
/* @var $model Recargas */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recargas-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'FechaHora'); ?>
		<?php echo $form->textField($model,'FechaHora'); ?>
		<?php echo $form->error($model,'FechaHora'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'MontoRecarga'); ?>
		<?php echo $form->textField($model,'MontoRecarga',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'MontoRecarga'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'BALANCE_Id'); ?>
            <label for="Recargas_BALANCE_Id" class="required">Cabina <span class="required">*</span></label>
		<?php echo $form->dropDownList($model,'BALANCE_Id',  Cabina::getListCabina(),array('empty'=>'Seleccionar..')); ?>
		<?php echo $form->error($model,'BALANCE_Id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'PABRIGHTSTAR_Id'); ?>
            <label for="Recargas_PABRIGHTSTAR_Id" class="required">Compañia <span class="required">*</span></label>
		<?php echo $form->dropDownList($model,'PABRIGHTSTAR_Id',Compania::getListCompania(),array('empty'=>'Seleccionar..'));?>
		<?php echo $form->error($model,'PABRIGHTSTAR_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Recargar' : 'Recargar',array('confirm'=> SiteController::mensajesConfirm(7))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->