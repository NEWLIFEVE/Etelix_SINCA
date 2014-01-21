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
        	<div  class="row" >
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php //echo $form->textField($model,'Fecha'); ?>
                            <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', 
                    array(
                    'language' => 'es', 
                    'model' => $model,
                    'attribute'=>'Fecha', 'options' => array(
                    'changeMonth' => 'true',//para poder cambiar mes
                    'changeYear' => 'true',//para poder cambiar año
                    'showButtonPanel' => 'false', 
                    'constrainInput' => 'false',
                    'showAnim' => 'show',
//                    'minDate'=>'-7D', //fecha minima
                    'maxDate'=> "-0D", //fecha maxima
                     ),
                        'htmlOptions'=>array('readonly'=>'readonly'),
                )); 
                    echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                ?>
		<?php echo $form->error($model,'Fecha',array('readonly'=>'readonly')); ?>
	</div>
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