<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m-d");
$cabina=NULL;
$status=0;
if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesion',date("Y-m-d"));
    Yii::app()->user->setState('cabinaSesion',NULL);
    Yii::app()->user->setState('rbtnStatusSesion',0);
    
    $mes=Yii::app()->user->getState('mesSesion');
    $cabina = Yii::app()->user->getState('cabinaSesion');
    $status = Yii::app()->user->getState('rbtnStatusSesion');
    $estatus='(Abierto)';
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesion',$_POST["formFecha"]);
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
        $estatus='(Abierto)';
    }
    if($status==2)
    {
        $estatus='(Cerrado)';
    }
}
$año = date("Y", strtotime($mes));
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NovedadController::controlAcceso($tipoUsuario);
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
        Estado de Fallas
        <?php echo $cabina != NULL ? Cabina::getNombreCabina2($cabina).' - ' : ""; ?>
        <?php echo date("d/m/Y",strtotime($mes)); ?>
        <?php echo $status != NULL ? " - ".$estatus : ""; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButton' />
    </span>
</h1>
<form name="Novedades" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('novedad/estadoNovedades') ?>">
    <div id="Contenedor">
        <div style="float: left;padding-top: 1.2%;padding-left: 4%;">
            <div>
                <label for="datepicker">
                    Seleccione una Cabina:
                </label>
            </div>
            <div>
                <?php echo CHtml::dropDownList('formCabina', '', Cabina::getListCabinaResto(), array('empty' => 'Seleccionar...')) ?>
            </div>
        </div>
        <div style="float: left;width: 19%;padding-top: 1%;padding-left: 4%;">
            <div>
                <label for="dateMonth2">
                    Seleccione un Día:
                </label>
            </div>
            <div>
                <?php
                
                $this->widget('zii.widgets.jui.CJuiDatePicker', 
                                array(
                                'language' => 'es', 
                                'model' =>$model,
                                //'value' =>date('d/m/Y',strtotime($model->admission_date)),
                                'attribute'=>'Fecha', 
                                'options' => array(
                                'dateFormat'=>'yy-mm-dd',
                                'changeMonth' => 'true',//para poder cambiar mes
                                'changeYear' => 'true',//para poder cambiar año
                                'showButtonPanel' => 'false', 
                                'constrainInput' => 'false',
                                'showAnim' => 'show',
                                //'minDate'=>'-30D', //fecha minima
                                'maxDate'=> "-0D", //fecha maxima
                                 ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'readonly',
                                        'name'=>'formFecha',
                                        ),
                            ));
                
                ?>
            </div>
        </div>
        <div style="float: left;padding-top: 1.2%;">
            <div>
                <label for="datepicker">
                    Seleccione un Estatus:
                </label>
            </div>
            <div>
                <?php echo CHtml::dropDownList('rbtnStatus', '', NovedadStatus::getListStatus(), array('empty' => 'Seleccionar...')) ?>
            </div>
        </div>
        <div class="buttons" style="float: left;margin-left: 54em;">
            <input type="submit" name="boton" value="Actualizar"/>
            <input type="submit" name="boton" value="Resetear Valores"/>
        </div>
        <br><br><br>
    </div>
    
</form>
<div id="fecha" style="display: none;"><?php echo $mes;?></div>
<div id="cabina2" style="display: none;"><?php echo $cabina != NULL ? Cabina::getNombreCabina2($cabina) : "";?></div>
<div id="status" style="display: none;"><?php echo $status != NULL ? $status : "";?></div>

<?php 

    //DATALIST DE DESTINO (EXTRAIDO DE SORI)
    echo DestinationInt::getListDestination();

?>


<?php
echo Yii::app()->request->baseUrl;
?>
<?php

echo CHtml::beginForm(Yii::app()->createUrl('novedad/UpdateNovedad'), 'post', array('name' => 'actualizar', 'id' => 'Form'));
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'estadonovedad-grid',
    'updateSelector' => '{sort}',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteDepositos',
        'rel'=>'total',
        'name'=>'vista'
        ),
    'dataProvider'=>$model->searchEs('estadoNovdad',$status,$mes,$cabina),
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
            'value'=>'Utility::cambiarFormatoFecha($data->Fecha)',
            'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'Fecha',
                'language'=>'es',
                'i18nScriptFile'=>'jquery.ui.datepicker-ja.js',
                'htmlOptions'=>array(
                    'id'=>'datepicker_for_Fecha',
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
            'name'=>'Cabina',
            'value'=>'Cabina::getNombreCabina(Yii::app()->getModule("user")->user($data->users_id)->CABINA_Id)',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'size'=>'5'
                )
        ),
        array(
            'name' => 'Falla',
            'value' => '$data->tIPONOVEDAD->Nombre',
            'filter' => Tiponovedad::getListNombreporStatus(1),
            'htmlOptions' => array(
                'style' => 'text-align: center;width:100px;',
                
            ),
        ),
        array(
            'name' => 'Locutorio',
            'value' => 'NovedadLocutorio::getLocutorioRow($data->Id)',
            'type' => 'text',
            //'filter' => Tiponovedad::getListNombre(),
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
        ),
        array(
            'name'=>'Destino',
            'type'=>'raw',
            'value'=>'CHtml::textField("Destino_$data->Id",DestinationInt::getNombre($data->DESTINO_Id),array("style"=>"width:200px;","list"=>"destino"))',
            'htmlOptions'=>array(
                "width"=>"65px"
            )
        ),
        array(
            'name'=>'Observaciones',
            'type'=>'raw',
            'value'=>'CHtml::textArea("Observaciones_$data->Id",$data->Observaciones,array("style"=>"width:200px;height: 50px;resize: none;"))',
            'htmlOptions'=>array(
                "width"=>"65px"
            )
        ),
        array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("status_$data->Id", $data->STATUS_Id, NovedadStatus::getListStatus(), array("style"=>"width:70px;","class"=>"Estatus"))',
            'filter' => NovedadStatus::getListStatus(),
            'htmlOptions'=>array(
                'style'=>'text-align: center',
                "width"=>"50px"
                )
            ),
        array(
            'header'=>'Detalle',
            'class'=>'CButtonColumn',
            'buttons'=>Utility::ver(Yii::app()->getModule('user')->user()->tipo)
        )
    )
)
        );
?>

<?php
echo "<span class='buttons'>";
echo CHTML::submitButton('Guardar en BD');
echo "</span>";
echo CHtml::endForm();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_Fecha').datepicker();
}
");
?>
