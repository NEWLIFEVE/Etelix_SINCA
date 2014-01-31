<?php
/* @var $this BalanceController */
/* @var $model Balance */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'balance-form',
        'enableAjaxValidation' => false,
    ));
    ?>
<?php echo $form->errorSummary($model); ?>

        <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
    <table width="200" border="1">
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'Fecha'); ?>
                    <?php echo $form->textField($model, 'Fecha', array('disabled' => 'disabled')); ?>
                    <?php echo $form->error($model, 'Fecha', array('readonly' => 'readonly')); ?>
                </div></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><h2>Saldos Brightstar</h2></td>
        </tr>
        <tr>
        <h1></h1>
        <td>	<div class="row">
                <?php echo $form->labelEx($model, 'SaldoApMov'); ?>
                <?php echo $form->textField($model, 'SaldoApMov', array('size' => 15, 'maxlength' => 15)); ?>
                <?php echo $form->error($model, 'SaldoApMov'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model, 'SaldoApClaro'); ?>
                <?php echo $form->textField($model, 'SaldoApClaro', array('size' => 15, 'maxlength' => 15)); ?>
                <?php echo $form->error($model, 'SaldoApClaro'); ?>
            </div></td>
        </tr>
        <tr>
            <td>	
                <div class="row">
                    <?php echo $form->labelEx($model, 'SaldoCierreMov'); ?>
                    <?php echo $form->textField($model, 'SaldoCierreMov', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'SaldoCierreMov'); ?>
                </div>
            </td>
            <td>	
                <div class="row">
                    <?php echo $form->labelEx($model, 'SaldoCierreClaro'); ?>
                    <?php echo $form->textField($model, 'SaldoCierreClaro', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'SaldoCierreClaro'); ?>
                </div></td>
        </tr>
        <tr>
            <td colspan="2"><h2>Llamadas</h2></td>
        </tr>
        <tr>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'FijoLocal'); ?>
                    <?php echo $form->textField($model, 'FijoLocal', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'FijoLocal'); ?>
                </div></td>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'FijoProvincia'); ?>
                    <?php echo $form->textField($model, 'FijoProvincia', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'FijoProvincia'); ?>
                </div></td>
        </tr>
        <tr>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'FijoLima'); ?>
                    <?php echo $form->textField($model, 'FijoLima', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'FijoLima'); ?>
                </div></td>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'Rural'); ?>
                    <?php echo $form->textField($model, 'Rural', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'Rural'); ?>
                </div></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'Celular'); ?>
                    <?php echo $form->textField($model, 'Celular', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'Celular'); ?>
                </div></td>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'LDI'); ?>
                    <?php echo $form->textField($model, 'LDI', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'LDI'); ?>
                </div></td>
        </tr>
        <tr>
            <td colspan="2"><h2>Recargas Brightstar</h2></td>
        </tr>
        <tr>
            <td>	<div class="row">
                    <?php echo $form->labelEx($model, 'RecargaCelularMov'); ?>
                    <?php echo $form->textField($model, 'RecargaCelularMov', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'RecargaCelularMov'); ?>
                </div>
            </td>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'RecargaFonoYaMov'); ?>
                    <?php echo $form->textField($model, 'RecargaFonoYaMov', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'RecargaFonoYaMov'); ?>
                </div></td>
        </tr>
        <tr>
            <td>	<div class="row">
                    <?php echo $form->labelEx($model, 'RecargaCelularClaro'); ?>
                    <?php echo $form->textField($model, 'RecargaCelularClaro', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'RecargaCelularClaro'); ?>
                </div>

            </td>
            <td>	<div class="row">
                    <?php echo $form->labelEx($model, 'RecargaFonoClaro'); ?>
                    <?php echo $form->textField($model, 'RecargaFonoClaro', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'RecargaFonoClaro'); ?>
                </div></td>
        </tr>
        <tr>
            <td colspan="2"><h2>MISCELANEOS</h2></td>
        </tr>
        <tr>
            <td>	<div class="row">
                    <?php echo $form->labelEx($model, 'OtrosServicios'); ?>
                    <?php echo $form->textField($model, 'OtrosServicios', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'OtrosServicios'); ?>
                </div></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><h2>Depositos Bancarios</h2></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'MontoDeposito'); ?>
                    <?php echo $form->textField($model, 'MontoDeposito', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'MontoDeposito'); ?>
                </div>



            </td>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'NumRefDeposito'); ?>
                    <?php echo $form->textField($model, 'NumRefDeposito', array('size' => 45, 'maxlength' => 45)); ?>
                    <?php echo $form->error($model, 'NumRefDeposito'); ?>
                </div></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'MontoBanco'); ?>
                    <?php echo $form->textField($model, 'MontoBanco', array('size' => 15, 'maxlength' => 15)); ?>
                    <?php echo $form->error($model, 'MontoBanco'); ?>
                </div>
            </td>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'FechaDep'); ?>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'language' => 'es',
                        'model' => $model,
                        'attribute' => 'FechaDep',
                        'options' => array(
                            'changeMonth' => 'true', //para poder cambiar mes
                            'changeYear' => 'true', //para poder cambiar año
                            'showButtonPanel' => 'false',
                            'constrainInput' => 'false',
                            'showAnim' => 'show',
                            'minDate' => '-7D', //fecha minima
                            'maxDate' => "-0D", //fecha maxima 'readonly'=>'readonly'
                        ),
                        'htmlOptions' => array('readonly' => 'readonly'),
                            )
                    );
                    echo CHtml::label('', 'diaSemana', array(
                        'id' => 'diaSemana2',
                        'style' => 'color:forestgreen'
                            )
                    );
                    ?>
<?php echo $form->error($model, 'FechaDep', array('readonly' => 'readonly')); ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="row">
                    <?php echo $form->labelEx($model, 'HoraDep'); ?>
                    <?php
                    $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                        'model' => $model,
                        'attribute' => 'HoraDep',
                        'options' => array(
                            'starthour' => 7,
                            'endhour' => 20,
                            'showminutes' => TRUE,
                            'minutedivisions' => 12,
                            'military' => false,
                            'event' => 'focus',
                            'layout' => 'horizontal'
                        ),
                        'htmlOptions' => array(
                            'size' => 10,
                            'maxlength' => 10,
                            'readonly' => 'readonly'
                        )
                            )
                    );
                    ?>
<?php echo $form->error($model, 'HoraDep'); ?>
                </div>
            </td>
        </tr>

    </table>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Actualizar' : 'Actualizar', array('confirm' => SiteController::mensajesConfirm(4))); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->