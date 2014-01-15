<?php
/* @var $this PabrightstarController */
/* @var $model Pabrightstar */
/* @var $form CActiveForm */
Yii::import('webroot.protected.controllers.SiteController');

$sql="SELECT (X.SumaPA - Y.SumaRecargas) AS SaldoApertura

        FROM    
            (SELECT
                   IFNULL(SaldoAperturaPA,0) + IFNULL(TransferenciaPA,0) + IFNULL(ComisionPA,0)
                     AS SumaPA
            FROM
                  pabrightstar
            WHERE
                      Fecha    = CURDATE()
                  AND compania = :Compania)

                    AS X,

            (SELECT
                   IFNULL(SUM(r.MontoRecarga),0)
                     AS SumaRecargas
            FROM
                   pabrightstar p,
                   recargas     r
            WHERE
                       p.Fecha 	  = CURDATE()
                   AND p.compania = :Compania
                   AND p.Id 	  = r.PABRIGHTSTAR_Id)

                    AS Y;";
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pabrightstar-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="200" border="1">
  <tr>
    <td><div class="row"> <?php echo $form->labelEx($model,'Compania'); ?> <?php echo $form->dropDownList($model, 'Compania', Compania::getListCompania(),array('empty'=>'Seleccionar..'));?> <?php echo $form->error($model,'Compania'); ?> </div></td>
    <td>
        <h3>
            <span>Saldo Actual Movistar: </span>
            <span style="color:forestgreen;">
                <?php 
                    $modelMov = Pabrightstar::model()->findBySql($sql,array(':Compania'=>1));
                    //echo $modelMov->getAttribute('SaldoApertura');
                    if($modelMov!=NULL)
                      echo $modelMov->getAttribute('SaldoApertura');
                    else
                      echo "0";
                ?>
            </span>
            <span> S.</span>
        </h3>
    </td>
  </tr>
  <tr>
    <td><div class="row"> <?php echo $form->labelEx($model,'TransferenciaPA'); ?> <?php echo $form->textField($model,'TransferenciaPA',array('size'=>15,'maxlength'=>15)); ?> <?php echo $form->error($model,'TransferenciaPA'); ?> </div></td>
        <td>        
            <h3>
                <span>Saldo Actual Claro:  </span>
                <span style="color:forestgreen;">
                    <?php
                       $modelClaro = Pabrightstar::model()->findBySql($sql,array(':Compania'=>2));
                        if($modelClaro!=NULL)
                          echo $modelClaro->getAttribute('SaldoApertura');
                        else
                          echo "0";
                    ?>
                </span>
                <span> S.</span>
            </h3>
        </td>
  </tr>

</table>



	<div class="row buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Declarar' : 'Declarar',array('confirm'=> SiteController::mensajesConfirm(1))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->