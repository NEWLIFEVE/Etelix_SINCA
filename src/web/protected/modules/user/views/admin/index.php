<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<head>
<script language="javascript">
    $(document).ready(function()
    {
        $(".botonExcel").click(function(event)
        {
            $(".filters").remove();
            $(".button-column").remove();
            $("#datos_a_enviar").val( $("<div>").append( $(".items").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
            $("li.selected a").click();
        });

        $(".botonCorreo").click(function(event) {
            $(".filters").remove();
            $(".button-column").remove();
            //var html = $(".enviar").clone().html()+ "<br/>" +$("table.items" ).clone().html();
            var html = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" +$("table.items" ).html();
            $("#html").val(html);
            $("#FormularioCorreo").submit();
            $("li.selected a").click();
            alert('Correo Enviado');
        });
        
        $('.printButton').click(function(){
            $(".filters").remove();
            var printVersion =$(".grid-view" ).clone();
            $("li.selected a").click();
            // Eliminamos los elementos indeseables a trav�s de jQuery. En este caso s�lo uno.
            printVersion.children(".pager").remove();
            // Creamos el contenido del documento que se va a imprimir.
            //var printContent = $(".enviar").html()+ "<br/>" + printVersion.html(); 
            var printContent = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" + printVersion.html();  
            // Establecemos la nueva ventana.
            var windowUrl = 'about:blank'; 
            var createdAt = new Date(); 
            var windowName = 'printScreen' + createdAt.getTime(); 
            var printWindow = window.open(windowUrl, windowName, 'resizable=0,scrollbars=0,left=500,top=000,width=868'); 
            printWindow.document.write(printContent); 
            printWindow.document.close(); 
            // Establecemos el foco.
            printWindow.focus(); 
            // Lanzamos la impresi�n.
            printWindow.print();   
        });

    });
</script>
</head>
<!--<h1><?php //echo UserModule::t("Manage Users"); ?></h1>-->
<h1>
    <span class="enviar">
        Administrar Usuarios
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/print.png' class='printButton' />
    </span>
</h1>
<p><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>
<?php
echo CHtml::beginForm(Yii::app()->createUrl('users/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none')); //, array('hidden'=>'hidden')
echo CHtml::textField('vista', 'admin', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte Administrar Usuarios Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Administrar_Usuarios" method="post" target="_blank" id="FormularioExportacion">

<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<?php //echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="enviarTabla">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
        'htmlOptions'=>array(
          'rel'=>'total',
          ),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>