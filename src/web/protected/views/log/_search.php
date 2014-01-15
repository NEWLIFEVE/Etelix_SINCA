<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="200" border="1">
  <tr>
    <td><div class="row">
		<?php echo $form->label($model,'Id'); ?>
		<?php echo $form->textField($model,'Id'); ?>
	</div></td>
    <td>	<div class="row">
		<?php echo $form->label($model,'Fecha'); ?>
		<?php echo $form->textField($model,'Fecha'); ?>
	</div></td>
  </tr>
  <tr>
    <td><div class="row">
		<?php echo $form->label($model,'Hora'); ?>
		<?php echo $form->textField($model,'Hora'); ?>
	</div></td>
    <td><div class="row">
		<?php echo $form->label($model,'FechaEsp'); ?>
		<?php echo $form->textField($model,'FechaEsp'); ?>
	</div></td>
  </tr>
  <tr>
    <td>	<div class="row">
		<?php echo $form->label($model,'ACCIONLOG_Id'); ?>
		<?php echo $form->textField($model,'ACCIONLOG_Id'); ?>
	</div></td>
    <td><div class="row">
		<?php echo $form->label($model,'USERS_Id'); ?>
		<?php echo $form->textField($model,'USERS_Id'); ?>
	</div></td>
  </tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->