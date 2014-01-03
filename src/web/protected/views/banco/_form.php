<?php
/* @var $this BancoController */
/* @var $model Banco */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'banco-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'SaldoApBanco'); ?>
		<?php echo $form->textField($model,'SaldoApBanco',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'SaldoApBanco'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CUENTA_Id'); ?>
        <?php echo CHtml::dropDownList('Banco[CUENTA_Id]', '', Cuenta::getListCuenta(), array('empty' => 'Seleccionar...')) ?>
		<!--<?php echo $form->textField($model,'CUENTA_Id',array('size'=>15,'maxlength'=>15)); ?>-->
		<?php echo $form->error($model,'CUENTA_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>