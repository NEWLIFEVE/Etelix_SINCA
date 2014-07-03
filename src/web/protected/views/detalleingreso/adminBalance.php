<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetalleingresoController::controlAccesoBalance($tipoUsuario);
$mes = null;

    if($tipoUsuario == 1){
        $cabina = Yii::app()->getModule('user')->user()->CABINA_Id;
        $_POST = 'admin';
    }else{
        $cabina = NULL;
        $_POST = NULL;
    }
?>

<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
  <span class="enviar">
    Administrar Ingresos
  </span>
  <span id="botones">
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoNew" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelNew" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonNew'/>


    <?php 
      if($tipoUsuario>1)
      {
          echo "<button id='cambio'>Inactivas</button>";
      }
      ?>
  </span>
</h1>

<?php

  /*
  GridView del Balance
  */
 
  $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balance-grid',
    'htmlOptions'=>array(
      'rel'=>'total',
      'name'=>'vista',
      ),
    'dataProvider'=>$model->search($_POST,$mes,$cabina),
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
      /*Columnas Ocultas*/  
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
        'name'=>'CABINA_Id',
        'value'=>'$data->CABINA_Id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'cabinas',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        /*  Fin Cabinas Ocultas */
      array(
        'name'=>'Fecha',
        'header'=>'Fecha',  
        'id'=>'Fecha',
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
          'id'=>'fecha',
          ),
        ),
      array(
        'name'=>'CABINA_Id',
        'value'=>'$data->cABINA->Nombre',
        'type'=>'text',
        'filter'=>($tipoUsuario == 1) ? '' : Cabina::getListCabina(),
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
            'id'=>'cabina',
          ),
        ),
      array(
        'name'=>'SaldoAp',
        'value'=>'$data->SaldoAp',
        'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',  
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'aperturaMov',
          ),
         
        ),
      array(
            'name'=>'Trafico',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","trafico", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',  
            'htmlOptions'=>array(
                'id'=>'trafico',
                ),
            ), 
      array(
            'name'=>'ServMov',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServMov", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',  
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                ),
            ),
        array(
            'name'=>'ServClaro',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServClaro", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',      
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                ),
            ),
        array(
            'name'=>'ServDirecTv',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServDirecTv", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',  
            'htmlOptions'=>array(
                'id'=>'ServDirecTv',
                ),
            ),
        array(
            'name'=>'ServNextel',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServNextel", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',  
            'htmlOptions'=>array(
                'id'=>'ServNextel',
                ),
            ),
      array(
        'name'=>'MontoDeposito',
        'value'=>'Deposito::getDeposito($data->Fecha, $data->CABINA_Id)',
        'filter'=>($tipoUsuario == 1) ? '' : '<input type="text">',    
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'montoDeposito',
          ),
        ),
      array(
        'header'=>'Detalle',
        'class'=>'CButtonColumn',
//        'buttons'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
        'buttons'=>Utility::ver(1),  
        ),
      ),
    )
  );
  

  $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balance-grid-oculta',

    'htmlOptions'=>array(
      'class'=>'grid-view oculta',
      'rel'=>'total',
      'name'=>'oculta',
      ),
    'dataProvider'=>$model->disable($_POST,$mes,$cabina),
    'afterAjaxUpdate'=>'reinstallDatePicker2',
    'filter'=>$model,
    'columns'=>array(
      /*Columnas Ocultas*/  
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
        'name'=>'CABINA_Id',
        'value'=>'$data->CABINA_Id',
        'type'=>'text',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions'=>array(
            'id'=>'cabinas',
            'style'=>'display:none',
          ),
          'filterHtmlOptions' => array('style' => 'display:none'),
        ),
        /*  Fin Cabinas Ocultas */
      array(
        'name'=>'Fecha',
        'header'=>'Fecha',  
        'id'=>'Fecha',
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
          'id'=>'fecha',
          ),
        ),
      array(
        'name'=>'CABINA_Id',
        'value'=>'$data->cABINA->Nombre',
        'type'=>'text',
        'filter'=>Cabina::getListCabina(),
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
            'id'=>'cabina',
          ),
        ),
      array(
        'name'=>'SaldoAp',
        'value'=>'$data->SaldoAp',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'aperturaMov',
          ),
        ),
      array(
            'name'=>'Trafico',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","trafico", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'trafico',
                ),
            ), 
      array(
            'name'=>'ServMov',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServMov", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaMov',
                ),
            ),
        array(
            'name'=>'ServClaro',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServClaro", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'recargaClaro',
                ),
            ),
        array(
            'name'=>'ServDirecTv',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServDirecTv", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServDirecTv',
                ),
            ),
        array(
            'name'=>'ServNextel',
            'value'=>'Detalleingreso::getLibroVentas("LibroVentas","ServNextel", $data->Fecha, $data->CABINA_Id)',
            'type'=>'text',
            'htmlOptions'=>array(
                'id'=>'ServNextel',
                ),
            ),
      array(
        'name'=>'MontoDeposito',
        'value'=>'Deposito::getDeposito($data->Fecha, $data->CABINA_Id)',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'montoDeposito',
          ),
        ),
      array(
        'header'=>'Detalle',
        'class'=>'CButtonColumn',
        'buttons'=>Utility::ver(1),
        ),
      ),
    )
  );

   
  Yii::app()->clientScript->registerScript('re-install-date-picker', "
    function reinstallDatePicker(id, data)
    {
      $('#datepicker_for_Fecha').datepicker();
    }
  ");
  Yii::app()->clientScript->registerScript('re-install-date-picker2', "
function reinstallDatePicker2(id, data) {
    $('#datepicker_for_Fecha_oculta').datepicker();
    $('div[name=".'"oculta"'."]').css('display','block');     
    $('div[name=".'"vista"'."]').css('display','none'); 
}
");
?>
<div id="totales" class="grid-view">
<table class="items">
    <thead>
        <tr>
           <th style="background:#00992B; color:white;width: 77px;">Fecha</th>
            <th style="background:#00992B; color:white;">Cabina</th>
            <th id="vistaAdmin1" style="background:#00992B; color:white;"></th>
            <th id="totalTrafico" style="background:#00992B; color:white;"></th>
            <th id="totalRecargaMov" style="background:#00992B; color:white;"></th>
            <th id="totalRecargaClaro" style="background:#00992B; color:white;"></th>
            <th id="totalServDirecTv" style="background:#00992B; color:white;"></th>
            <th id="totalServNextel" style="background:#00992B; color:white;"></th>
            <th id="totalMontoDeposito" style="background:#00992B; color:white;"></th>
        </tr>
    </thead>
    <tbody>
      <tr class="odd">
        <td id="totalFecha"></td>
        <td id="todas">Todas</td>
        <td id="vistaAdmin1"></td>
        <td id="totalTrafico"></td>
        <td id="totalRecargaMov"></td>
        <td id="totalRecargaClaro"></td>
        <td id="totalServDirecTv"></td>
        <td id="totalServNextel"></td>
        <td id="totalMontoDeposito"></td>
      </tr>
    </tbody>
</table>
</div>