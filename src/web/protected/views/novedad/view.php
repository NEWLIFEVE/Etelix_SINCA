<?php
/* @var $this NovedadController */
/* @var $model Novedad */

$this->breadcrumbs = array(
    'Novedades' => array('index'),
    $model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu = NovedadController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        Detalle de Novedad/Falla #<?php echo $model->Id; ?>
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoDetail" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelDetail" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonDetail' />
    </span>
</h1>

<?php
echo CHtml::beginForm(Yii::app()->createUrl('novedad/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo', 'style' => 'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style' => 'display:none'));
echo CHtml::textField('vista', 'novedad/view/' . $model->Id, array('id' => 'vista', 'style' => 'display:none'));
echo CHtml::textField('correoUsuario', Yii::app()->getModule('user')->user()->email, array('id' => 'email', 'style' => 'display:none'));
echo CHtml::textField('asunto', 'Reporte Detalles de Novedad #' . $model->Id . ' Solicitado', array('id' => 'asunto', 'style' => 'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->
<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Detalles%20de%20Novedad" method="post" target="_blank" id="FormularioExportacion">
<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<div class="enviarTabla">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'Id',
            'Fecha',
            'Hora',
            array(
                'name' => 'TIPONOVEDAD_Id',
                'value' => $model->tIPONOVEDAD->Nombre,
            ),
            'Descripcion',
            'Num',
            //MUESTRA EL TELEFONO CON SU TIPO
            array(
                'name'=>'Tipo de Llamada',
                'value'=> NovedadTipotelefono::getTipoTelefonoRow($model->Id),
            ),
            //MUESTRA LOS PUESTOS
            array(
                'type'=>'raw',
                'name'=>'Puestos',
                'value'=>  NovedadLocutorio::getLocutorioRow($model->Id),
            ),
            array(
                'name' => 'users_id',
                'value' => $model->users->username,
            ),
            array(
                    'name'=>'Estatus',
                    'value'=> ($model->STATUS_Id == 1) ? 'Abierto' : 'Cerrado',
            ),
        ),
    ));
    ?>
</div>