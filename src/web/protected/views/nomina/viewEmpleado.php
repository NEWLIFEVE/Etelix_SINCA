<?php
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);
?>


<h1>Detalle del Empleado #<?php echo $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
            array(
                    'name'=>'CABINA_Id',
                    'value'=>$model->cABINA->Nombre,
                ),
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
//            array(
//                    'name'=>'employee_hours_id',
//                    'value'=>date('h:i A',strtotime($model->employeeHours->start_time)).' - '.date('h:i A',strtotime($model->employeeHours->end_time)),
//                ),
            array(
                    'name'=>'immediate_supervisor',
                    'value'=>($model->immediate_supervisor == null) ? 'Sin Supervisor' : $model->immediateSupervisor->name,
                ),
            array(
                    'name'=>'salary',
                    'value'=>$model->salary,
                ),
            array(
                    'name'=>'status',
                    'value'=>($model->status == 1) ? 'Activo' : 'Inactivo',
                ),
 
	),
)); ?>
