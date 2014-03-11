<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);

?>



<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    Administrar Eventos 
    
    <img  title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
    <img  title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
    <img  title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton'/>
  </span >
</h1>



<?php 
        //GridView del Empleado

        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'employee-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'columns'=>array(
                    array(
                        'name'=>'employee_id',
                        'value'=>'$data->employee->name $data->employee->lastname',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ),
                    array(
                        'name'=>'event_id',
                        'value'=>'$data->event_id',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ), 
                    array(
                        'name'=>'concurrency_date',
                        'value'=>'$data->concurrency_date',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ), 
                    array(
                            'header' => 'Detalle',
                            'class'=>'CButtonColumn',
                            //'template' => Utility::ver(Yii::app()->getModule('user')->user()->tipo),
                            'buttons'=>array
                            (
                                'view' => array
                                (
                                    'label'=>'Ver Evento',
                                    'url'=>'Yii::app()->createUrl("nomina/viewEvento", array("id"=>$data->employee_id,"id"=>$data->event_id))',
                                ),
                                'update' => array
                                (
                                    'label'=>'Actualizar Evento',
                                    'url'=>'Yii::app()->createUrl("nomina/EventoEmpleado", array("employee_id"=>$data->employee_id,"event_id"=>$data->event_id))',
                                ),
                                'delete' => array
                                (
                                    'label'=>'Eliminar Evento',
                                    'url'=>'Yii::app()->createUrl("nomina/DesactivarEmpleado", array("id"=>$data->employee_id,"id"=>$data->event_id))',
                                    'deleteConfirmation'=>'Colocar Inactivo ?', 
                                ),
                            ),
                    ),
            ),
        )); 

?>
