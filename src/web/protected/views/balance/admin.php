<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>

<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
  <span class="enviar">
    Administrar Balances
  </span>
  <span id="botones">
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton'/>


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
    'dataProvider'=>$model->searchEs('admin'),
    'afterAjaxUpdate'=>'reinstallDatePicker',
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
        'id'=>'Fechas',
        'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model'=>$model,
          'attribute'=>'Fecha',
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
        'name'=>'SaldoApMov',
        'value'=>'Utility::noDeclarado($data->SaldoApMov)',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'aperturaMov',
          ),
        ),
      array(
        'name'=>'SaldoApClaro',
        'value'=>'Utility::noDeclarado($data->SaldoApClaro)',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'aperturaClaro',
          ),
        ),
      array(
        'name'=>'Trafico',
        'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'trafico',
          ),
        ), 
      array(
        'name'=>'RecargaMovistar',
        'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularMov+$data->RecargaFonoYaMov)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'recargaMov',
          ),
        ),
      array(
        'name'=>'RecargaClaro',
        'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularClaro+$data->RecargaFonoClaro)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'recargaClaro',
          ),
        ),
      array(
        'name'=>'MontoDepositoOp',
        'value'=>'Yii::app()->format->formatDecimal($data->MontoDeposito)',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'montoDeposito',
          ),
        ),
      array(
        'header'=>'Detalle',
        'class'=>'CButtonColumn',
        'buttons'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
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
    'dataProvider'=>$model->disable(),
    'afterAjaxUpdate'=>'reinstallDatePicker2',
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
            'id'=>'datepicker_for_Fecha_oculta',
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
          ),
        ),
      array(
        'name'=>'CABINA_Id',
        'value'=>'$data->cABINA->Nombre',
        'type'=>'text',
        'filter'=>Cabina::getListCabinaInactivas(),
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          ),
        ),
      array(
        'name'=>'SaldoApMov',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'aperturaMov',
          ),
        ),
      array(
        'name'=>'SaldoApClaro',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'aperturaClaro',
          ),
        ),
      array(
        'name'=>'Trafico',
        'value'=>'Yii::app()->format->formatDecimal($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'trafico',
          ),
        ), 
      array(
        'name'=>'RecargaMovistar',
        'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularMov+$data->RecargaFonoYaMov)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'recargaMov',
          ),
        ),
      array(
        'name'=>'RecargaClaro',
        'value'=>'Yii::app()->format->formatDecimal($data->RecargaCelularClaro+$data->RecargaFonoClaro)',
        'type'=>'text',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'recargaClaro',
          ),
        ),
      array(
        'name'=>'MontoDepositoOp',
        'value'=>'$data->MontoDeposito',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'montoDeposito',
          ),
        ),
      array(
        'header'=>'Detalle',
        'class'=>'CButtonColumn',
        'buttons'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
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
           <th style="background:#00992B; color:white;">Fecha</th>
            <th style="background:#00992B; color:white;">Cabina</th>
            <th id="vistaAdmin1" style="background:#00992B; color:white;"></th>
            <th id="vistaAdmin2" style="background:#00992B; color:white;"></th>
            <th id="totalTrafico" style="background:#00992B; color:white;"></th>
            <th id="totalRecargaMov" style="background:#00992B; color:white;"></th>
            <th id="totalRecargaClaro" style="background:#00992B; color:white;"></th>
            <th id="totalMontoDeposito" style="background:#00992B; color:white;"></th>
        </tr>
    </thead>
    <tbody>
      <tr class="odd">
        <td id="totalFecha"></td>
        <td id="todas">Todas</td>
        <td id="vistaAdmin1"></td>
        <td id="vistaAdmin2"></td>
        <td id="totalTrafico"></td>
        <td id="totalRecargaMov"></td>
        <td id="totalRecargaClaro"></td>
        <td id="totalMontoDeposito"></td>
      </tr>
    </tbody>
</table>
</div>