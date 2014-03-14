
<?php

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);
?>
 <script>
//  $(function() {
//    $( "#tabs" ).tabs();
//  });
  $(function(){
	// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $(document).on("click",".botonAdd",function(){
            
            addKid();

        });
 	// Evento que selecciona la fila y la elimina 
	$(document).on("click",".botonQuitar",function(){
            var parent = $(this).attr("id");

            $('div#'+parent).remove();

            $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonQuitar").css('display', 'inline');
            $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonAdd").css('display', 'inline');

            if(parent.substring(3,4) == 2){
                $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonQuitar").css('display', 'none');
            }else{
                $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonQuitar").css('display', 'inline');
            }
	});
});
 </script>
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
        
        <table id="datosEmpleado">
            <tr>
                <td colspan="5">
                <br>    
                <h2>
                    <span class="enviar" style="position: relative;">Datos Personales y de Contratacion</span>
                </h2>    
                </td>
            </tr>
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
                <td style="width:5%;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'name'); ?>
                            <?php echo $form->textField($model,'name'); ?>
                            <?php echo $form->error($model,'name'); ?>
                    </div>                    
                </td>
                <!-- Campo Apellido -->
                <td style="width:20%;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'lastname'); ?>
                            <?php echo $form->textField($model,'lastname'); ?>
                            <?php echo $form->error($model,'lastname'); ?>
                    </div>                    
                </td>
                <!-- Campo Numero de Identificacion -->
                <td style="width:15%;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'identification_number'); ?>
                            <?php echo $form->textField($model,'identification_number'); ?>
                            <?php echo $form->error($model,'identification_number'); ?>
                    </div>
                </td>
                <!-- Campo Sexo -->
                <td style="width:15%;">
                    <div class="row">
                            <?php echo $form->labelEx($model,'gender'); ?>
                            <?php echo $form->dropDownList($model,'gender',array('1'=>'Femenino','2'=>'Masculino'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'gender'); ?>
                    </div>
                </td>
                <!-- Campo Estado Civil -->
                <td style="width:25%;">
                    <div class="row" id="vista_marital_status_id">
                            <?php echo $form->labelEx($model,'marital_status_id'); ?>
                            <?php echo $form->dropDownList($model,'marital_status_id',CHtml::listData(MaritalStatus::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'marital_status_id'); ?>
                        
                        <img id="marital_status_id" title="Agregar Nuevo Estado Civil" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 3px;" />
                        
                    </div>
                    <div class="row" id="oculta_marital_status_id" style="display: none;">
                            <?php echo $form->labelEx($model,'marital_status_name'); ?>
                            <?php echo $form->textField($model,'marital_status_name'); ?>
                            <?php echo $form->error($model,'marital_status_name'); ?>
                        
                        <img id="marital_status_id2" title="Atras" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/back.png" class="botonAgregar2" style="position: relative; top: 3px; display: inline;" />
                        
                    </div>
                </td>
            </tr>
            <!-- Datos de Contacto del Empleado -->
            <tr id="DatosContacto">
                <!-- Campo Cabina -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'CABINA_Id'); ?>
                            <?php echo $form->dropDownList($model,'CABINA_Id',CHtml::listData(Cabina::model()->findAllBySql("SELECT Id,Nombre FROM Cabina WHERE status=:status AND Nombre!=:nombre;",array(':status'=>'1', ':nombre'=>'ZPRUEBA')),'Id','Nombre'),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'CABINA_Id'); ?>
                    </div>
                </td>
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
                <!-- Campo Nivel Academico -->
                <td style="width:20%;">
                    <div class="row" id="vista_academic_level_id">
                            <?php echo $form->labelEx($model,'academic_level_id'); ?>
                            <?php echo $form->dropDownList($model,'academic_level_id',CHtml::listData(AcademicLevel::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'academic_level_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'academic_level_id'); ?>
                        
                        <img id="academic_level_id" title="Agregar Nuevo Nivel Academico" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 3px;" />
                    </div>
                    <div class="row" id="oculta_academic_level_id" style="display: none;">
                            <?php echo $form->labelEx($model,'academic_level_name'); ?>
                            <?php echo $form->textField($model,'academic_level_name'); ?>
                            <?php echo $form->error($model,'academic_level_name'); ?>
                        
                        <img id="academic_level_id2" title="Atras" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/back.png" class="botonAgregar2" style="position: relative; top: 3px; display: inline;" />
                        
                    </div>
                </td>
                <!-- Campo Profesion -->
                <td style="width:15%;">
                    <div class="row" id="vista_profession_id">
                            <?php echo $form->labelEx($model,'profession_id'); ?>
                            <?php echo $form->dropDownList($model,'profession_id',CHtml::listData(Profession::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'profession_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'profession_id'); ?>
                        
                        <img id="profession_id" title="Agregar Nueva Profesion" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 3px;" />
                    </div>
                    <div class="row" id="oculta_profession_id" style="display: none;">
                            <?php echo $form->labelEx($model,'profession_name'); ?>
                            <?php echo $form->textField($model,'profession_name'); ?>
                            <?php echo $form->error($model,'profession_name'); ?>
                        
                        <img id="profession_id2" title="Atras" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/back.png" class="botonAgregar2" style="position: relative; top: 3px; display: inline;" />
                        
                    </div>
                </td>
            </tr>

            <!-- Datos de Contratacion del Empleado -->
            <tr id="DatosContratacion">
                
                <!-- Campo Cargo -->
                <td style="width:22%;">
                    <div class="row" id="vista_position_id">
                            <?php echo $form->labelEx($model,'position_id'); ?>
                            <?php echo $form->dropDownList($model,'position_id',CHtml::listData(Position::model()->findAll(),'id','name'),array('empty'=>'Seleccionar..')); ?>
                            <?php //echo $form->textField($model,'position_id',array('style'=>'display:none;width:101px')); ?>
                            <?php echo $form->error($model,'position_id'); ?>
                        
                        <img id="position_id" title="Agregar Nuevo Cargo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAgregar" style="position: relative; top: 3px;" />
                    </div>
                    <div class="row" id="oculta_position_id" style="display: none;">
                            <?php echo $form->labelEx($model,'position_name'); ?>
                            <?php echo $form->textField($model,'position_name'); ?>
                            <?php echo $form->error($model,'position_name'); ?>
                        
                        <img id="position_id2" title="Atras" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/back.png" class="botonAgregar2" style="position: relative; top: 3px; display: inline;" />
                        
                    </div>
                </td>
                <!-- Campo Fecha de Ingreso -->
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model, 'admission_date'); ?>
                            <?php 
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', 
                                            array(
                                            'language' => 'es', 
                                            'model' =>$model,
                                            //'value' =>date('d/m/Y',strtotime($model->admission_date)),
                                            'attribute'=>'admission_date', 
                                            'options' => array(
                                            //'dateFormat'=>'mm/dd/yy',
                                            'changeMonth' => 'true',//para poder cambiar mes
                                            'changeYear' => 'true',//para poder cambiar año
                                            'showButtonPanel' => 'false', 
                                            'constrainInput' => 'false',
                                            'showAnim' => 'show',
                                            //'minDate'=>'-30D', //fecha minima
                                            //'maxDate'=> "+30D", //fecha maxima
                                             ),
                                                'htmlOptions'=>array(
                                                    'readonly'=>'readonly',
                                                    ),
                                        )); 
                                            echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                                        ?>
                            <?php echo $form->error($model, 'admission_date'); ?>
                    </div>
                </td>
                <!-- Campo Supervisor -->
                <td>
                    <div class="row" style="width:25%;">
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
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'currency_id'); ?>
                            <?php echo $form->dropDownList($model,'currency_id',CHtml::listData(Currency::model()->findAll(), 'id', 'name'),array('empty'=>'Seleccionar..')) ?>
                            <?php echo $form->error($model,'currency_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>

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
            <tr>
                <td colspan="5">
                <br>    
                <h2>
                    <span class="enviar" style="position: relative;">Horario de Trabajo</span>
                </h2>    
                </td>
            </tr>
            <!-- Campo Horario de Lunes a Viernes -->
            <tr>
                
                <td>
                <div class="row">
                    <?php echo $form->labelEx($model_hour_day_1,'Lunes a Viernes'); ?>
                    <?php echo $form->checkBox($model_hour_day_1,'day_1'); ?>
                    <?php echo $form->error($model_hour_day_1,'day_1'); ?>
                </div>
                </td>
                <!-- Campo Horario -->
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model_hour_day_1,'Hora de Entrada'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_1,'name'=>'start_time_1','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Entrada','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model_hour_day_1,
                                'attribute' => 'start_time_1',
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
                            ?>  
                            <?php echo $form->error($model_hour_day_1,'start_time_1'); ?>
                    </div>
                </td>
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model_hour_day_1,'Hora de Salida'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_1,'name'=>'end_time_1','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Salida','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model_hour_day_1,
                                'attribute' => 'end_time_1',
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
                            ?>  
                            <?php echo $form->error($model_hour_day_1,'end_time_1'); ?>
                    </div>
                </td>
            </tr>
            <!-- Campo Horario Sadado -->
            <tr>
                <td>
                <div class="row">
                    <?php echo $form->labelEx($model_hour_day_2,'Sabado'); ?>
                    <?php echo $form->checkBox($model_hour_day_2,'day_2'); ?>
                    <?php echo $form->error($model_hour_day_2,'day_2'); ?>
                </div>
                </td>
                <!-- Campo Horario -->
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model_hour_day_2,'Hora de Entrada'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_2,'name'=>'start_time_2','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Entrada','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model_hour_day_2,
                                'attribute' => 'start_time_2',
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
                            ?>  
                            <?php echo $form->error($model_hour_day_2,'start_time_2'); ?>
                    </div>
                </td>
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model_hour_day_2,'Hora de Salida'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_2,'name'=>'end_time_2','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Salida','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model_hour_day_2,
                                'attribute' => 'end_time_2',
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
                            ?>  
                            <?php echo $form->error($model_hour_day_2,'end_time_2'); ?>
                    </div>
                </td>
            </tr>
            <!-- Campo Horario Domingos -->
            <tr>
                <td>
                <div class="row">
                    <?php echo $form->labelEx($model_hour_day_3,'Domingo'); ?>
                    <?php echo $form->checkBox($model_hour_day_3,'day_3'); ?>
                    <?php echo $form->error($model_hour_day_3,'day_3'); ?>
                </div>
                </td>
                <!-- Campo Horario -->
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model_hour_day_3,'Hora de Entrada'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_3,'name'=>'start_time_3','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Entrada','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model_hour_day_3,
                                'attribute' => 'start_time_3',
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
                            ?>  
                            <?php echo $form->error($model_hour_day_3,'start_time_3'); ?>
                    </div>
                </td>
                <td id="oculta_employee_id">
                    <div class="row">
                            <?php echo $form->labelEx($model_hour_day_3,'Hora de Salida'); ?>
                            <?php 
                            
                            //$this->widget('application.extensions.timepicker.timepicker', array('model'=>$model_hour_day_3,'name'=>'end_time_3','select'=> 'time','options' => array('showOn'=>'focus','timeFormat'=>'hh:mm','timeText'=>'Tiempo','hourText'=>'Hora','minuteText'=>'Minuto','timeOnlyTitle'=>'Hora de Salida','currentText'=>'Ahora','closeText'=>'Listo','timeOnly'=>true ))); 
                            
                            $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                                'model' => $model_hour_day_3,
                                'attribute' => 'end_time_3',
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
                            ?>  
                            <?php echo $form->error($model_hour_day_3,'end_time_3'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                <br>    
                <h2>
                    <span class="enviar" style="position: relative;">Edades de los Hijos</span>
                </h2>    
                </td>
            </tr>
        </table>
            <!-- Hijos del Empleado -->
            <table>    
            <tr id="DatosHijos">
                <!-- Campo Edad -->
                <td id="col">
                    <div style="display: none;">
                    <?php echo $form->textField($model,'kids'); ?>
                    </div>

                    
                    <?php 
                    if(count($model_kid)>1){
                    foreach ($model_kid as $key => $value) {
                    
                    ?>
                    <div class="row" id="row<?php echo ($key+1);?>" style="float:left;">
                            <?php echo $form->labelEx($value,'Edad del Hijo #'.($key+1)); ?>
                            <?php echo $form->numberField($value,'age',array('id'=>'age'.($key+1))); ?>
                            <?php echo $form->error($value,'age'); ?>
                            <img id="row<?php echo ($key+1);?>" title="Quitar Hijo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonQuitar" style="position: relative; top: 3px; display: none;" />
                            <img id="row<?php echo ($key+1);?>" title="Agregar Hijo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAdd" style="position: relative; top: 3px; display: none;" />
                    </div>
                    <?php 
                    
                    }
                    }else{
                    
                    ?>
                    <div class="row" id="row1" style="float:left;">
                            <?php echo $form->labelEx($model_kid,'Edad del Hijo #1'); ?>
                            <?php echo $form->numberField($model_kid,'age',array('id'=>'age1')); ?>
                            <?php echo $form->error($model_kid,'age'); ?>
                            <img id="row1" title="Quitar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/close.png" class="botonQuitar" style="position: relative; top: 3px; display: none;" />
                            <img id="row1" title="Agregar" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/add.png" class="botonAdd" style="position: relative; top: 3px; display: none;" />
                    </div>
                    <?php }?>
                </td>
<!--                <td style="position: absolute;">
                    <div class="row buttons">
                        <?php // echo CHtml::Button('Agregar Hijo'); ?>
                    </div>
                </td>-->
                
            </tr>
            
        </table>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->