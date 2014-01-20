<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?><head>
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
    )
); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="200" border="1">
  <tr>
    <td>	<div class="row" >
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php // echo $form->textField($model,'Fecha'); ?>
                            <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', 
                    array(
                    'language' => 'es', 
                    'model' => $model,
                    'attribute'=>'Fecha',
                    'options' => array(
                    'changeMonth' => 'true',//para poder cambiar mes
                    'changeYear' => 'true',//para poder cambiar año
                    'showButtonPanel' => 'false', 
                    'constrainInput' => 'false',
                    'showAnim' => 'show',
                    'minDate'=>'-7D', //fecha minima
                    'maxDate'=> "-1D", //fecha maxima
                     ),
                    'htmlOptions'=>array('readonly'=>'readonly'),
                )); 
                    echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                ?>
		<?php echo $form->error($model,'Fecha',array('readonly'=>'readonly')); ?>
	</div></td>
    <td>	<div class="row" style="display:none;">
		<?php echo $form->labelEx($model,'FechaIngresoLlamadas'); ?>
		<?php echo $form->textField($model,'FechaIngresoLlamadas'); ?>
		<?php echo $form->error($model,'FechaIngresoLlamadas'); ?>
	</div></td>
  </tr>
</table>


        <h2>LLAMADAS</h2>
        <table width="200" border="1" >
  <tr>
    <td>	<div class="row">
		<?php echo $form->labelEx($model,'FijoLocal'); ?>
		<?php echo $form->textField($model,'FijoLocal',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'FijoLocal'); ?>
	</div></td>
    <td>	<div class="row">
		<?php echo $form->labelEx($model,'FijoProvincia'); ?>
		<?php echo $form->textField($model,'FijoProvincia',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'FijoProvincia'); ?>
	</div></td>
  </tr>
  <tr>
    <td>	<div class="row">
		<?php echo $form->labelEx($model,'FijoLima'); ?>
		<?php echo $form->textField($model,'FijoLima',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'FijoLima'); ?>
	</div></td>
    <td>	<div class="row">
		<?php echo $form->labelEx($model,'Rural'); ?>
		<?php echo $form->textField($model,'Rural',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'Rural'); ?>
	</div></td>
  </tr>
  <tr>
    <td>	<div class="row">
		<?php echo $form->labelEx($model,'Celular'); ?>
		<?php echo $form->textField($model,'Celular',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'Celular'); ?>
	</div></td>
    <td>	<div class="row">
		<?php echo $form->labelEx($model,'LDI'); ?>
		<?php echo $form->textField($model,'LDI',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'LDI'); ?>
	</div></td>
  </tr>
</table>

<?php // if (Yii::app()->getModule('user')->user()->CABINA_Id != '17'): ?>
        
<table width="200" border="1">
  <tr>
    <td><h2>MOVISTAR</h2></td>
    <td><h2>CLARO</h2></td>
  </tr>
  <tr>
    <td>  	<div class="row">
		<?php echo $form->labelEx($model,'RecargaCelularMov'); ?>
		<?php echo $form->textField($model,'RecargaCelularMov',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'RecargaCelularMov'); ?>
	</div></td>
    <td>   	<div class="row">
		<?php echo $form->labelEx($model,'RecargaCelularClaro'); ?>
		<?php echo $form->textField($model,'RecargaCelularClaro',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'RecargaCelularClaro'); ?>
	</div></td>
  </tr>
  <tr>
    <td><div class="row">
		<?php echo $form->labelEx($model,'RecargaFonoYaMov'); ?>
		<?php echo $form->textField($model,'RecargaFonoYaMov',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'RecargaFonoYaMov'); ?>
	</div></td>
    <td> 	<div class="row">
		<?php echo $form->labelEx($model,'RecargaFonoClaro'); ?>
		<?php echo $form->textField($model,'RecargaFonoClaro',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'RecargaFonoClaro'); ?>
	</div></td>
  </tr>
</table>
<?php // endif; ?>
        
<?php // if (Yii::app()->getModule('user')->user()->CABINA_Id == '17'): ?>
        
<!--<table width="200" border="1">
  <tr>
    <td><h2>BRIGHTSTAR</h2></td>
  </tr>
  <tr>
    <td>  	<div class="row">
		<?php // echo $form->labelEx($model,'RecargaCelularMov'); ?>
		<?php // echo $form->textField($model,'RecargaCelularMov',array('size'=>15,'maxlength'=>15)); ?>
		<?php // echo $form->error($model,'RecargaCelularMov'); ?>
	</div></td>
  </tr>
  <tr>
    <td><div class="row">
		<?php // echo $form->labelEx($model,'RecargaFonoYaMov'); ?>
		<?php // echo $form->textField($model,'RecargaFonoYaMov',array('size'=>15,'maxlength'=>15)); ?>
		<?php // echo $form->error($model,'RecargaFonoYaMov'); ?>
	</div></td>
  </tr>
</table>
        -->
<?php // endif; ?>
        
        <h2>MISCELANEOS</h2>
	<div class="row">
		<?php echo $form->labelEx($model,'OtrosServicios'); ?>
		<?php echo $form->textField($model,'OtrosServicios',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'OtrosServicios'); ?>
	</div>

	<div class="row" style="display:none;">
		<?php echo $form->labelEx($model,'CABINA_Id'); ?>
		<?php echo $form->textField($model,'CABINA_Id'); ?>
		<?php echo $form->error($model,'CABINA_Id'); ?>
	</div>

	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Save',array('confirm'=> SiteController::mensajesConfirm(1))); ?>
		<?php echo CHtml::submitButton('Declarar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --><!--comentario-->