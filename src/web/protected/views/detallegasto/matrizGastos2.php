<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=NULL;
if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesion',NULL);
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesion',$_POST["formFecha"]."-01");
        $mes=Yii::app()->user->getState('mesSesion');
        $sql="SELECT d.FechaMes,c.nombre as Cabina, t.Nombre ,d.Monto, d.status 
              FROM detallegasto d, cabina c, tipogasto t 
              WHERE d.FechaMes=$mes AND d.TIPOGASTO_Id=t.id AND d.CABINA_Id=c.id
              ORDER BY c.nombre,t.nombre";
        $model = Detallegasto::model()->findAllBySql($sql);
        
    }
    elseif(strlen(Yii::app()->user->getState('mesSesion')) && Yii::app()->user->getState('mesSesion')!="")
    {
        $mes = Yii::app()->user->getState('mesSesion');
    } 
}

$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetallegastoController::controlAcceso($tipoUsuario);

?>
<h1>
    <span class="enviar">
        Matriz de Gastos 
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes) : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detallegasto/estadoGastos') ?>">
    <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
        <div style="width: 40em;">
            <div class="buttons" style="float: right;">
                <input type="submit" name="boton" value="Actualizar"/>
                <input type="submit" name="boton" value="Resetear Valores"/>
            </div>
            <label for="dateMonth">
                Seleccione un mes:
            </label>
            <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>   
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
<?php if ($model !== null) { ?>
<table id="tabla" class="tabla2 items" border="1" style="background-color:#F2F4F2; border-collapse:collapse;width:auto;">
    <thead>
        <th style='font-weight:bold; background: #1967B2' ><span style="background: url("<?php echo Yii::app()->theme->baseUrl; ?>/img/footer_bg.gif&quot;) repeat scroll 0 0 #2D2D2D;"><img style="padding-left: 24px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Activity-w.png" /></span></td>
        <th style='width: 120px; font-weight:bold; background: #1967B2;' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'><?php //echo $fechaActual.' '; ?>Inicio Jornada</h3></td>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Chimbote</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Etelix-Peru</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Huancayo</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Iquitos 01</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Iquitos 03</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Piura</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Pucallpa</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Pucallpa</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Surquillo</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Tarapoto</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Trujillo 01</h3></th>
        <th style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Trujillo 03</h3></th>
</thead>
</table>
<?php }?>
<?php
//echo "/ficheroExcel.php?nombre=Estado_Gastos_".date("Y-m-d");
//echo $mes != NULL ? "_". Utility::monthName($mes) : "";
//echo "' name='excel' method='post' target='_blank' id='FormularioExportacion'>
//        <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
//     </form>";
//echo CHtml::beginForm(Yii::app()->createUrl('detallegasto/updateGasto'), 'post', array('name' => 'actualizar', 'id' => 'Form'));
//$this->widget('zii.widgets.grid.CGridView',array(
//    'id'=>'estadogasto-grid',
//    'htmlOptions'=>array(
//        'class'=>'grid-view ReporteBrighstar',
//        'rel'=>'total',
//        'name'=>'vista'
//        ),
//    'dataProvider'=>$model->search('estadoDeGastos',$cabina,$mes,$status),
//    'afterAjaxUpdate'=>'reinstallDatePicker',
//    'filter'=>$model,
//    'columns'=>array(
//        array(
//            'name'=>'FechaMes',
//            'value'=>'Utility::monthName($data->FechaMes)',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center;',
//                'size'=>'5',
//                ),         
//            ),
//        array(
//            'name'=>'CABINA_Id',
//            'value'=>'$data->cABINA->Nombre',
//            'type'=>'text',
//            'filter'=>Cabina::getListCabina(),
//            'htmlOptions'=>array(
//                'style'=>'text-align: center;',
//                'size'=>'5'
//                )
//            ),
//        array(
//            'name'=>'TIPOGASTO_Id',
//            'value'=>'$data->tIPOGASTO->Nombre',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                'width'=>'80px'
//                ),
//            'filter'=>Tipogasto::getListTipoGasto()
//            ),
//        array(
//            'name'=>'FechaVenc',
//            'value'=>'Utility::cambiarFormatoFecha($data->FechaVenc)',
//            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
//                'model'=>$model,
//                'attribute'=>'FechaVenc',
//                'language'=>'ja',
//                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
//                'htmlOptions'=>array(
//                    'id'=>'datepicker_for_FechaVenc',
//                    'size'=>'10'
//                    ),
//                'defaultOptions'=>array(
//                    'showOn'=>'focus',
//                    'dateFormat'=>'yy-mm-dd',
//                    'showOtherMonths'=>true,
//                    'selectOtherMonths'=>true,
//                    'changeMonth'=>true,
//                    'changeYear'=>true,
//                    'showButtonPanel'=>true
//                    )
//                ),true),
//            'htmlOptions'=>array(
//                'style'=>'text-align: center;',
//                )
//            ),
//        array(
//            'name'=>'Monto',
//            'value'=>'$data->Monto',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                'width'=>'80px',
//                'id'=>'monto'
//                )
//            ),
//        array(
//            'name'=>'moneda',
//            'value'=>'Detallegasto::monedaGasto($data->moneda)',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                'width'=>'80px',
//                'id'=>'moneda'
//                )
//            ),
//        array(
//            'name'=>'beneficiario',
//            'value'=>'$data->beneficiario',
//            'type'=>'text',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                'width'=>'50px',
//                )
//            ),
//        array(
//            'name'=>'OrdenDePago',
//            'type'=>'raw',
//            'value'=>'CHtml::radioButton("status_$data->Id",Detallegasto::compareIsStatusFromGasto($data->Id, 1),array("value"=>1,"class"=>"OrdenDePago"))',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                "width"=>"50px"
//                )
//            ),
//        array(
//            'name'=>'Aprobada',
//            'type'=>'raw',
//            'value'=>'CHtml::radioButton("status_$data->Id",Detallegasto::compareIsStatusFromGasto($data->Id, 2),array("value"=>2,"class"=>"Aprobada"))',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                "width"=>"50px"
//                )
//            ),
//        array(
//            'name'=>'Pagada',
//            'type'=>'raw',
//            'value'=>'CHtml::radioButton("status_$data->Id",Detallegasto::compareIsStatusFromGasto($data->Id, 3),array("value"=>"3","class"=>"Pagada"))',
//            'htmlOptions'=>array(
//                'style'=>'text-align: center',
//                "width"=>"50px"
//                )
//            ),
//        array(
//            'name'=>'TransferenciaPago',
//            'type'=>'raw',
//            'value'=>'CHtml::textField("NumeroTransferencia_$data->Id",$data->TransferenciaPago,array("style"=>"width:65px;","disabled"=>"disabled"))',
//            'htmlOptions'=>array(
//                "width"=>"65px"
//            )
//        ),
//        array(
//            'name'=>'FechaTransf',
//            'type'=>'raw',
//            'value'=>'CHtml::textField("FechaTransferencia_$data->Id",Utility::cambiarFormatoFecha($data->FechaTransf),array("class"=>"datepicker","style"=>"width:65px;","disabled"=>"disabled"))',
//            'htmlOptions'=>array(
//                "width"=>"65px"
//            )
//        ),
//        array(
//            'name'=>'CUENTA_Id',
//            'type'=>'raw',
//            'value'=>'CHtml::dropDownList("Cuenta_$data->Id", $data->CUENTA_Id, Cuenta::getListCuentaTipo($data->moneda), array("style"=>"width:50px;","disabled"=>"disabled"))',
//            'htmlOptions'=>array(
//                "width"=>"50px"
//            )
//        ),
//        array(
//            'header'=>'Detalle',
//            'class'=>'CButtonColumn',
//            'template'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo)
//        )
//    )
//)
//);
?>
