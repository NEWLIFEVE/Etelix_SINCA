<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);

?>



<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    Administrar Empleados 
    
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
                        'name'=>'id',
                        'value'=>'$data->id',
                        'type'=>'text',
                        'headerHtmlOptions' => array('style' => 'display:none'),
                        'htmlOptions'=>array(
                            'id'=>'ids',
                            'style'=>'display:none',

                          ),
                          'filterHtmlOptions' => array('style' => 'display:none'),
                        ),
                    array(
                        'name'=>'code_employee',
                        'value'=>'$data->code_employee',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ),
                    array(
                        'name'=>'name',
                        'value'=>'$data->name',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ), 
                    array(
                        'name'=>'lastname',
                        'value'=>'$data->lastname',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ), 
                    array(
                        'name'=>'identification_number',
                        'value'=>'$data->identification_number',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'gender',
                            'style'=>'text-align: center',
                          ),
                        ), 
//                    array(
//                        'name'=>'gender',
//                        'value'=>'$data->gender == 1 ? "Femenino" : "Masculino"',
//                        'type'=>'text',
//                        'htmlOptions'=>array(
//                            'id'=>'gender',
//                            'style'=>'text-align: center',
//                          ),
//                        ),
                    array(
                        'name'=>'CABINA_Id',
                        'value'=>'$data->cABINA->Nombre',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'CABINA_Id',
                            'style'=>'text-align: center; width: 80px;',
                          ),
                        'filter'=>  Cabina::getListCabina(),
                        ),
                    array(
                        'name'=>'position_id',
                        'value'=>'$data->position->name',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'position_id',
                            'style'=>'text-align: center',
                            'style'=>'text-align: center; width: 100px;',
                          ),
                        ),
                    'salary',
                    array(
                        'name'=>'immediate_supervisor',
                        'value'=>'($data->immediate_supervisor == null) ? "Sin Supervisor" : $data->immediateSupervisor->name." ".$data->immediateSupervisor->lastname',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'immediate_supervisor',
                            'style'=>'text-align: center; width: 80px;',
                          ),
                        ),
                    array(
                        'name'=>'admission_date',
                        'value'=>'$data->admission_date',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'admission_date',
                            'style'=>'text-align: center; width: 60px;',
                          ),
                        ),
                     array(
                        'name'=>'status',
                        'value'=>'($data->status == 1) ? "Activo" : "Inactivo"',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'immediate_supervisor',
                            'style'=>'text-align: center; width: 60px;',
                          ),
                        ),
                     

                    array(
                            'header' => 'Detalle',
                            'class'=>'CButtonColumn',
                            'deleteConfirmation'=>"js:'Desea pasar este Empleado a Inactivo?'",
                            'buttons'=>array
                            (
                                'view' => array
                                (
                                    'label'=>'Ver Empleado',
                                    'url'=>'Yii::app()->createUrl("nomina/viewEmpleado", array("id"=>$data->id))',
                                    'imageUrl'=>Yii::app()->request->baseUrl."/themes/mattskitchen/img/view.png",
                                ),
                                'update' => array
                                (
                                    'label'=>'Actualizar Empleado',
                                    'url'=>'Yii::app()->createUrl("nomina/CrearEmpleado", array("id"=>$data->id))',
                                    'imageUrl'=>Yii::app()->request->baseUrl."/themes/mattskitchen/img/update.png",
                                ), 
                                'delete' => array
                                (
                                    'label'=>'Desactivar Empleado',
                                    'url'=>'Yii::app()->createUrl("nomina/DesactivarEmpleado", array("id"=>$data->id))',
                                    'imageUrl'=> Yii::app()->request->baseUrl."/themes/mattskitchen/img/disabled.png",
                                    'visible'=>'($data->status==1)?true:false',
//                                    'options'=>array(
//                                        'style'=> '($data->status==1)? "" : opacity: 0.3',
//                                      ),
                                ),
                            ),
                    ),
            ),
        )); 

?>
