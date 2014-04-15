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


        <table class="tiponovedad" style="width: 50%;float: left;">
            <tr>
                <td width="62"><?php echo $form->labelEx($model,'TIPONOVEDAD_Id',array('separator'=>'<br/><br/>')); ?></td>
            </tr>
            <tr>
                <td>	
                    <?php echo $form->radioButtonList($model, 'TIPONOVEDAD_Id', CHtml::listData(Tiponovedad::model()->findAllBySql("SELECT * From tiponovedad WHERE status = 1 ORDER BY Nombre = 'Otra' "), 'Id', 'Nombre'),array('separator'=>'<br/>')); ?>
                    <?php echo $form->error($model,'TIPONOVEDAD_Id');?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'Descripcion',array('separator'=>'<br/><br/>')); ?>
                    <?php echo $form->textArea($model,'Descripcion',array('size'=>160,'maxlength'=>450,'style'=>'width:400px;height:183px;')); ?>
                    <?php echo $form->error($model,'Descripcion'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="display: block;"></div>
                    <div class="row buttons" style="display: block;">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Enviar' : 'Enviar',array('id'=>'btnEnviar')); ?>
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 50%;float: right;">
            <tr>
                <td><?php echo $form->labelEx($model,'Num'); ?></td>
                <td><?php echo $form->labelEx($model,'Puesto'); ?></td>
            </tr>
            <tr>
                <td>	
                    <?php echo $form->radioButtonList($model, 'TIPOTELEFONO_Id', CHtml::listData(TipoNumeroTelefono::model()->findAll(), 'Id', 'Nombre'),array('separator'=>'<br>')); ?>
                    <?php echo $form->error($model,'TIPOTELEFONO_Id');?>
                    <div class="row">
                        <?php echo $form->textField($model,'Num',array('size'=>15,'maxlength'=>15)); ?>
                        <?php echo $form->error($model,'Num'); ?>
                    </div></td>
                <td >
                        
                    <?php echo $form->checkBoxList($model, 'Puesto', 
                          CHtml::listData(Locutorio::model()->findAllBySql(
                              "SELECT id, id as Numero FROM locutorio WHERE id < (SELECT MAX(id) FROM locutorio)
                               UNION
                               SELECT MAX(id),IF(MAX(id),'Todas',id) as Numero FROM locutorio"
                              ), 'id', 'Numero')); ?>
 
                </td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
            </tr>
            
        </table>



<?php $this->endWidget(); ?>
</div><!-- form -->