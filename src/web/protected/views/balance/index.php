<?php
/* @var $this BalanceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Balances',
        $model->Id,
);?>

<script>
    $(document).ready(function() {

        //$("li.qq-upload-success span.qq-upload-file").change( window.location.href ='http://www.google.com/' );
              
                
        
        
        
//        function(busca, reemplaza) {
//                var aux = reemplaza.text("span.qq-upload-file")
//                busca.stopPropagation();
//                if(aux.length>0)
//                   window.location.href ='http://www.google.com/'; });
//                }
//        var aux = text($("ul.qq-upload-list"));
//            
//        if(aux.length>0)
//            window.location.href ='http://www.google.com/'; });
    })
</script>

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

<h1>Cargar Archivos</h1>

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
echo "<span class='buttons'>".CHTML::button('Grabar en Base de Datos',  array('submit' => Yii::app()->createUrl("balance/guardarExcelBD")))."</span>";
echo CHtml::endForm();
?>
