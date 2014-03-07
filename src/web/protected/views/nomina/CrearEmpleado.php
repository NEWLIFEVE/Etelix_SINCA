<?php

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);
?>

<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    <?php 
    
    if($model->id != null){
        echo 'Actualizar Empleado';
            if(Yii::app()->user->hasFlash('success')):
                echo '<div class="grabado_ok">';
                    echo Yii::app()->user->getFlash('success'); 
                echo '</div>';
            endif;        
    }else{
        echo 'Crear Empleado';
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
	'id'=>'CrearEmpleado-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
        <!--
	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>
        -->
        
        <table id="datosEmpleado">
            <!-- Datos Personales del Empleado -->
            <tr id="DatosPersonales">
                <!-- Campo Codigo Empleado -->
                <!--
                <td>
                    
                    <div class="row">
                            <?php //echo $form->labelEx($model,'code_employee'); ?>
                            <?php //echo $form->textField($model,'code_employee'); ?>
                            <?php //echo $form->error($model,'code_employee'); ?>
                    </div>
                </td>
                -->
                <!-- Campo Nombre -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'name'); ?>
                            <?php echo $form->textField($model,'name'); ?>
                            <?php echo $form->error($model,'name'); ?>
                    </div>                    
                </td>
                <!-- Campo Apellido -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'lastname'); ?>
                            <?php echo $form->textField($model,'lastname'); ?>
                            <?php echo $form->error($model,'lastname'); ?>
                    </div>                    
                </td>
                <!-- Campo Numero de Identificacion -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'identification_number'); ?>
                            <?php echo $form->textField($model,'identification_number'); ?>
                            <?php echo $form->error($model,'identification_number'); ?>
                    </div>
                </td>
                <!-- Campo Sexo -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'gender'); ?>
                            <?php echo $form->dropDownList($model,'gender',array('1'=>'Femenino','2'=>'Masculino'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'gender'); ?>
                    </div>
                </td>
                <!-- Campo Estado Civil -->
                <td id="vista_marital_status_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'marital_status_id'); ?>
                            <?php echo $form->dropDownList($model,'marital_status_id',CHtml::listData(MaritalStatus::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'marital_status_id'); ?>
                        
                        <img id="marital_status_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                        
                    </div>
                </td>
                <td id="oculta_marital_status_id" style="display: none;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'marital_status_name'); ?>
                            <?php echo $form->textField($model,'marital_status_name'); ?>
                            <?php echo $form->error($model,'marital_status_name'); ?>
                        
                        <img id="marital_status_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: inline;" />
                        
                    </div>
                </td>
            </tr>
            <!-- Datos de Contacto del Empleado -->
            <tr id="DatosContacto">
                <!-- Campo Direccion -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'address'); ?>
                            <?php echo $form->textField($model,'address'); ?>
                            <?php echo $form->error($model,'address'); ?>
                    </div>
                </td>
                <!-- Campo Telefono -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'phone_number'); ?>
                            <?php echo $form->textField($model,'phone_number'); ?>
                            <?php echo $form->error($model,'phone_number'); ?>
                    </div>
                </td>
                <td></td>
                <td></td>
            </tr>
            <!-- Datos Profesionales del Empleado -->
            <tr id="DatosProfesionales">
                <!-- Campo Nivel Academico -->
                <td id="vista_academic_level_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'academic_level_id'); ?>
                            <?php echo $form->dropDownList($model,'academic_level_id',CHtml::listData(AcademicLevel::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'academic_level_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'academic_level_id'); ?>
                        
                        <img id="academic_level_id" title="Agregar Nuevo Nivel Academico" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                    </div>
                </td>
                <td id="oculta_academic_level_id" style="display: none;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'academic_level_name'); ?>
                            <?php echo $form->textField($model,'academic_level_name'); ?>
                            <?php echo $form->error($model,'academic_level_name'); ?>
                        
                        <img id="academic_level_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: inline;" />
                        
                    </div>
                </td>
                <!-- Campo Profesion -->
                <td id="vista_profession_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'profession_id'); ?>
                            <?php echo $form->dropDownList($model,'profession_id',CHtml::listData(Profession::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'profession_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'profession_id'); ?>
                        
                        <img id="profession_id" title="Agregar Nueva Profesion" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                    </div>
                </td>
                <td id="oculta_profession_id" style="display: none;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'profession_name'); ?>
                            <?php echo $form->textField($model,'profession_name'); ?>
                            <?php echo $form->error($model,'profession_name'); ?>
                        
                        <img id="profession_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: inline;" />
                        
                    </div>
                </td>
            </tr>
            <!-- Datos de Contratacion del Empleado -->
            <tr id="DatosContratacion">
                <!-- Campo Cargo -->
                <td id="vista_position_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'position_id'); ?>
                            <?php echo $form->dropDownList($model,'position_id',CHtml::listData(Position::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'position_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'position_id'); ?>
                        
                        <img id="position_id" title="Agregar Nuevo Cargo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                    </div>
                </td>
                <td id="oculta_position_id" style="display: none;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'position_name'); ?>
                            <?php echo $form->textField($model,'position_name'); ?>
                            <?php echo $form->error($model,'position_name'); ?>
                        
                        <img id="position_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: inline;" />
                        
                    </div>
                </td>
                <!-- Campo Horario -->
                <td id="vista_employee_hours_id">
                    <div class="row">
                            <?php echo $form->labelEx($model,'employee_hours_id'); ?>
                            <?php echo $form->dropDownList($model,'employee_hours_id',CHtml::listData(Employee::model()->findAllBySql("SELECT id, CONCAT(DATE_FORMAT(start_time,'%h:%i %p'), ' - ', DATE_FORMAT(end_time,'%h:%i %p')) as name FROM employee_hours;"),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'employee_hours_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'employee_hours_id'); ?>
                        
                        <img id="employee_hours_id" title="Agregar Nuevo Horario" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                    </div>
                </td>
                <td id="oculta_employee_hours_id" style="display: none;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'employee_hours_start'); ?>
                            <?php $this->widget('application.extensions.timepicker.timepicker', array('model'=>$model,'name'=>'employee_hours_start','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Entrada','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); ?>  
                            <?php echo $form->error($model,'employee_hours_start'); ?>
                        
                            <?php echo $form->labelEx($model,'employee_hours_end'); ?>
                            <?php $this->widget('application.extensions.timepicker.timepicker', array('model'=>$model,'name'=>'employee_hours_end','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Salida','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); ?>  
                            <?php echo $form->error($model,'employee_hours_end'); ?>
                        
                        <img id="employee_hours_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: inline;" />
                        
                    </div>
                </td>
                <!-- Campo Cabina -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'CABINA_Id'); ?>
                            <?php echo $form->dropDownList($model,'CABINA_Id',CHtml::listData(Cabina::model()->findAllBySql("SELECT Id,Nombre FROM Cabina WHERE status=:status AND Nombre!=:nombre;",array(':status'=>'1', ':nombre'=>'ZPRUEBA')),'Id','Nombre'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'CABINA_Id'); ?>
                    </div>
                </td>
                <!-- Campo Supervisor -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'immediate_supervisor'); ?>
                            <?php 
                            if($model->id != null){
                                echo $form->dropDownList($model,'immediate_supervisor',CHtml::listData(Employee::model()->findAllBySql("SELECT id, CONCAT(name, ' ', lastname) as name FROM employee WHERE id!=:id AND status!=2;",array(':id'=>$model->id)),'id','name'),array('empty'=>'Seleccionar..')); 
                            }else{
                                echo $form->dropDownList($model,'immediate_supervisor',CHtml::listData(Employee::model()->findAllBySql("SELECT id, CONCAT(name, ' ', lastname) as name FROM employee;"),'id','name'),array('empty'=>'Seleccionar..'));                                 
                            }
                            ?>
                            <?php echo $form->error($model,'immediate_supervisor'); ?>
                    </div>
                </td>
                <!-- Campo Salario -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'salary'); ?>
                            <?php echo $form->textField($model,'salary'); ?>
                            <?php echo $form->error($model,'salary'); ?>
                    </div>
                </td>
                <!-- Campo Status -->
                <?php if($model->status != 1){
                echo '<td>
                    
                      <div class="row">';
                                echo $form->labelEx($model,'status');
                                echo $form->dropDownList($model,'status',array('1'=>'Activo','2'=>'Inactivo'));
                                echo $form->error($model,'status');
                echo '</div>
                    </td>';
                } ?>
            </tr>
        </table>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->