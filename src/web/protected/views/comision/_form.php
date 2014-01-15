<?php
/* @var $this ComisionController */
/* @var $model Comision */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comision-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
                    <?php echo $form->labelEx($model,'Fecha');  ?>
                    <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', 
                    array(
                        'language'=>'es',
                        'model'=>$model,
                        'attribute'=>'Fecha',
                        'options'=>array(
                            'changeMonth'=>'true',//para poder cambiar mes
                            'changeYear'=>'true',//para poder cambiar año
                            'showButtonPanel'=>'false',
                            'constrainInput'=>'false',
                            'showAnim'=>'show',
                            'minDate'=>'-7D', //fecha minima
                            'maxDate'=>"-0D", //fecha maxima 'readonly'=>'readonly'
                            ),
                        'htmlOptions'=>array('readonly'=>'readonly'),
                        )
                    );
                    echo CHtml::label('', 'diaSemana',array(
                        'id'=>'diaSemana',
                        'style'=>'color:forestgreen'
                        )
                    );
                    ?>
                    <?php echo $form->error($model,'Fecha',array('readonly'=>'readonly')); ?>
                </div>

	<div class="row">
		<?php echo $form->labelEx($model,'Valor'); ?>
		<?php echo $form->textField($model,'Valor',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'Valor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'COMPANIA_Id'); ?>
		<?php echo $form->dropDownList($model, 'COMPANIA_Id', Compania::getListCompania(),array('empty'=>'Seleccionar..'));?>
		<?php echo $form->error($model,'COMPANIA_Id'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Actualizar' : 'Actualizar',array('confirm'=> SiteController::mensajesConfirm(6))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->