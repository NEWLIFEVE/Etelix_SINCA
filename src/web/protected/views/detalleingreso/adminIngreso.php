<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m").'-01';
$cabina=NULL;

if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesion',date("Y-m").'-01');
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
    
}
$año = date("Y", strtotime($mes));
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetalleingresoController::controlAcceso($tipoUsuario);

?>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
    <span class="enviar">
        Administracion de Ingresos 
        <?php echo $cabina != NULL ? " - ". Cabina::getNombreCabina2($cabina) : ""; ?>
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes).' '.$año : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detalleingreso/adminIngreso') ?>">
    <div id="Contenedor">
        <div style="float: left;padding-top: 1.2%;padding-left: 4%;">
            <div>
                <label for="datepicker">
                    Seleccione una cabina:
                </label>
            </div>
            <div>
                <?php echo CHtml::dropDownList('formCabina', '', Cabina::getListCabinaResto(), array('empty' => 'Seleccionar...')) ?>
            </div>
        </div>
        <div style="float: left;width: 19%;padding-top: 1%;padding-left: 4%;">
            <div>
                <label for="dateMonth">
                    Seleccione un mes:
                </label>
            </div>
            <div>
                <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>
            </div>
        </div>
        <div>
        </div>
        <div class="buttons" style="float: left;width: 300px;position: relative;top: 20px;">
            <input type="submit" name="boton" value="Actualizar"/>
            <input type="submit" name="boton" value="Resetear Valores"/>
        </div>
    </div>
</form>
<div id="fecha" style="display: none;"><?php echo date('Ym',strtotime($mes));?></div>
<div id="cabina2" style="display: none;"><?php echo $cabina != NULL ? Cabina::getNombreCabina2($cabina) : "";?></div>

<br><br><br>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detalleingreso-grid',
	'dataProvider'=>$model->search($cabina,$mes),
        'htmlOptions'=>array(
            'class'=>'grid-view ReporteDepositos',
            'rel'=>'total',
            'name'=>'vista'
        ),
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
                    'width'=>'80px',
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
                'name'=>'TIPOINGRESO_Id',
                'value'=>'$data->tIPOINGRESO->Nombre',
                'type'=>'text',
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                    'width'=>'100px'
                    ),
                'filter'=>  TipoIngresos::getListTipoGIngreso(),
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
                    'width'=>'50px',
                    'id'=>'moneda'
                    )
                ),
                'Descripcion',
                array(
                'name'=>'TransferenciaPago',
                'value'=>'$data->TransferenciaPago',
                'type'=>'text',
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                    'width'=>'100px',
                    'id'=>'TransferenciaPago'
                    )
                ),
                array(
                'name'=>'FechaTransf',
                'value'=>'$data->FechaTransf',
                'type'=>'text',
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                    'width'=>'100px',
                    'id'=>'FechaTransf'
                    )
                ),
		array(
                    'name'=>'CUENTA_Id',
                    'type'=>'raw',
                    'value'=>'$data->cUENTA->Nombre',
                    'htmlOptions'=>array(
                        "width"=>"50px"
                    )
                ),
		array(
                            'header' => 'Detalle',
                            'class'=>'CButtonColumn',
                            'buttons'=>array
                            (
                                'view' => array
                                (
                                    'label'=>'Ver Ingreso',
                                    'url'=>'Yii::app()->createUrl("detalleingreso/viewIngreso", array("id"=>$data->Id))',
                                    'imageUrl'=>Yii::app()->request->baseUrl."/themes/mattskitchen/img/view.png",
                                ),
                                'update' => array
                                (
                                    'label'=>'Actualizar Ingreso',
                                    'url'=>'Yii::app()->createUrl("detalleingreso/createIngreso", array("id"=>$data->Id))',
                                    'imageUrl'=>Yii::app()->request->baseUrl."/themes/mattskitchen/img/update.png",
                                ), 
                                'delete' => array
                                (
                                    'visible'=>'false',
                                ),
                            ),
                    ),
	),
)); ?>
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
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_FechaMes').datepicker();
}
");
?>
