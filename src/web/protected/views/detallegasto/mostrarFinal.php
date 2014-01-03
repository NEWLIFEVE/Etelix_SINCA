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

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#detallegasto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gastos Actualizados</h1>

<!--<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'mostrarfinal-grid',
    'htmlOptions' => array(
        'class' => 'grid-view ReporteBrighstar',
        'rel' => 'total',
        'name' => 'vista',
    ),
    'dataProvider' => $model->search('mostrarFinal',NULL,NULL,NULL,$_GET['idBalancesActualizados']),
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'filter' => $model,
    'columns' => array(
              array(
                   'name' => 'FechaMes',
                   'value'=>  'Utility::monthName($data->FechaMes)',
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
            'filter'=>  Accionlog::getListAccionLog(),
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
        'TransferenciaPago',
        array(
            'name' => 'FechaTransf',
            'type' => 'raw',
            'value' => 'Utility::cambiarFormatoFecha($data->FechaTransf)',
//            'htmlOptions' => array(
//                "width" => "100px"
//            ),
        ),
//        array(
//                   'name' => 'FechaVenc',
//                   'htmlOptions'=>array(
//                                  'style'=>'text-align: center;',
//                                  ),
//                   ),
        'Descripcion',
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
            'template' => Utility::ver(Yii::app()->getModule('user')->user()->tipo),
        ),
    ),
));
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_FechaMes').datepicker();
}
");
?>
