<?php
set_time_limit(18000); 

$tipoUsuario = Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo;
$this->menu=DetalleingresoController::controlAccesoBalance($tipoUsuario);

/*$this->menu=array(
//	array('label'=>'Create Balance', 'url'=>array('create')),
	array('label'=>'Administrar Balance', 'url'=>array('admin')),
        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
);*/
?>

<h1>Cargar Archivos FullCarga</h1>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<?php 


//FULLCARGA

$this->widget('ext.EAjaxUpload.EAjaxUpload',
array(
        'id'=>'uploadFile',
        'config'=>array(
               'action'=>Yii::app()->createUrl('detalleingreso/upload'),
               'allowedExtensions'=>array("xls","xlsx"),//array("jpg","jpeg","gif","exe","mov" and etc...
               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
               //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
               'onComplete'=>"js:function(id, fileName, responseJSON){ alert(fileName); }",
               'messages'=>array(
                                 'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                 'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                 'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                 'emptyError'=>"{file} is empty, please select files again without it.",
                                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                ),
               'showMessage'=>"js:messageLoading('Guardando Ingresos...','yt0')"
              )
)); 


echo CHtml::beginForm('','post',array('name'=>'monto','id'=>'UpdateFile'));
echo '<input type="hidden" name="UpdateFile[Valor]">';
echo "<span class='buttons'>".CHTML::button('Grabar en Base de Datos',  array('submit' => Yii::app()->createUrl("detalleingreso/UploadFullCarga")))."</span>";
echo CHtml::endForm();

if(isset($_SESSION['list'][0])){
    echo '<br><br>';
    echo 'Registros de FullCarga Guardados: '.$_SESSION['list'][0];
    unset($_SESSION['list'][0]);
} 



//CAPTURA

//echo '<br><br><br><br><br>';
//echo '<h1>Cargar Archivo de Captura</h1>';


//$this->widget('ext.EAjaxUpload.EAjaxUpload',
//array(
//        'id'=>'uploadFileCaptura',
//        'config'=>array(
//               'action'=>Yii::app()->createUrl('detalleingreso/upload'),
//               'allowedExtensions'=>array("xls","xlsx"),//array("jpg","jpeg","gif","exe","mov" and etc...
//               'sizeLimit'=>1*1024*1024,// maximum file size in bytes
//               //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
//               'onComplete'=>"js:function(id, fileName, responseJSON){ alert(fileName); }",
//               'messages'=>array(
//                                 'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
//                                 'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
//                                 'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
//                                 'emptyError'=>"{file} is empty, please select files again without it.",
//                                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
//                                ),
//               'showMessage'=>"js:function(message){ alert(message); }"
//              )
//)); 
//
//
//echo CHtml::beginForm('','post',array('name'=>'monto','id'=>'UpdateFileCaptura'));
//echo '<input type="hidden" name="UpdateFileCaptura[Valor]">';
//echo "<span class='buttons'>".CHTML::button('Grabar en Base de Datos',  array('submit' => Yii::app()->createUrl("detalleingreso/UploadCaptura")))."</span>";
//echo CHtml::endForm();
//
//if(isset($_SESSION['regintrosC'])){
//    echo '<br><br>';
//    echo 'Registros de Captura Guardados: '.$_SESSION['regintrosC'];
//    unset($_SESSION['regintrosC']);
//} 

echo '<br><br><br><br><br>';

echo '<h1>Generar Trafico de Captura desde SORI</h1>
<div class="form">';

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'traficoCaptura-form',
	'enableAjaxValidation'=>true,
        'action'=>Yii::app()->createUrl('/Detalleingreso/CreateTraficoCaptura'),
    )
);

?>

<table width="200" border="1" id="dateTraficoCaptura">
  <tr>
    <td>

<div class="row" id="FechaInicioCaptura" style="width: 50%;float: left;">
    
    <?php echo $form->labelEx($model,'FechaInicioCaptura',array('label'=>'Fecha Inicio')); ?>
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
                array(
                'language' => 'es', 
                'model' => $model,
                'attribute'=>'FechaInicioCaptura',
                'options' => array(
                'changeMonth' => 'true',//para poder cambiar mes
                'changeYear' => 'true',//para poder cambiar año
                'showButtonPanel' => 'false', 
                'constrainInput' => 'false',
                'showAnim' => 'show',
//                'minDate'=>'-7D', //fecha minima
                'maxDate'=> "-1D", //fecha maxima

                 ),
                'htmlOptions'=>array('readonly'=>'readonly','id'=>'Inicio','class'=>'Fecha',  ),
            ));   

    ?>
     <?php echo CHtml::label('', 'diaSemana',array('id'=>'diaSemanaInicio','style'=>'color:forestgreen','class'=>'diaSemanaInicio', )); ?>
     <?php echo $form->error($model,'FechaInicioCaptura',array('readonly'=>'readonly')); ?>
                 
    
</div>
        
<div class="row" id="FechaFinalCaptura" style="width: 50%;float: left;">
    
    <?php echo $form->checkBox($model,'Vereficar',array('id'=>'checkFechaFin','style'=>'float:left;margin-top:28px;margin-right:15px;')); ?>
    
    <?php echo $form->labelEx($model,'FechaFinCaptura',array('label'=>'Fecha Final')); ?>
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
                array(
                'language' => 'es', 
                'model' => $model,
                'attribute'=>'FechaFinCaptura',
                'options' => array(
                'changeMonth' => 'true',//para poder cambiar mes
                'changeYear' => 'true',//para poder cambiar año
                'showButtonPanel' => 'false', 
                'constrainInput' => 'false',
                'showAnim' => 'show',
//                'minDate'=>'-7D', //fecha minima
                'maxDate'=> "-1D", //fecha maxima

                 ),
                'htmlOptions'=>array('readonly'=>'readonly','id'=>'Fin','class'=>'Fecha','disabled'=>'disabled'),
            ));   

    ?>
     <?php echo CHtml::label('', 'diaSemana',array('id'=>'diaSemanaFin','style'=>'color:forestgreen;margin-left:30px;','class'=>'diaSemanaFin',)); ?>
     <?php echo $form->error($model,'FechaFinCaptura',array('readonly'=>'readonly')); ?>
                 
    
</div>        
        
    </td>
  </tr>   
</table>        

<?php   

echo "<span class='buttons'>".CHtml::submitButton('Generar Trafico de Captura',array('id'=>'submitTrafico'))."</span>";

$this->endWidget();

echo '</div>';


echo '<br><br><br><br><br>';

//echo '<h1>Generar Costos de Llamadas desde SORI</h1>
//<div class="form">';
//
//$form=$this->beginWidget('CActiveForm', array(
//	'id'=>'costoCaptura-form',
//	'enableAjaxValidation'=>true,
//        'action'=>Yii::app()->createUrl('/Detalleingreso/CreateCostoLlamadas'),
//    )
//);

?>

<!--<table width="200" border="1" id="dateCostoCaptura">
  <tr>
    <td>

<div class="row">-->
    
<?php // echo $form->labelEx($model,'FechaMes',array('label'=>'Fecha')); ?>
<?php // $this->widget('zii.widgets.jui.CJuiDatePicker', 
//            array(
//            'language' => 'es', 
//            'model' => $model,
//            'attribute'=>'FechaMes',
//            'options' => array(
//            'changeMonth' => 'true',//para poder cambiar mes
//            'changeYear' => 'true',//para poder cambiar año
//            'showButtonPanel' => 'false', 
//            'constrainInput' => 'false',
//            'showAnim' => 'show',
//            'minDate'=>'-7D', //fecha minima
//            'maxDate'=> "-1D", //fecha maxima
//               
//             ),
//            'htmlOptions'=>array('readonly'=>'readonly','id'=>'FechaCosto', ),
//        ));                                                            ?>
 <?php // echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana2','style'=>'color:forestgreen')); ?>
 <?php // echo $form->error($model,'FechaMes',array('readonly'=>'readonly')); ?>
                 
    
<!--</div>
        
    </td>
  </tr>   
</table>        -->

<?php   

//echo "<span class='buttons'>".CHtml::submitButton('Generar Costo de Llamadas',array('id'=>'submitTrafico'))."</span>";
//
//$this->endWidget();
//
//echo '</div>';

?>

