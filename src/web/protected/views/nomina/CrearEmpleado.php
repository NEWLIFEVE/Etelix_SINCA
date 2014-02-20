<?php


?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-CrearEmpleado-form',
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
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'code_employee'); ?>
                            <?php echo $form->textField($model,'code_employee'); ?>
                            <?php echo $form->error($model,'code_employee'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'name'); ?>
                            <?php echo $form->textField($model,'name'); ?>
                            <?php echo $form->error($model,'name'); ?>
                    </div>                    
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'lastname'); ?>
                            <?php echo $form->textField($model,'lastname'); ?>
                            <?php echo $form->error($model,'lastname'); ?>
                    </div>                    
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'identification_number'); ?>
                            <?php echo $form->textField($model,'identification_number'); ?>
                            <?php echo $form->error($model,'identification_number'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'gender'); ?>
                            <?php //echo $form->textField($model,'gender'); ?>
                            <?php echo $form->dropDownList($model,'gender',array('1'=>'Femenino','2'=>'Masculino'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'gender'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'marital_status_id'); ?>
                            <?php echo $form->dropDownList($model,'marital_status_id',CHtml::listData(MaritalStatus::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->textField($model,'marital_status_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'marital_status_id'); ?>
                        
                        <img id="marital_status_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                        <img id="marital_status_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: none;" />
                        
                    </div>
                </td>
            </tr>
            <!-- Datos de Contacto del Empleado -->
            <tr id="DatosContacto">
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'address'); ?>
                            <?php echo $form->textField($model,'address'); ?>
                            <?php echo $form->error($model,'address'); ?>
                    </div>
                </td>
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
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'academic_level_id'); ?>
                            <?php echo $form->dropDownList($model,'academic_level_id',CHtml::listData(AcademicLevel::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->textField($model,'academic_level_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'academic_level_id'); ?>
                        
                        <img id="academic_level_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                        <img id="academic_level_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: none;" />    
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'profession_id'); ?>
                            <?php echo $form->dropDownList($model,'profession_id',CHtml::listData(Profession::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->textField($model,'profession_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'profession_id'); ?>
                        <img id="profession_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                        <img id="profession_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: none;" /> 
                    </div>
                </td>
                <td></td>
                <td></td>
            </tr>
            <!-- Datos de Contratacion del Empleado -->
            <tr id="DatosContratacion">
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'position_id'); ?>
                            <?php echo $form->dropDownList($model,'position_id',CHtml::listData(Position::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->textField($model,'position_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'position_id'); ?>
                        <img id="position_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                        <img id="position_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: none;" /> 
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'employee_hours_id'); ?>
                            <?php echo $form->dropDownList($model,'employee_hours_id',CHtml::listData(Employee::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->textField($model,'employee_hours_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'employee_hours_id'); ?>
                        <img id="employee_hours_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 5px;" />
                        <img id="employee_hours_id2" title="Cancelar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonAgregar2" style="position: relative; top: 5px; display: none;" />
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'CABINA_Id'); ?>
                            <?php echo $form->dropDownList($model,'CABINA_Id',CHtml::listData(Cabina::model()->findAllBySql("SELECT Id,Nombre FROM Cabina WHERE status=:status AND Nombre!=:nombre;",array(':status'=>'1', ':nombre'=>'ZPRUEBA')),'Id','Nombre'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'CABINA_Id'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'immediate_supervisor'); ?>
                            <?php echo $form->dropDownList($model,'immediate_supervisor',CHtml::listData(Employee::model()->findAllBySql("SELECT id, CONCAT(name, ' ', lastname) as name FROM employee WHERE id!=:id;",array(':id'=>'2')),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'immediate_supervisor'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'salary'); ?>
                            <?php echo $form->textField($model,'salary'); ?>
                            <?php echo $form->error($model,'salary'); ?>
                    </div>
                </td>
            </tr>
        </table>
        <!--
	<div class="row">
		<?php echo $form->labelEx($model,'photo_path'); ?>
		<?php echo $form->textField($model,'photo_path'); ?>
		<?php echo $form->error($model,'photo_path'); ?>
	</div>
        -->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->