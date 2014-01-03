<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
Yii::import('webroot.Yii.framework.zii.widgets.jui.CJuiInputWidget');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'log-form',
        'enableAjaxValidation'=>false,
)); ?>

        <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

        <?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
                <?php echo $form->labelEx($model,'Fecha'); ?>
                <?php echo $form->textField($model,'Fecha'); ?>
                <?php echo $form->error($model,'Fecha'); ?>
        </div>-->

        <div class="row">
                <?php echo $form->labelEx($model,'Hora'); ?>

            <?php
                        $this->widget('webroot.protected.extensions.clockpick.EClockpick', array(
                            'model' => $model,
                            'attribute' => 'Hora',
                            'options' => array(
                                'starthour' => 12,
                                'endhour' => 23,
                                'showminutes' => TRUE,
                                'minutedivisions' => 12,
                                'military' => false,
                                'event' => 'focus',
                                'layout' => 'horizontal'
                                //'useBgiframe' => true ,//IE6
                            ),
                            'htmlOptions' => array('size' => 10, 'maxlength' => 10,'readonly'=>'readonly')
                        ));
                     ?>
                <?php echo $form->error($model,'Hora',array('readonly'=>'readonly')); ?>
        </div>

<!--	<div class="row">
                <?php echo $form->labelEx($model,'FechaEsp'); ?>
                <?php echo $form->textField($model,'FechaEsp'); ?>
                <?php echo $form->error($model,'FechaEsp'); ?>
        </div>-->

<!--	<div class="row">
                <?php echo $form->labelEx($model,'ACCIONLOG_Id'); ?>
                <?php echo $form->textField($model,'ACCIONLOG_Id'); ?>
                <?php echo $form->error($model,'ACCIONLOG_Id'); ?>
        </div>-->

<!--	<div class="row">
                <?php echo $form->labelEx($model,'USERS_Id'); ?>
                <?php echo $form->textField($model,'USERS_Id'); ?>
                <?php echo $form->error($model,'USERS_Id'); ?>
        </div>-->

        <div class="row buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Declarar',array('confirm'=>  SiteController::mensajesConfirm(3))); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->