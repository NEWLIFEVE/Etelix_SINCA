<?php
/* @var $this NovedadController */
/* @var $model Novedad */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'novedad-form',
        'enableAjaxValidation'=>true,
)); ?>
<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
<?php echo $form->errorSummary(array($model)); ?>
<div style="display: block;">
    <div style="width: 40%;float: left;">
        <table class="tiponovedad">
            <tr>
                <td width="62"><?php echo $form->labelEx($model,'TIPONOVEDAD_Id',array('separator'=>'<br/><br/>')); ?></td>
            </tr>
            <tr>
                <td>	
                    <?php echo $form->radioButtonList($model, 'TIPONOVEDAD_Id', CHtml::listData(Tiponovedad::model()->findAll(), 'Id', 'Nombre'),array('separator'=>'<br/>')); ?>
                    <?php echo $form->error($model,'TIPONOVEDAD_Id')?>
                </td>
            </tr>
        </table>
    </div>
    <div style="width: 60%;float: left;">
        <table>
            <tr>
                <td>
                    <div class="row">
                        <?php echo $form->labelEx($model,'Num'); ?>
                        <?php echo $form->textField($model,'Num',array('size'=>15,'maxlength'=>15)); ?>
                        <?php echo $form->error($model,'Num'); ?>
                    </div></td>
                <td><div class="row"> <?php echo $form->labelEx($model,'Puesto'); ?> <?php echo $form->textField($model,'Puesto',array('size'=>15,'maxlength'=>15)); ?> <?php echo $form->error($model,'Puesto'); ?> </div></td>
            </tr>
            <tr>
              <td><?php echo $form->labelEx($model,'Descripcion'); ?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $form->textArea($model,'Descripcion',array('size'=>160,'maxlength'=>450,'style'=>'width:400px;height:183px;')); ?>
                    <?php echo $form->error($model,'Descripcion'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div style="display: block;"></div>
<div class="row buttons" style="display: block;">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Enviar' : 'Enviar',array('id'=>'btnEnviar')); ?>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->