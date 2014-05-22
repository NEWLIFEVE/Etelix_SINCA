<?php
$tipoUsuario = Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);

/*$this->menu=array(
//	array('label'=>'Create Balance', 'url'=>array('create')),
	array('label'=>'Administrar Balance', 'url'=>array('admin')),
        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
);*/
?>

<h1>Cargar Archivos FullCarga</h1>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));*/ ?>

<?php 

$this->widget('ext.EAjaxUpload.EAjaxUpload',
array(
        'id'=>'uploadFile',
        'config'=>array(
               'action'=>Yii::app()->createUrl('balance/upload'),
               'allowedExtensions'=>array("xls","xlsx"),//array("jpg","jpeg","gif","exe","mov" and etc...
               'sizeLimit'=>1*1024*1024,// maximum file size in bytes
               //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
               'onComplete'=>"js:function(id, fileName, responseJSON){ alert(fileName); }",
               'messages'=>array(
                                 'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                 'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                 'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                 'emptyError'=>"{file} is empty, please select files again without it.",
                                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                ),
               'showMessage'=>"js:function(message){ alert(message); }"
              )
)); 


echo CHtml::beginForm('','post',array('name'=>'monto'));
echo "<span class='buttons'>".CHTML::button('Grabar en Base de Datos',  array('submit' => Yii::app()->createUrl("balance/UploadFullCarga")))."</span>";
echo CHtml::endForm();



echo '<br><br><br><br><br>';
echo '<h1>Generar Trafico de Captura</h1>
<div class="form">';



$form=$this->beginWidget('CActiveForm', array(
	'id'=>'traficoCaptura-form',
	'enableAjaxValidation'=>true,
        'action'=>Yii::app()->createUrl('/Detalleingreso/CreateTraficoCaptura'),
    )
);

?>

<div class="row">
    
<?php  echo $form->labelEx($model,'FechaMes',array('label'=>'Fecha')); ?>
<?php   $this->widget('zii.widgets.jui.CJuiDatePicker', 
            array(
            'language' => 'es', 
            'model' => $model,
            'attribute'=>'FechaMes',
            'options' => array(
            'changeMonth' => 'true',//para poder cambiar mes
            'changeYear' => 'true',//para poder cambiar año
            'showButtonPanel' => 'false', 
            'constrainInput' => 'false',
            'showAnim' => 'show',
//            'minDate'=>'-7D', //fecha minima
            'maxDate'=> "-1D", //fecha maxima
               
             ),
            'htmlOptions'=>array('readonly'=>'readonly','id'=>'FechaTrafico', ),
         ));                                                            ?>
 <?php   echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); ?>
 <?php   echo $form->error($model,'FechaMes',array('readonly'=>'readonly')); ?>
                 
    
</div>

<?php   

echo "<span class='buttons'>".CHtml::submitButton('Generar Trafico de Captura')."</span>";

$this->endWidget();

echo '</div>';

?>

