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

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'balance-form',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
	'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'beforeValidate'=>"js:function(form) {
            confirm('".SiteController::mensajesConfirm(1)."')
            return true;
        }",
        )
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Fecha'); ?>
<!--                <p><input type="text" id="Fecha" size="30" /></p>-->
		<?php //echo $form->textField($model,'Fecha'); ?>
                <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', 
                    array(
                    'language' => 'es', 
                    'model' => $model,
                    'attribute'=>'Fecha', 'options' => array(
                    'changeMonth' => 'true',//para poder cambiar mes
                    'changeYear' => 'true',//para poder cambiar aÃ±o
                    'showButtonPanel' => 'false', 
                    'constrainInput' => 'false',
                    'showAnim' => 'show',
                    'minDate'=>'-30D', //fecha minima
                    'maxDate'=> "-0D", //fecha maxima
                     ),
                        'htmlOptions'=>array('readonly'=>'readonly'),
                )); 
                      echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                ?>
		<?php echo $form->error($model,'Fecha',array('readonly'=>'readonly')); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'CABINA_Id'); ?>
		<?php echo $form->dropDownList($model, 'CABINA_Id', Cabina::getListCabina(),array('empty'=>'Seleccionar..'));
                //drop($model,'CABINA_Id',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'CABINA_Id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'TraficoCapturaDollar'); ?>
		<?php echo $form->textField($model,'TraficoCapturaDollar',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'TraficoCapturaDollar'); ?>
	</div>


	<div class="row buttons">
				<?php //echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Save',array('confirm'=> SiteController::mensajesConfirm(1))); ?>
            <?php echo CHtml::submitButton('Declarar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->