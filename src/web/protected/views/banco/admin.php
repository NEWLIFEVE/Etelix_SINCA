<?php
/**
* @var $this BancoController
* @var $model Banco 
*/

$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	'Manage',
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#banco-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
    $cuenta=NULL;
    $mes=NULL;
    
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        $mes=$_POST["formFecha"];
    }
    
    if(isset($_POST["formCuenta"]) && $_POST["formCuenta"] != "")
    {
        $cuenta=$_POST["formCuenta"];
    }

?>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
  <span class="enviar">
    Administrar Bancos
  </span>
  <span>
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    <div>
      <form method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/reportecaptura') ?>">
        <label for="dateMonth">
          Seleccione un mes:
        </label>
        <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>
        <?php echo CHtml::dropDownList('formCuenta', '', Cuenta::getListCuenta(), array('empty' => 'Seleccionar...')) ?>
        <span class="buttons">
          <input type="submit" value="Actualizar"/>
        </span>
      </form>
    </div>
  </span>
</h1>

<div id="fecha" style="display: none;"><?php echo $mes != NULL ? date('Ym',strtotime($mes)) : "";;?></div>
<div id="fecha2" style="display: none;"><?php echo $mes != NULL ? $mes : "";?></div>
<div id="cabina" style="display: none;"><?php echo $cuenta != NULL ? $cuenta : "";?></div>
<div id="cabina2" style="display: none;"><?php echo $cuenta != NULL ? Cuenta::validateCuentaNombre($cuenta) : "";?></div>

<?php
  echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail/'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
  echo CHtml::textField('html','Estados de Cuenta',array('id'=>'html','style'=>'display:none'));
  echo CHtml::textField('vista','/banco/admin',array('id'=>'vista','style'=>'display:none'));
  echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
  echo CHtml::textField('asunto','Reporte de Administrar Bancos Solicitado',array('id'=>'asunto','style'=>'display:none'));
  echo CHtml::endForm();
  echo "<form action=";?>
      <?php echo Yii::app()->request->baseUrl; ?>
          <?php echo"/ficheroExcel.php?nombre=Administrar_Bancos method='post' target='_blank' id='FormularioExportacion'>
          <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
        </form>";


  $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'banco-grid',
    'htmlOptions'=>array(
      'class'=>'grid-view Banco ReporteDepositos',
      'rel'=>'total',
      'name'=>'vista',
      ),
    'dataProvider'=>$model->search($_POST),
    'filter'=>$model,
    'columns'=>array(
      array(
            'name'=>'Id',
            'value'=>'$data->Id',
            'type'=>'text',
            'headerHtmlOptions' => array('style' => 'display:none'),
            'htmlOptions'=>array(
                'id'=>'ids',
                'style'=>'display:none',

              ),
              'filterHtmlOptions' => array('style' => 'display:none'),
            ),
      array(
        'name'=>'Fecha',
        'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model'=>$model,
          'attribute'=>'Fecha',
          'language'=>'ja',
          'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
          'htmlOptions'=>array(
            'id'=>'datepicker_for_Fecha',
            'size'=>'15',
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
          ),
        ),
      array(
        'name'=>'CUENTA_Id',
        'value'=>'$data->cUENTA->Nombre',
        'type'=>'text',
        'filter'=>Cuenta::getListCuenta(),
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          ),
        ),
      array(
        'name'=>'SaldoApBanco',
        'htmlOptions'=>array(
          'style'=>'text-align: center;'
          ),
        ),
      array(
        'name'=>'IngresoBanco',
        'value'=>'Balance::sumMontoBanco($data->Fecha,$data->CUENTA_Id)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          ),
        ),
      array(
        'name'=>'EgresoBanco',
        'value'=>'Detallegasto::sumGastosBanco($data->Fecha,$data->CUENTA_Id)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          ),
        ),
      array(
        'name'=>'SaldoLibro',
        'value'=>'Yii::app()->format->formatDecimal($data->SaldoApBanco+Balance::sumMontoBanco($data->Fecha,$data->CUENTA_Id)-Detallegasto::sumGastosBanco($data->Fecha,$data->CUENTA_Id))',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          ),
        ),
      array(
        'name'=>'SaldoCierreBanco',
        'value'=>'Yii::app()->format->formatDecimal($data->SaldoCierreBanco)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;'
          ),
        ),
      array(
        'header'=>'Detalle',
        'class'=>'CButtonColumn',
        'buttons'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
        ),
      ),
)); ?>