<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?><head>
 <script>
       function formatDate(dateValue) { 
         var fecha = dateValue.toString();
         return fecha[3]+fecha[4]+fecha[2]+fecha[0]+fecha[1]+fecha[5]+fecha[6]+fecha[7]+fecha[8]+fecha[9];
     }
    $(document).change( function(){
        var fecha = formatDate($('#Balance_Fecha').val());
        $("#diaSemana").text(["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"][new Date(fecha).getDay()]); 
    });
  </script>
</head>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'balance-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'beforeValidate'=>"js:function(form) {
            confirm('".SiteController::mensajesConfirm(1)."')
            return true;
        }",
        )
    )
); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="200" border="1" id="dateBalance">
  <tr>
    <td>	<div class="row" >
		<?php echo $form->labelEx($model,'FechaBalance'); ?>
		<?php // echo $form->textField($model,'Fecha'); ?>
                            <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', 
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
                    'minDate'=>'-7D', //fecha minima
                    'maxDate'=> "-1D", //fecha maxima
                     ),
                    'htmlOptions'=>array('readonly'=>'readonly','style'=>'float: left',),
                )); 
                    echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                ?>
		<?php echo $form->error($model,'FechaMes',array('readonly'=>'readonly')); ?>
	</div></td>

  </tr>   
</table>


<h2>LLAMADAS</h2>
<table width="200" border="1">

<?php  
        $movistar = TipoIngresos::model()->findAllBySql("SELECT t.Nombre 
                                                        FROM tipo_ingresos as t
                                                        WHERE t.COMPANIA_Id = 5 AND t.Clase = 1;");
        foreach ($movistar as $key => $value) {
            
            if($key%2==0){
?>
                <tr>
                <td>  	
                    <label for="Detalleingreso_'+arrayServicios[i]+'"><?php echo Detalleingreso::changeName($value->Nombre);?></label>
                    <input id="Detalle_<?php echo $value->Nombre;?>" name="Detalle[<?php echo $value->Nombre;?>]" type="text">
                </td>
<?php  
            }else{
?>                
                <td>  	
                    <label for="Detalleingreso_'+arrayServicios[i]+'"><?php echo Detalleingreso::changeName($value->Nombre);?></label>
                    <input id="Detalle_<?php echo $value->Nombre;?>" name="Detalle[<?php echo $value->Nombre;?>]" type="text">
                </td>
                </tr>
<?php                
            }
            
        } 
            
            ?>
  
</table>

        
<h2>VENTAS FULLCARGA</h2>        
<table width="200" border="1" >
  <tr>
        <td>
            <?php echo $form->labelEx($model,'Ventas'); ?>
            <?php echo $form->dropDownList($model, 'Ventas', Compania::getListCompaniaActiva(),array('empty'=>array('Seleccionar..'))); ?>
            <?php echo $form->error($model,'Ventas'); ?>

            <input type="button" value="Agregar" id="genVenta">
        </td>
  </tr>      
</table>
<br><br>

<div id="ventasServicios">
    
    
</div>
<!--
<?php // if (Yii::app()->getModule('user')->user()->CABINA_Id != '17'): ?>
        
-->
<!--<div id="Movistar" style="display: none;">
<h2>MOVISTAR</h2>
<table >
  <tr>
      <?php  
//        $movistar = TipoIngresos::model()->findAllBySql("SELECT t.Nombre 
//                                                        FROM tipo_ingresos as t
//                                                        WHERE t.COMPANIA_Id = 1 AND t.Clase = 1;");
//        foreach ($movistar as $key => $value) {
      ?>
    <td>  	
        <div class="row">
		<?php // echo $form->labelEx($model,$value->Nombre); ?>
		<?php // echo $form->textField($model,$value->Nombre,array('size'=>15,'maxlength'=>15)); ?>
		<?php // echo $form->error($model,$value->Nombre); ?>
	</div>
    </td>
        <?php // } ?>
  </tr>
</table>
</div>
<br>-->






	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Save',array('confirm'=> SiteController::mensajesConfirm(1))); ?>
		<?php echo CHtml::submitButton('Declarar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --><!--comentario-->