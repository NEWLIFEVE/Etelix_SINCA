<?php
/* @var $this ComparativosController */
/* @var $model Comparativos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comparativos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php echo $form->textField($model,'Fecha'); ?>
		<?php echo $form->error($model,'Fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'RecargaVentasMov'); ?>
		<?php echo $form->textField($model,'RecargaVentasMov',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'RecargaVentasMov'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'RecargaVentasClaro'); ?>
		<?php echo $form->textField($model,'RecargaVentasClaro',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'RecargaVentasClaro'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TraficoCapturaDollar'); ?>
		<?php echo $form->textField($model,'TraficoCapturaDollar',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'TraficoCapturaDollar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CABINA_Id'); ?>
		<?php echo $form->textField($model,'CABINA_Id'); ?>
		<?php echo $form->error($model,'CABINA_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->