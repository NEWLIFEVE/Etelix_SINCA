
<?php

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);
?>

<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    <?php 
    
    if($model->employee_id != null && $model->event_id != null){
        echo 'Actualizar Evento';
            if(Yii::app()->user->hasFlash('success')):
                echo '<div class="grabado_ok">';
                    echo Yii::app()->user->getFlash('success'); 
                echo '</div>';
            endif;        
    }else{
        echo 'Registrar Evento';
            if(Yii::app()->user->hasFlash('success')):
                echo '<div class="grabado_ok">';
                    echo Yii::app()->user->getFlash('success'); 
                echo '</div>';
            endif;
    }
    
    ?> 
  </span >
</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-event-EventoEmpleado-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'employee_id'); ?>
		<?php echo $form->dropDownList($model,'employee_id',CHtml::listData(Employee::model()->findAllBySql("SELECT id, CONCAT(name, ' ', lastname) as name FROM employee;"),'id','name'),array('empty'=>'Seleccionar..')); ?>
		<?php echo $form->error($model,'employee_id'); ?>
            
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'event_id'); ?>
		<?php echo $form->dropDownList($model,'event_id',CHtml::listData(Event::model()->findAllBySql("SELECT id, name FROM event;"),'id','name'),array('empty'=>'Seleccionar..')); ?>
		<?php echo $form->error($model,'event_id'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model, 'concurrency_date'); ?>
                <?php 
                                $this->widget('zii.widgets.jui.CJuiDatePicker', 
                                array(
                                'language' => 'es', 
                                'model' => $model,
                                'attribute'=>'concurrency_date', 'options' => array(
                                'changeMonth' => 'true',//para poder cambiar mes
                                'changeYear' => 'true',//para poder cambiar año
                                'showButtonPanel' => 'false', 
                                'constrainInput' => 'false',
                                'showAnim' => 'show',
                                //'minDate'=>'-30D', //fecha minima
                                //'maxDate'=> "+30D", //fecha maxima
                                 ),
                                    'htmlOptions'=>array('readonly'=>'readonly'),
                            )); 
                                echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                            ?>
                <?php echo $form->error($model, 'concurrency_date'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->