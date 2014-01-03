<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */
/* @var $form CActiveForm */
?>

<script>

    $(document).ready(function(){

        $("#Detallegasto_FechaMes").datepicker({ 
            dateFormat: 'mm-yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function(dateText, inst) {  
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
                $(this).val($.datepicker.formatDate('dd/mm/yy', new Date(year, month, 1)));
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
  
    $(function($){
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults("option",$.datepicker.regional['es']);
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
<?php echo $form->errorSummary(array ($model, $model_cabina)); ?>
    <table width="460" border="1">
        <tr>
            <td width="200"><table width="200" border="1">
                    <tr>
                        <td><div class="row">
                                <?php echo $form->labelEx($model_cabina,'Id'); ?>
                                <!--<label for="CABINA_Id" class="required">Cabina<span class="required">*</span></label>-->
                                <?php //echo $form->dropDownList($model_cabina,'Nombre',Cabina::getListCabina(),array('empty'=>'Seleccionar..'));  ?> 
                                

                                <?php
//                                echo $form->dropDownList($model_cabina, 'Id', Cabina::getListCabina(), array(
                                echo CHtml::dropDownList('Id','', Cabina::getListCabina(), array(
                                    'empty'=>'Seleccionar..',
                                    'ajax' => array(
                                        'type' => 'POST', //request type
                                        'url' => CController::createUrl('Detallegasto/DynamicUsers'), //url to call.
                                        //Style: CController::createUrl('currentController/methodToCall')
                                        'update' => '#USERS_Id', //selector to update
                                    //'data'=>'js:javascript statement' 
                                    //leave out the data key to pass all form values through
                                        )));
                                ?>
                                <?php echo $form->error($model_cabina,'Id'); ?> 
                            </div>


                        </td>
                        <td><div class="row">
                                <?php echo $form->labelEx($model, 'USERS_Id'); ?>
                                <!--<label for="USERS_Id" class="required">Responsable *</label>-->
                                <?php //echo $form->dropDownList($model,'USERS_Id', Users::getListUsers(2),array('empty'=>'Seleccionar..',)); ?> 
                                <?php
                                //empty since it will be filled by the other dropdown
//                                echo $form->dropDownList($model,'USERS_Id', array());
                                echo CHtml::dropDownList('USERS_Id', '', array());
                                ?>
                                <?php echo $form->error($model, 'USERS_Id'); ?> 
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row"> 
                                <?php echo $form->labelEx($model, 'TIPOGASTO_Id'); ?> 
                                <?php echo $form->dropDownList($model, 'TIPOGASTO_Id', Tipogasto::getListGasto(), array('empty' => 'Nuevo..')); ?> 
                                <?php echo $form->error($model, 'TIPOGASTO_Id'); ?> 
                            </div>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table></td>
            <td width="244">&nbsp;</td>
        </tr>
        <tr>
            <td><table id="DetalleGastoViejo" width="200" border="1">
                    <tr>
                        <td colspan="2"><div class="row"> <?php echo $form->labelEx($model, 'Monto'); ?> <?php echo $form->textField($model, 'Monto', array('size' => 15, 'maxlength' => 15)); ?> <?php echo $form->error($model, 'Monto'); ?> </div></td>
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
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'language' => 'es',
                                    'model' => $model,
                                    'attribute' => 'FechaVenc',
                                    'options' => array(
                                        'changeMonth' => 'true', //para poder cambiar mes
                                        'changeYear' => 'true', //para poder cambiar año
                                        'showButtonPanel' => 'false',
                                        'constrainInput' => 'false',
                                        'showAnim' => 'show',
                                        'minDate' => '-7D', //fecha minima
                                        'maxDate' => "-1D", //fecha maxima 'readonly'=>'readonly'
                                    ),
                                    'htmlOptions' => array('readonly' => 'readonly'),
                                        )
                                );
                                echo CHtml::label('', 'diaSemana', array(
                                    'id' => 'diaSemana',
                                    'style' => 'color:forestgreen'
                                        )
                                );
                                ?>
                                <?php echo $form->error($model, 'Fecha', array('readonly' => 'readonly')); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><div class="row"> 
                            <?php echo $form->labelEx($model, 'Descripcion'); ?> 
                            <?php echo $form->textArea($model, 'Descripcion', array('size' => 160, 'maxlength' => 450, 'style' => 'width:400px;height:183px;')); ?>
                            <?php echo $form->error($model, 'Descripcion'); ?>
                    </tr>
                </table></td>
            <td>&nbsp;</td>
        </tr>
    </table>



    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>


</div><!-- form -->