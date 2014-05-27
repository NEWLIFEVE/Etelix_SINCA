<?php
$this->breadcrumbs=array(
	'Detalleingreso'=>array('index'),
	'Create',
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetalleingresoController::controlAcceso($tipoUsuario);
?>
<script>
    $(function() {
        $("#Detalleingreso_FechaMes").datepicker({
            closeText: 'Cerrar',
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],          
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        });
        $("#Detalleingreso_FechaMes").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
        $("#Detalleingreso_TIPOINGRESO_Id").click(function(){
            if($("#Detalleingreso_TIPOINGRESO_Id option:selected").html()=="Nuevo.."){
                $("GastoNuevo").css("display","inline");
                $("#GastoNuevo").slideDown("slow");
            }
            else if($("#Detalleingreso_TIPOINGRESO_Id option:selected").html()!="Nuevo.."){
                $("#GastoNuevo").slideUp("slow");
                $("#Detalleingreso_nombreTipoDetalle").val("");
                //$("td#Gasto").css("display","none");
            }
        });
        
    });
</script>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'declareIngreso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>
        <h1>Declarar Ingreso</h1>
	<p class="note">Los campos con  <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

        <table style="width: 40%;">
            
            <tr>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'TIPOINGRESO_Id'); ?>
                            <?php echo $form->dropDownList($model, 'TIPOINGRESO_Id', TipoIngresos::getListTipoIngreso(),array('empty'=>array('Seleccionar..','Nuevo..'))); ?>
                            <?php echo $form->error($model,'TIPOINGRESO_Id'); ?>
                    </div>
                </td>
                <td >
                    <div class="row">
                            <?php echo $form->labelEx($model,'CABINA_Id'); ?>
                            <?php echo $form->dropDownList($model, 'CABINA_Id', Cabina::getListCabinaResto(),array('empty'=>'Seleccionar..')); ?>
                            <?php echo $form->error($model,'CABINA_Id'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'moneda'); ?>
                            <?php echo $form->dropDownList($model, 'moneda',  Currency::getListCurrency(),array('empty'=>'Seleccionar...')); ?> 
                            <?php echo $form->error($model,'moneda'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'CUENTA_Id'); ?>
                            <?php 

                             (!isset($model->CUENTA_Id)) 
                                   ? $mon = $form->dropDownList($model, 'CUENTA_Id', array('empty'=>'Seleccionar Moneda'))
                                   : $mon = $form->dropDownList($model, 'CUENTA_Id',  Cuenta::getListCuentaTipo($model->moneda));

                             echo $mon;

                            ?> 
                            <?php echo $form->error($model,'CUENTA_Id'); ?>
                    </div>
                </td>
                <td >
                    <div id="GastoNuevo" class="row" style="display: none;">
                          <?php echo $form->labelEx($model, 'nombreTipoDetalle'); ?> 
                          <?php echo $form->textField($model, 'nombreTipoDetalle'); ?> 
                          <?php echo $form->error($model, 'nombreTipoDetalle'); ?> 
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'Monto'); ?>
                            <?php echo $form->textField($model,'Monto'); ?>
                            <?php echo $form->error($model,'Monto'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                            <?php echo $form->labelEx($model,'FechaMes'); ?>
                            <?php echo $form->textField($model,'FechaMes'); ?>
                            <?php echo $form->error($model,'FechaMes'); ?>
                    </div>
                </td>
                <td>
                    <div class="row"> 
                        <?php echo $form->labelEx($model,'TransferenciaPago'); ?>
                        <?php echo $form->textField($model,'TransferenciaPago'); ?>
                        <?php echo $form->error($model,'TransferenciaPago'); ?>
                    </div>
                </td>
                <td>
                    <div class="row"> 
                        <?php echo $form->labelEx($model,'FechaTransf'); ?>
                        <?php 
                            $this->widget('zii.widgets.jui.CJuiDatePicker', 
                            array(
                            'language' => 'es', 
                            'model' => $model,
                            'attribute'=>'FechaTransf', 'options' => array(
                            'dateFormat'=>'yy-mm-dd',    
                            'changeMonth' => 'true',//para poder cambiar mes
                            'changeYear' => 'true',//para poder cambiar año
                            'showButtonPanel' => 'false', 
                            'constrainInput' => 'false',
                            'showAnim' => 'show',
                            //'minDate'=>'-30D', //fecha minima
                            'maxDate'=> "+30D", //fecha maxima
                             ),
                                'htmlOptions'=>array('readonly'=>'readonly'),
                        )); 
                            echo CHtml::label('', 'diaSemana',array('id'=>'diaSemana','style'=>'color:forestgreen')); 
                        ?>
                        <?php echo $form->error($model,'FechaTransf'); ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="row">
                            <?php echo $form->labelEx($model,'Descripcion'); ?>
                            <?php echo $form->textArea($model, 'Descripcion', array('size' => 160, 'maxlength' => 450, 'style' => 'width:300px;height:100px;')); ?>
                            <?php echo $form->error($model,'Descripcion'); ?>
                    </div>
                </td>
            </tr>
            
        </table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->