<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NominaController::controlAcceso($tipoUsuario);

?>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>


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
            'htmlOptions'=>array(
                'rel'=>'total',
                'name'=>'vista',
            ),
            'dataProvider'=>$model->search(),
            'afterAjaxUpdate'=>'reinstallDatePicker',
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
//                    array(
//                        'name'=>'code_employee',
//                        'value'=>'$data->code_employee',
//                        'type'=>'text',
//                        'htmlOptions'=>array(
//                            'id'=>'gender',
//                            'style'=>'text-align: center',
//                          ),
//                        ),
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
                        'filter'=> Position::getListPosition(),
                        ),
                    array(
                        'name'=>'salary',
                        'value'=>'$data->salary',
                        //'value'=>'$data->salary.\' \'.$data->currency->name',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'salary',
                            'style'=>'text-align: center',
                            'style'=>'text-align: center; width: 80px;',
                          ),
                        ),
                    array(
                        'name'=>'currency_id',
                        'value'=>'$data->currency->name',
                        //'value'=>'$data->salary.\' \'.$data->currency->name',
                        'type'=>'text',
                        'htmlOptions'=>array(
                            'id'=>'salary',
                            'style'=>'text-align: center',
                            'style'=>'text-align: center; width: 80px;',
                          ),
                        ),
//                    array(
//                        'name'=>'bank_account',
//                        'value'=>'$data->bank_account',
//                        //'value'=>'$data->salary.\' \'.$data->currency->name',
//                        'type'=>'text',
//                        'htmlOptions'=>array(
//                            'id'=>'salary',
//                            'style'=>'text-align: center',
//                            'style'=>'text-align: center; width: 50px;',
//                          ),
//                        ),    
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
                        'id'=>'admission_date',
                        'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                          'model'=>$model,
                          'attribute'=>'admission_date',
                          'language'=>'ja',
                          'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                          'htmlOptions'=>array(
                            'id'=>'datepicker_for_Fecha',
                            'size'=>'10',
                            ),
                          'defaultOptions'=>array(
                            'showOn'=>'focus',
                            'dateFormat'=>'yy-mm-dd',
                            'showOtherMonths'=>true,
                            'selectOtherMonths'=>true,
                            'changeMonth'=>true,
                            'changeYear'=>true,
                            'showButtonPanel'=>true,
                            )
                          ),
                        true),
                        'htmlOptions'=>array(
                          'style'=>'text-align: center;',
                          'id'=>'fecha',
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
        Yii::app()->clientScript->registerScript('re-install-date-picker', "
            function reinstallDatePicker(id, data)
            {
              $('#datepicker_for_Fecha').datepicker();
            }
          ");

?>
