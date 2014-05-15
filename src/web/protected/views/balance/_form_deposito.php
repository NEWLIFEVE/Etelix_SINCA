<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?> 
<head>
    <script>
    function estadoDropDown()
    {
        if($("#IdCheckBox").is(':checked'))
        {
            //$("#Balance_TiempoCierre").removeAttr('disabled');
            $("#Balance_TiempoCierre").removeAttr('disabled');
            $("#IdCheckBox").val("TRUE");
        }
        else
        {
            $("#Balance_TiempoCierre").attr('disabled', 'disabled');
            $("#IdCheckBox").val("FALSE");
        }
    }
    function formatDate(dateValue)
    {
        var fecha = dateValue.toString();
        return fecha[3]+fecha[4]+fecha[2]+fecha[0]+fecha[1]+fecha[5]+fecha[6]+fecha[7]+fecha[8]+fecha[9];
    }
    //Esto se ejecuta cuando se carga el DOM
    //ADICIONAMOS EVENTO CLICK A CAMPO DE CHECKBOX
    $(document).ready(function()
    {
        $(document).change( function()
        {
            var fecha = formatDate($('#Balance_Fecha').val());
            var fecha2 = formatDate($('#Balance_FechaDep').val());
            $("#diaSemana").text(["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"][new Date(fecha).getDay()]);
            $("#diaSemana2").text(["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"][new Date(fecha2).getDay()]);
            $('#IdCheckBox ').click(function()
            {
                estadoDropDown();
            });
        });
    });
    </script>
</head>
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
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
); 
?>
    <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
    <?php echo $form->errorSummary($model); ?>
    
<table width="200" border="1" id="dateBalance">
  <tr>
    <td>    

                <div class="row">
                    <?php echo $form->labelEx($model,'FechaCorrespondiente');  ?>
                    <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', 
                    array(
                        'language'=>'es',
                        'model'=>$model,
                        'attribute'=>'FechaCorrespondiente',
                        'options'=>array(
                            'changeMonth'=>'true',//para poder cambiar mes
                            'changeYear'=>'true',//para poder cambiar año
                            'showButtonPanel'=>'false',
                            'constrainInput'=>'false',
                            'showAnim'=>'show',
                            'minDate'=>'-7D', //fecha minima
                            'maxDate'=>"-1D", //fecha maxima 'readonly'=>'readonly'
                            ),
                        'htmlOptions'=>array('readonly'=>'readonly','style'=>'float: left;'),
                        )
                    );
                    echo CHtml::label('', 'diaSemana',array(
                        'id'=>'diaSemana',
                        'style'=>'color:forestgreen'
                        )
                    );
                    ?>
                    <?php echo $form->error($model,'FechaCorrespondiente',array('readonly'=>'readonly')); ?>
                </div>
   </td>

  </tr>   
</table>     
    <table width="200" border="1">
        <tr>
            <td >
                <div class="row">
                    <?php echo $form->labelEx($model,'Fecha', array('label' => 'Fecha en que se hizo el Deposito')); ?>
                    <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'language'=>'es',
                            'model'=>$model,
                            'attribute'=>'Fecha',
                            'options'=>array(
                                'changeMonth'=>'true',//para poder cambiar mes
                                'changeYear'=>'true',//para poder cambiar año
                                'showButtonPanel'=>'false',
                                'constrainInput'=>'false',
                                'showAnim'=>'show',
                                'minDate'=>'-7D', //fecha minima
                                'maxDate'=>"-0D", //fecha maxima 'readonly'=>'readonly'
                                ),
                            'htmlOptions'=>array('readonly'=>'readonly',),
                            )
                        );
                        echo CHtml::label('', 'diaSemana',array(
                            'id'=>'diaSemana2',
                            'style'=>'color:forestgreen'
                            )
                        );
                    ?>
                    <?php echo $form->error($model,'Fecha',array('readonly'=>'readonly')); ?>
                </div>
            </td>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model,'Hora', array('label' => 'Hora en que se hizo el Deposito')); ?>
                    <?php
                        $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                            'model'=>$model,
                            'attribute'=>'Hora',
                            'options'=>array(
                                'starthour'=>7,
                                'endhour'=>20,
                                'showminutes'=>TRUE,
                                'minutedivisions'=>12,
                                'military'=>false,
                                'event'=>'focus',
                                'layout'=>'horizontal'
                                ),
                            'htmlOptions'=>array(
                                'size'=>10,
                                'maxlength'=>10,
                                'readonly'=>'readonly'
                                )
                            )
                        );
                    ?>
                    <?php echo $form->error($model,'Hora'); ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model,'MontoDep', array('label' => 'Monto del Deposito')); ?>
                    <?php echo $form->textField($model,'MontoDep',array('size'=>15,'maxlength'=>15)); ?>
                    <?php echo $form->error($model,'MontoDep'); ?>
                </div>
            </td>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model,'NumRef', array('label' => 'Numero de Referencia del Deposito')); ?>
                    <?php echo $form->textField($model,'NumRef',array('size'=>45,'maxlength'=>45)); ?>
                    <?php echo $form->error($model,'NumRef'); ?>
                </div>
            </td>
        </tr>
        <tr>
            <td rowspan="2">
            <div class="row">
                    <?php echo $form->labelEx($model,'Depositante', array('label' => 'Nombre del Depositante')); ?>
                    <?php echo $form->textField($model,'Depositante',array('size'=>45,'maxlength'=>45)); ?>
                    <?php echo $form->error($model,'Depositante'); ?>
                </div>
            </td>
            <td>
                <p>
                    <label>Cerro la cabina para realizar el Deposito?</label>
                    <span class="row">Si
                        <input name="IdCheckBox" id="IdCheckBox" type="checkbox" value=""  />
                    </span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="row">
                        <?php echo $form->labelEx($model,'TiempoCierre', array('label' => 'Tiempo de Cierre de Cabina (min)')); ?>
                        <?php echo $form->dropDownList($model,'TiempoCierre',
                            array(
                            '15'=>'15 min',
                            '30'=>'30 min',
                            '45'=>'45 min'
                            ),
                            array(
                            'empty'=>'Seleccionar..',
                            'disabled'=>'disabled'
                            )
                            );
                            ?>
                            <?php echo $form->error($model,'TiempoCierre'); ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="row buttons">
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Save',array('confirm'=>  SiteController::mensajesConfirm(1))); ?>
        <?php echo CHtml::submitButton('Declarar'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->