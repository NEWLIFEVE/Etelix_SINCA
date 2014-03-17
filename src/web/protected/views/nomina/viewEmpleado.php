<?php
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);
$kids = Kids::getEmployeeKids($model->id);
?>


<h1>Detalle del Empleado #<?php echo $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
            
             array(
                    'name'=>'code_employee',
                    'value'=>$model->code_employee,
                ),
            
             array(
                    'name'=>'name',
                    'value'=>$model->name,
                ),
             array(
                    'name'=>'lastname',
                    'value'=>$model->lastname,
                ),
             array(
                    'name'=>'identification_number',
                    'value'=>$model->identification_number,
                ),
             array(
                    'name'=>'gender',
                    'value'=> ($model->gender == 1) ? 'Femenino' : 'Masculino',
                ),
            array(
                    'name'=>'marital_status_id',
                    'value'=>$model->maritalStatus->name,
                ),
            array(
                    'name'=>'CABINA_Id',
                    'value'=>$model->cABINA->Nombre,
                ),
            array(
                    'name'=>'address',
                    'value'=>$model->address,
                ),
            array(
                    'name'=>'phone_number',
                    'value'=>$model->phone_number,
                ),
            array(
                    'name'=>'academic_level_id',
                    'value'=>$model->academicLevel->name,
                ),
            array(
                    'name'=>'profession_id',
                    'value'=>$model->profession->name,
                ),
            array(
                    'name'=>'position_id',
                    'value'=>$model->position->name,
                ),
            array(
                    'name'=>'immediate_supervisor',
                    'value'=>($model->immediate_supervisor == null) ? 'Sin Supervisor' : $model->immediateSupervisor->name,
                ),
            array(
                    'name'=>'salary',
                    'value'=>$model->salary.' '.$model->currency->name,
                ),
            array(
                    'name'=>'admission_date',
                    'value'=>$model->admission_date,
                ),
            array(
                    'name'=>'status',
                    'value'=>($model->status == 1) ? 'Activo' : 'Inactivo',
                ),
            //MUESTRA EL HORARIO DEL EMPLEADO
            array(
                    'type'=>'raw',
                    'name'=>'Horario',
                    'value'=>'Entrada - Salida',
                    'cssClass'=>'resaltado',
                ),
            array(
                    'name'=>'Lunes a Viernes',
                    'value'=>  EmployeeHours::getEmployeeHoursDay($model->id,1),
                ),
            array(
                    'name'=>'Sabado',
                    'value'=>  EmployeeHours::getEmployeeHoursDay($model->id,2),
                ),
            array(
                    'name'=>'Domingo',
                    'value'=>  EmployeeHours::getEmployeeHoursDay($model->id,3),
                ),
            //MUESTRA LOS HIJOS DEL EMPLEADO
//            array(
//                    'name'=>'Hijos',
//                    'value'=>'De Mayor a Menor',
//                    'cssClass'=>'resaltado',
//                )
//           
//            array(
//                    'name'=>'Hijo #'.$key,
//                    'value'=> $value->age,
//                ),

                
	),
)); ?>
