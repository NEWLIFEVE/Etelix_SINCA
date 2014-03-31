
<?php

$this->breadcrumbs=array(
	'Cabinas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Cabina', 'url'=>array('index')),
	array('label'=>'Administrar Cabina', 'url'=>array('admin')),
);
?>

<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    <?php 

        echo 'Actualizar Horario - '.$model->Nombre;
        
    
    ?> 
  </span >
</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'updateHours-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son obligatorios.</p>
        
	<?php echo $form->errorSummary($model); ?>
        
        <table id="datosEmpleado">
            <tr>
                <td colspan="5">
                <br>    
                <h2>
                    <span class="enviar" style="position: relative;">Horario de la Cabina</span>
                </h2>    
                </td>
            </tr>
            <!-- Campo Horario de Lunes a Sabado -->
            <tr>
                
                <td>
                <div class="row">
                    <?php echo $form->labelEx($model,'Lunes a Sabado'); ?>
                    <?php echo $form->checkBox($model,'day_1'); ?>
                    <?php echo $form->error($model,'day_1'); ?>
                </div>
                </td>
                <!-- Campo Horario -->
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'Hora de Entrada'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model,'name'=>'HoraIni','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Entrada','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model,
                                'attribute' => 'HoraIni',
                                'options' => array(
                                    'starthour' => 1,
                                    'endhour' => 24,
                                    'showminutes' => TRUE,
                                    //'minutedivisions' => 12,
                                    'military' => false,
                                    'event' => 'focus',
                                    'layout' => 'horizontal'
                                    //'useBgiframe' => true ,//IE6
                                ),
                                'htmlOptions' => array('size' => 10, 'maxlength' => 10,'readonly'=>'readonly')
                            ));
//                            ?>  
                            <?php echo $form->error($model,'HoraIni'); ?>
                    </div>
                </td>
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'Hora de Salida'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_1,'name'=>'end_time_1','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Salida','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
//                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
//                                'model' => $model,
//                                'attribute' => 'HoraFin',
//                                'options' => array(
//                                    'starthour' => 1,
//                                    'endhour' => 24,
//                                    'showminutes' => TRUE,
//                                    //'minutedivisions' => 12,
//                                    'military' => false,
//                                    'event' => 'focus',
//                                    'layout' => 'horizontal'
//                                    //'useBgiframe' => true ,//IE6
//                                ),
//                                'htmlOptions' => array('size' => 10, 'maxlength' => 10,'readonly'=>'readonly')
//                            ));
                            ?>  
                            <?php echo $form->error($model,'HoraFin'); ?>
                    </div>
                </td>
            </tr>
            <!-- Campo Horario Domingos -->
            <tr>
                <td>
                <div class="row">
                    <?php echo $form->labelEx($model,'Domingo'); ?>
                    <?php echo $form->checkBox($model,'day_2'); ?>
                    <?php echo $form->error($model,'day_2'); ?>
                </div>
                </td>
                <!-- Campo Horario -->
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'Hora de Entrada'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model,'name'=>'start_time_3','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Entrada','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
//                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
//                                'model' => $model,
//                                'attribute' => 'HoraIniDom',
//                                'options' => array(
//                                    'starthour' => 1,
//                                    'endhour' => 24,
//                                    'showminutes' => TRUE,
//                                    //'minutedivisions' => 12,
//                                    'military' => false,
//                                    'event' => 'focus',
//                                    'layout' => 'horizontal'
//                                    //'useBgiframe' => true ,//IE6
//                                ),
//                                'htmlOptions' => array('size' => 10, 'maxlength' => 10,'readonly'=>'readonly')
//                            ));
                            ?>  
                            <?php echo $form->error($model,'HoraIniDom'); ?>
                    </div>
                </td>
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'Hora de Salida'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model,'name'=>'end_time_3','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Salida','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
//                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
//                                'model' => $model,
//                                'attribute' => 'HoraFinDom',
//                                'options' => array(
//                                    'starthour' => 1,
//                                    'endhour' => 24,
//                                    'showminutes' => TRUE,
//                                    //'minutedivisions' => 12,
//                                    'military' => false,
//                                    'event' => 'focus',
//                                    'layout' => 'horizontal'
//                                    //'useBgiframe' => true ,//IE6
//                                ),
//                                'htmlOptions' => array('size' => 10, 'maxlength' => 10,'readonly'=>'readonly')
//                            ));
                            ?>  
                            <?php echo $form->error($model,'HoraFinDom'); ?>
                    </div>
                </td>
            </tr>
        </table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->