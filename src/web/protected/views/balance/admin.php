<?php
/* @var $this BalanceController */
/* @var $model Balance */
Yii::import('webroot.protected.controllers.CabinaController');

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>
<h1>
  <span class="enviar">
    Administrar Balances
  </span>
  <span id="botones">
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail.png" class="botonCorreo" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/print.png' class='printButton'/>

    <?php 
      if($tipoUsuario>1)
      {
          echo "<button id='cambio'>Inactivas</button>";
      }
      ?>
  </span>
</h1>

<?php
  echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail/'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
  echo CHtml::textField('html','',array('id'=>'html','style'=>'display:none'));
  echo CHtml::textField('vista','admin',array('id'=>'vista','style'=>'display:none'));
  echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
  echo CHtml::textField('asunto','Reporte de Administrar Balances Solicitado',array('id'=>'asunto','style'=>'display:none'));
  echo CHtml::endForm();
  echo "<form action='";?><?php echo Yii::app()->request->baseUrl; ?><?php echo"/ficheroExcel.php?nombre=Balances%20Cabinas' method='post' target='_blank' id='FormularioExportacion'>
          <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
        </form>";
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
        'name'=>'Fecha',
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
        'value'=>'$data->MontoDeposito',
        'htmlOptions'=>array(
          'style'=>'text-align: center;',
          'id'=>'montoDeposito',
          ),
        ),
      array(
        'header'=>'Detalle',
        'class'=>'CButtonColumn',
        'template'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
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
    'afterAjaxUpdate'=>'reinstallDatePicker',
    'filter'=>$model,
    'columns'=>array(
      array(
        'name'=>'Fecha',
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
          ),
        ),
      array(
        'name'=>'CABINA_Id',
        'value'=>'$data->cABINA->Nombre',
        'type'=>'text',
        'filter'=>Cabina::getListCabina(),
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
        'template'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo),
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
?>
<div id="totales" class="grid-view">
<table class="items">
    <thead>
        <tr>
           <th style="background:rgba(64,152,8,1); color:white;">Fecha</th>
            <th style="background:rgba(64,152,8,1); color:white;">Cabina</th>
            <th id="vistaAdmin1" style="background:rgba(64,152,8,1); color:white;"></th>
            <th id="vistaAdmin2" style="background:rgba(64,152,8,1); color:white;"></th>
            <th id="totalTrafico" style="background:rgba(64,152,8,1); color:white;"></th>
            <th id="totalRecargaMov" style="background:rgba(64,152,8,1); color:white;"></th>
            <th id="totalRecargaClaro" style="background:rgba(64,152,8,1); color:white;"></th>
            <th id="totalMontoDeposito" style="background:rgba(64,152,8,1); color:white;"></th>
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