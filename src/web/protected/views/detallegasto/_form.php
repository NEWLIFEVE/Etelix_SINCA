<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */
/* @var $form CActiveForm */
?>

  <meta charset="utf-8" />
  <title>jQuery UI Datepicker - Format date</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />

<script>

    $(function() {
        $("#Detallegasto_FechaMes").datepicker({
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
        $("#Detallegasto_FechaMes").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    });
</script>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'detallegasto-form',
        'enableAjaxValidation' => true,
            ));
    ?>
    <p class="note">Los campos con  <span class="required">*</span> son obligatorios.</p>
<?php echo $form->errorSummary(array ($model, $model_cabina,$model_category)); ?>
    <table style="width: 70%;" border="1">
        <tr>
            <td>
            <table border="1">
                <tr >
                  <td id="ocultarEnUpdate" style="width: 50%;"><div class="row"> <?php echo $form->labelEx($model,'CABINA_Id'); ?> <?php echo $form->dropDownList($model, 'CABINA_Id', Cabina::getListCabinaResto(),array('empty'=>'Seleccionar..'));?> <?php echo $form->error($model,'CABINA_Id'); ?> </div></td>
                    <td style="width: 50%;"><div class="row"> <?php echo $form->labelEx($model, 'beneficiario'); ?> <?php echo $form->textField($model, 'beneficiario'); ?> <?php echo $form->error($model, 'beneficiario'); ?> </div></td>
                     <td style="width: 50%;">&nbsp;</td>
                </tr>
                <tr>
                  <td>
                        <div class="row"> 
                                <?php echo $form->labelEx($model, 'category'); ?> 
                                <?php echo $form->dropDownList($model, 'category',Category::getListTipoCategoria(), array('empty'=>'Seleccionar...'),array(
                                                   
                                    'ajax'=>array(
                                        'type'=>'POST', //request type
                                        'url'=>CController::createUrl('Detallegasto/DynamicCategoria'), //url to call.
                                        'update'=>'#Detallegasto_TIPOGASTO_Id', //selector to update
                                        ),
                                    )
                                ); 
                                ?> 
                                <?php echo $form->error($model, 'category'); ?> 
                        </div>
                  </td>
                  <td>
                      <div class="row"> 
                          <?php echo $form->labelEx($model, 'TIPOGASTO_Id'); ?> 
                          <?php echo $form->dropDownList($model, 'TIPOGASTO_Id', Tipogasto::getListTipoGasto(),array(
                                'empty'=>array('Seleccionar..','Nuevo..'),
                                'ajax'=>array(
                                    'type'=>'POST', //request type
                                    'url'=>CController::createUrl('Detallegasto/DynamicGastoAnterior'), //url to call.
                                    'update'=>'#GastoMesAnterior', //selector to update
                                    ),
                                )
                            );
                            ?> 
                          <?php echo $form->error($model, 'TIPOGASTO_Id'); ?> 
                      </div>
                  </td>
                    <td>
                        <div class="row"> 
                                <?php echo $form->labelEx($model, 'moneda'); ?> 
                                <?php echo $form->dropDownList($model, 'moneda', array('empty'=>'Seleccionar...','1'=>'Dollar (USD$)','2'=>'Soles (S/.)'),array(               
                                    'ajax'=>array(
                                        'type'=>'POST', //request type
                                        'url'=>CController::createUrl('Detallegasto/DynamicCuenta'), //url to call.
                                        'update'=>'#Detallegasto_CUENTA_Id', //selector to update
                                        ),
                                )); ?> 
                                <?php echo $form->error($model, 'moneda'); ?> 
                        </div>
                    </td>
                      <td style="width: 50%;"><div class="row"> 
                         <?php echo $form->labelEx($model, 'CUENTA_Id'); ?> 
                         <?php echo $form->dropDownList($model, 'CUENTA_Id',  Cuenta::getListCuenta());?> 
                         <?php echo $form->error($model, 'CUENTA_Id'); ?> 
                        </div>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td>
                <div id="DetalleGasto" class="ocultar">

                    <table border="1">
                        <tr>
                          <td><div id="GastoNuevo" class="row ocultar"> <?php echo $form->labelEx($model, 'nombreTipoDetalle'); ?> <?php echo $form->textField($model, 'nombreTipoDetalle'); ?> <?php echo $form->error($model, 'nombreTipoDetalle'); ?> </div></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div class="row"> <?php echo $form->labelEx($model, 'Monto'); ?> <?php echo $form->textField($model, 'Monto', array('size' => 15, 'maxlength' => 15)); ?> <?php echo $form->error($model, 'Monto'); ?> </div></td>
                            <td>
                                
                              <div id="GastoMesAnterior"> 

                            </div></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row"> 
                                    <?php echo $form->labelEx($model, 'FechaMes'); ?> 
                                    <?php echo $form->textField($model, 'FechaMes'); ?> 
                                    <?php echo $form->error($model, 'FechaMes'); ?> 
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <?php echo $form->labelEx($model, 'FechaVenc'); ?>
                                    <?php 
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', 
                                            array(
                                            'language' => 'es', 
                                            'model' => $model,
                                            'attribute'=>'FechaVenc', 'options' => array(
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
                                    <?php
//                                    echo $form->textField($model, 'FechaVenc');
//                                    echo CHtml::label('', 'diaSemana', array(
//                                        'id' => 'diaSemana',
//                                        'style' => 'color:forestgreen'
//                                        )
//                                    );
                                    ?>
                                    <?php echo $form->error($model, 'FechaVenc'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $form->labelEx($model, 'Descripcion',array('style' => 'width:400px;')); ?> 
                                <?php echo $form->textArea($model, 'Descripcion', array('size' => 160, 'maxlength' => 450, 'style' => 'width:400px;height:183px;')); ?>
                                <?php echo $form->error($model, 'Descripcion'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Guardar'); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->