<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?>
<head>
    <script>
        function formatDate(dateValue) { 
            var fecha = dateValue.toString();
            return fecha[3]+fecha[4]+fecha[2]+fecha[0]+fecha[1]+fecha[5]+fecha[6]+fecha[7]+fecha[8]+fecha[9];
        }
        $(document).change( function(){
            var fecha = formatDate($('#Balance_Fecha').val());
            $("#diaSemana").text(["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"][new Date(fecha).getDay()]); 
        });
    </script>
</head>
<h4></h4>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'balance-form',
	'enableAjaxValidation'=>true,
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
                    'minDate'=>'-7D', //fecha minima
                    'maxDate'=> "-0D", //fecha maxima
                     ),
                        'htmlOptions'=>array('readonly'=>'readonly'),
                )); 
                    echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                ?>
		<?php echo $form->error($model,'Fecha',array('readonly'=>'readonly')); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'SaldoApMov'); ?>
		<?php echo $form->textField($model,'SaldoApMov',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'SaldoApMov'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SaldoApClaro'); ?>
		<?php echo $form->textField($model,'SaldoApClaro',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'SaldoApClaro'); ?>
	</div>
      
        
        
        <div class="row" style="display:none;">
		<?php echo $form->labelEx($model,'CABINA_Id'); ?>
		<?php echo $form->textField($model,'CABINA_Id'); ?>
		<?php echo $form->error($model,'CABINA_Id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Save',array('confirm'=> SiteController::mensajesConfirm(1))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->