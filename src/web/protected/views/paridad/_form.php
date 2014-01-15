<?php
/* @var $this ParidadController */
/* @var $model Paridad */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'paridad-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'Fecha'); ?>
		<?php echo $form->textField($model,'Fecha'); ?>
		<?php echo $form->error($model,'Fecha'); ?>
	</div>-->

        <div>
            <div style="width:50%;float:left;">
                    <?php echo $form->labelEx($model,'Valor'); ?>
                    <?php echo $form->textField($model,'Valor',array('size'=>15,'maxlength'=>15)); ?>
                    <?php echo $form->error($model,'Valor'); ?>
            </div>
            <div style="width:50%;float:right;">
                <h3>
                    <span>Paridad Actual: </span>
                    <span style="color:forestgreen;">
                        <?php 
                              $resultSet = Paridad::model()->find("Id > 0 ORDER BY Fecha DESC");
                              echo "$resultSet->Valor";
                        ?>
                    </span>
                    <span>S./$</span>
                </h3>
            </div>
        </div>
        <div style="display:block;padding:2em;"></div>
        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Actualizar' : 'Actualizar',array('confirm'=> SiteController::mensajesConfirm(5))); ?>
        </div>



<?php $this->endWidget(); ?>

</div><!-- form -->