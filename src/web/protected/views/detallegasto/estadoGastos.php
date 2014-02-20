<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=NULL;
$cabina=NULL;
$status=NULL;
if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesion',NULL);
    Yii::app()->user->setState('cabinaSesion',NULL);
    Yii::app()->user->setState('rbtnStatusSesion',NULL);
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesion',$_POST["formFecha"]."-01");
        $mes=Yii::app()->user->getState('mesSesion');
    }
    elseif(strlen(Yii::app()->user->getState('mesSesion')) && Yii::app()->user->getState('mesSesion')!="")
    {
        $mes = Yii::app()->user->getState('mesSesion');
    }
    if(isset($_POST["formCabina"]) && $_POST["formCabina"] != "")
    {
        Yii::app()->user->setState('cabinaSesion',$_POST['formCabina']);
        $cabina = Yii::app()->user->getState('cabinaSesion');
    }
    elseif(strlen(Yii::app()->user->getState('cabinaSesion')) && Yii::app()->user->getState('cabinaSesion')!="")
    {
        $cabina = Yii::app()->user->getState('cabinaSesion');
    }
    if(isset($_POST["rbtnStatus"]) && $_POST["rbtnStatus"] != "")
    {
        Yii::app()->user->setState('rbtnStatusSesion',$_POST['rbtnStatus']);
        $status = Yii::app()->user->getState('rbtnStatusSesion');
    }
    elseif(strlen(Yii::app()->user->getState('rbtnStatusSesion')) && Yii::app()->user->getState('rbtnStatusSesion')!="")
    {
        $status = Yii::app()->user->getState('rbtnStatusSesion');
    }
    if((!isset($_GET['Detallegasto_page']) || $_GET['Detallegasto_page'] == "") && ((isset($_POST["formFecha"]) && $_POST["formFecha"]  != "") && (isset($_POST["formCabina"]) && $_POST["formCabina"] != "") && (!isset($_POST["rbtnStatus"]) || $_POST["rbtnStatus"] == "")))
    {
        Yii::app()->user->setState('rbtnStatusSesion','');
        $status = Yii::app()->user->getState('rbtnStatusSesion');
    }
    if($status==1)
    {
        $estatus='(orden de Pago)';
    }
    if($status==2)
    {
        $estatus='(aprobado)';
    }
    if($status==3)
    {
        $estatus='(pagado)';
    }
}

$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetallegastoController::controlAcceso($tipoUsuario);
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
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
    <span class="enviar">
        Estado de Gastos 
        <?php echo $cabina != NULL ? " - ". Cabina::getNombreCabina2($cabina) : ""; ?>
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes) : ""; ?>
        <?php echo $status != NULL ? " - ".$estatus : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detallegasto/estadoGastos') ?>">
    <div>
        <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
            <div>
                <label for="datepicker">
                    Seleccione una cabina:
                </label>
            </div>
            <div>
                <?php echo CHtml::dropDownList('formCabina', '', Cabina::getListCabinaResto(), array('empty' => 'Seleccionar...')) ?>
            </div>
        </div>
        <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
            <div>
                <label for="dateMonth">
                    Seleccione un mes:
                </label>
            </div>
            <div>
                <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>
            </div>
        </div>
        <div class="buttons" style="float: left;width: 20%;padding-top: 3.5%;">
            <input type="submit" name="boton" value="Actualizar"/>
            <input type="submit" name="boton" value="Resetear Valores"/>
        </div>
    </div>
    <div style="display: block;">&nbsp;</div>
    <div>
        <div>
            <?php
            echo CHtml::label("Filtrar por estatus", "habilitarStatus");
            echo CHtml::checkBox("Status", FALSE, array("id" => "habilitarStatus"));
            ?>
        </div>
        <div style="padding: 1.5% 0 0 4%;">
            <?php
            echo CHtml::radioButtonList('rbtnStatus', '', array("1" => "Orden de pago", "2" => "Aprobada", "3" => "Pagada"), array('separator' => '&nbsp;&nbsp;', 'disabled' => 'disabled',
            ));
            ?>
        </div>
    </div>
</form>
<div style="display: block;">&nbsp;</div>
<?php
echo CHtml::beginForm(Yii::app()->createUrl('detallegasto/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo', 'style' => 'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style' => 'display:none'));
echo CHtml::textField('vista', 'estadoGastos', array('id' => 'vista', 'style' => 'display:none'));
echo CHtml::textField('correoUsuario', Yii::app()->getModule('user')->user()->email, array('id' => 'email', 'style' => 'display:none'));
echo CHtml::textField('asunto', 'Reporte de Estado de Gastos Solicitado', array('id' => 'asunto', 'style' => 'display:none'));
echo CHtml::endForm();
echo "<form action='";
?>
<?php
echo Yii::app()->request->baseUrl;
?>
<?php
echo "/ficheroExcel.php?nombre=Estado_Gastos_".date("Y-m-d");
echo $cabina != NULL ? "_" . Cabina::getNombreCabina2($cabina) : "";
echo $mes != NULL ? "_". Utility::monthName($mes) : "";
echo $status != NULL ? "_". $estatus : "";
echo "' name='excel' method='post' target='_blank' id='FormularioExportacion'>
        <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
     </form>";
echo CHtml::beginForm(Yii::app()->createUrl('detallegasto/updateGasto'), 'post', array('name' => 'actualizar', 'id' => 'Form'));
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'estadogasto-grid',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteBrighstar',
        'rel'=>'total',
        'name'=>'vista'
        ),
    'dataProvider'=>$model->search('estadoDeGastos',$cabina,$mes,$status),
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
            'name'=>'FechaMes',
            'value'=>'Utility::monthName($data->FechaMes)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'size'=>'5',
                ),         
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'size'=>'5'
                )
            ),
        array(
            'name'=>'TIPOGASTO_Id',
            'value'=>'$data->tIPOGASTO->Nombre',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px'
                ),
            'filter'=>Tipogasto::getListTipoGasto()
            ),
        array(
            'name'=>'FechaVenc',
            'value'=>'Utility::cambiarFormatoFecha($data->FechaVenc)',
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'FechaVenc',
                'language'=>'ja',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_FechaVenc',
                    'size'=>'10'
                    ),
                'defaultOptions'=>array(
                    'showOn'=>'focus',
                    'dateFormat'=>'yy-mm-dd',
                    'showOtherMonths'=>true,
                    'selectOtherMonths'=>true,
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'showButtonPanel'=>true
                    )
                ),true),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                )
            ),
        array(
            'name'=>'Monto',
            'value'=>'$data->Monto',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px',
                'id'=>'monto'
                )
            ),
        array(
            'name'=>'moneda',
            'value'=>'Detallegasto::monedaGasto($data->moneda)',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'80px',
                'id'=>'moneda'
                )
            ),
        array(
            'name'=>'beneficiario',
            'value'=>'$data->beneficiario',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                'width'=>'50px',
                )
            ),
        array(
            'name'=>'OrdenDePago',
            'type'=>'raw',
            'value'=>'CHtml::radioButton("status_$data->Id",Detallegasto::compareIsStatusFromGasto($data->Id, 1),array("value"=>1,"class"=>"OrdenDePago"))',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                "width"=>"50px"
                )
            ),
        array(
            'name'=>'Aprobada',
            'type'=>'raw',
            'value'=>'CHtml::radioButton("status_$data->Id",Detallegasto::compareIsStatusFromGasto($data->Id, 2),array("value"=>2,"class"=>"Aprobada"))',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                "width"=>"50px"
                )
            ),
        array(
            'name'=>'Pagada',
            'type'=>'raw',
            'value'=>'CHtml::radioButton("status_$data->Id",Detallegasto::compareIsStatusFromGasto($data->Id, 3),array("value"=>"3","class"=>"Pagada"))',
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                "width"=>"50px"
                )
            ),
        array(
            'name'=>'TransferenciaPago',
            'type'=>'raw',
            'value'=>'CHtml::textField("NumeroTransferencia_$data->Id",$data->TransferenciaPago,array("style"=>"width:65px;","disabled"=>"disabled"))',
            'htmlOptions'=>array(
                "width"=>"65px"
            )
        ),
        array(
            'name'=>'FechaTransf',
            'type'=>'raw',
            'value'=>'CHtml::textField("FechaTransferencia_$data->Id",Utility::cambiarFormatoFecha($data->FechaTransf),array("class"=>"datepicker","style"=>"width:65px;","disabled"=>"disabled"))',
            'htmlOptions'=>array(
                "width"=>"65px"
            )
        ),
        array(
            'name'=>'CUENTA_Id',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("Cuenta_$data->Id", $data->CUENTA_Id, Cuenta::getListCuentaTipo($data->moneda), array("style"=>"width:50px;","disabled"=>"disabled"))',
            'htmlOptions'=>array(
                "width"=>"50px"
            )
        ),
        array(
            'header'=>'Detalle',
            'class'=>'CButtonColumn',
            'template'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo)
        )
    )
)
);
?>
<div id="totales" class="grid-view totalMonto">
<table class="items">
    <thead>
        <tr>
            <th id="mensajeMonto">Total Monto</th>
            <th id="soles">Soles</th>
            <th id="dolares">Dolares</th>
        </tr>
    </thead>
    <tbody>
        <tr class="even">
            <td></td>
            <td id="soles"></td>
            <td id="dolares"></td>
        </tr>
    </tbody>
</table>
</div>
<?php
echo "<span class='buttons'>";
echo CHTML::submitButton('Guardar en BD');
echo "</span>";
echo CHtml::endForm();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_FechaMes').datepicker();
}
");
?>
