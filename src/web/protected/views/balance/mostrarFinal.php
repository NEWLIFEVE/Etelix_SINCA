<?php
/* @var $this BalanceController */
/* @var $model Balance */

Yii::import('webroot.protected.controllers.CabinaController');

//$this->breadcrumbs=array(
//	'Balances'=>array('index'),
//        'id'=>$model->Id,
//);
Yii::import('webroot.protected.controllers.BancoController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#balance-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<head>
    <script language="javascript">
    $(document).ready(function() {
        $(".botonExcel").click(function(event) {
            $("#datos_a_enviar").val( $("<div>").append( $("table.items").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
        });

        $(".botonCorreo").click(function(event) {
              var html = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" +$(".enviarTabla").html();
              $("#html").val(html);
              $("#FormularioCorreo").submit();
              alert('Correo Enviado');
        });

        $('.printButton').click(function(){

            var printVersion = $(".enviarTabla" ).clone();
            // Eliminamos los elementos indeseables a trav�s de jQuery. En este caso s�lo uno.
            //printVersion.children(".pager").remove();

            // Creamos el contenido del documento que se va a imprimir.
            var printContent = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" + printVersion.html(); 
            // Establecemos la nueva ventana.
            var windowUrl = 'about:blank'; 
            var createdAt = new Date(); 
            var windowName = 'printScreen' + createdAt.getTime(); 
            var printWindow = window.open(windowUrl, windowName, 'resizable=1,scrollbars=1,left=500,top=000,width=868'); 
            printWindow.document.write(printContent); 

            printWindow.document.close(); 

            // Establecemos el foco.
            printWindow.focus(); 

            // Lanzamos la impresi�n.
            printWindow.print();   
        });

        $("tr.resaltado th").css('background-color', '#C9F');
        $("tr.resaltado td").css('background-color', '#C9F');
        $("div#print_button").click(function(){
        $("div#imprimir").printArea([options]);
        });

    });
    </script>
</head>

<h1>
    <span class="enviar">
        Resultados de Verificar Depositos Bancarios
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/print.png' class='printButton' />
    </span>
</h1>

<!--<p>
Puede ingresar de manera opcional operadores de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al principio de cada busqueda para indicar como deber ser realizada la busqueda.
</p>-->

<?php //echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search_mostrarFinal',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php
    echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
    echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
    echo CHtml::textField('vista','mostrarFinal',array('id'=>'vista','style'=>'display:none'));
    echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
    echo CHtml::textField('asunto','Resultados de Verificar Depositos Bancarios Solicitado',array('id'=>'asunto','style'=>'display:none'));
    echo CHtml::endForm();
?>

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Ciclo_Ingresos" method="post" target="_blank" id="FormularioExportacion">

<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<div class="enviarTabla">
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'balanceMostrarFinal',
	'dataProvider'=>$model->searchEs('mostrarFinal',$_GET['idBalancesActualizados']),
	'columns'=>array(
		'Fecha',
		array(
			'name'=>'CABINA_Id',
			'value'=>'$data->cABINA->Nombre',
			'type'=>'text',
			),
             array(
            'name'=>'TotalVentas',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios
                      )',
            'type'=>'text',
            ),
		'MontoDeposito',
		'NumRefDeposito',
		'MontoBanco',
		array(
			'name' => 'DiferencialBancario',
			'value' => 'Yii::app()->format->formatDecimal($data->MontoBanco-Yii::app()->format->formatDecimal(
                                    $data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios))',
			'type' => 'text',
			'htmlOptions'=>array(
				'style'=>'text-align: center;',
				'class'=>'dif',
				'name'=>'dif',
				),
			),
			array(
				'name' => 'ConciliacionBancaria',
				'value' => '$data->MontoBanco-Yii::app()->format->formatDecimal(
                                            $data->MontoDeposito
                                            )',
				'type' => 'text',
				'htmlOptions'=>array(
					'style'=>'text-align: center;',
					'class'=>'dif',
					'name'=>'dif',
					),
				),
			),
	));
?>
</div>