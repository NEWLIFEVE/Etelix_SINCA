<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */

$this->breadcrumbs = array(
    'Detallegastos' => array('index'),
    'Manage',
);
//
//$this->menu = array(
//    array('label' => 'List Detallegasto', 'url' => array('index')),
//    array('label' => 'Create Detallegasto', 'url' => array('create')),
//);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);
?>

<meta charset="utf-8" />
<h1>
  <span class="enviar">
    Administrar Balances
  </span>
  <span>
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />

  </span>
</h1>

<?php
  echo CHtml::beginForm(Yii::app()->createUrl('detallegasto/enviarEmail/'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
  echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
  echo CHtml::textField('vista','admin',array('id'=>'vista','style'=>'display:none'));
  echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
  echo CHtml::textField('asunto','Reporte de Administrar Balances Solicitado',array('id'=>'asunto','style'=>'display:none'));
  echo CHtml::endForm();
  echo "<form action='";?><?php echo Yii::app()->request->baseUrl; ?><?php echo"/ficheroExcel.php?nombre=Balances_Cabinas' method='post' target='_blank' id='FormularioExportacion'>
          <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
        </form>";
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'detallegasto-grid',
    'dataProvider' => $model->search(),
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'filter' => $model,
    'columns' => array(
        //'Id',
        
        //'FechaMes',  
              array(
                   'name' => 'FechaMes',
                   'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                               'model'=>$model, 
                               'attribute'=>'FechaMes', 
                               'language' => 'ja',
                               'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
                               'htmlOptions' => array(
                                                'id' => 'datepicker_for_FechaMes',
                                                'size' => '20',
                                             ),
                               'defaultOptions' => array(  // (#3)
                                                   'showOn' => 'focus', 
                                                   'dateFormat' => 'yy-mm',
                                                   'showOtherMonths' => true,
                                                   'selectOtherMonths' => true,
                                                   'changeMonth' => true,
                                                   'changeYear' => true,
                                                   'showButtonPanel' => true,
                                                   )
                                           ), 
                               true),
                   'htmlOptions'=>array(
                                  'style'=>'text-align: center;',
                                  ),
                   ),
        array(
            'header'=>'Cabina',
            'name'=>'USERS_Id',
            'value'=>'Cabina::getNombreCabina2(Users::getCabinaIDFromUser($data->USERS_Id))',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),
            'filter'=>  Cabina::getListCabinaForFilterWithoutModel(),
//            'filter'=>CHtml::listData($options, 'Id', 'Nombre'),
            ),
        array(
            'name'=>'TIPOGASTO_Id',
            'value'=>'$data->tIPOGASTO->Nombre',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),
            'filter'=> Tipogasto::getListTipoGasto(),
            ),
            array(
            'name'=>'Monto',
            'value'=>'$data->Monto',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),           
            ),             
        array(
                   'name' => 'FechaVenc',
//                   'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                               'model'=>$model, 
//                               'attribute'=>'FechaVenc', 
//                               'language' => 'ja',
//                               'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
//                               'htmlOptions' => array(
//                                                'id' => 'datepicker_for_FechaVenc',
//                                                'size' => '15',
//                                             ),
//                               'defaultOptions' => array(  // (#3)
//                                                   'showOn' => 'focus', 
//                                                   'dateFormat' => 'yy-mm-dd',
//                                                   'showOtherMonths' => true,
//                                                   'selectOtherMonths' => true,
//                                                   'changeMonth' => true,
//                                                   'changeYear' => true,
//                                                   'showButtonPanel' => true,
//                                                   )
//                                           ), 
//                               true),
                   'htmlOptions'=>array(
                                  'style'=>'text-align: center;',
                                  ),
                   ),
        'Descripcion',
                /*array(
            'header'=>'Usuario',
            'name'=>'USERS_Id',
            'value'=>'$data->uSERS->username',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),
            'filter' => User::getListNombre(),
            ),*/
         array(
            'header'=>'status',
            'name'=>'status',
            'value'=>'Detallegasto::estadoGasto($data->status)',
                         'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),
             ),
        
        
         
        array(
            'header' => 'Detalle',
            'class' => 'CButtonColumn',
            'buttons' => Utility::ver(Yii::app()->getModule('user')->user()->tipo),
        ),
    ),
));
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_FechaMes').datepicker();
}
");
?>
