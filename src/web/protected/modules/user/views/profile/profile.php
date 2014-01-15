<?php // $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= ProfileController::controlAcceso($tipoUsuario);
?>
<h1>
    <span class="enviar">
        Su Perfil
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/sms-icon.png" class="botonCorreoDetail" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcelDetail" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/info-icon.png' class='printButtonDetail' />
    </span>
</h1>
<!--<h1><?php //echo UserModule::t('Your profile'); ?></h1>-->
<?php
echo CHtml::beginForm(Yii::app()->createUrl('users/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none')); //, array('hidden'=>'hidden')
echo CHtml::textField('vista', 'profile', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte Su Perfil Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Perfil" method="post" target="_blank" id="FormularioExportacion">

<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="enviarTabla">
<table class="dataGrid">
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></th>
	    <td><?php echo CHtml::encode($model->username); ?></td>
	</tr>
	<?php 
		$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo "<pre>"; print_r($profile); die();
			?>
	<tr>
		<th class="label"><?php echo CHtml::encode(UserModule::t($field->title)); ?></th>
    	<td><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></td>
	</tr>
			<?php
			}//$profile->getAttribute($field->varname)
		}
	?>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
    	<td><?php echo CHtml::encode($model->email); ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('create_at')); ?></th>
    	<td><?php echo $model->create_at; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit_at')); ?></th>
    	<td><?php echo $model->lastvisit_at; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></th>
    	<td><?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status)); ?></td>
	</tr>
		
                <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('tipo')); ?></th>
    	<td><?php 
         /*BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA*/
                        $sql="SELECT nombre from tipousuario where id=:id;";
                        $connection=Yii::app()->db; 
                        $command=$connection->createCommand($sql);
                        $command->bindValue(":id", $model->tipo , PDO::PARAM_INT); // bind de parametro tipo de user       
                        $id=$command->query(); // execute a query SQL
                        $tipo=$id->readColumn(0);
                        /************************************************/
        echo $tipo; ?></td>
	</tr>
                <th class="label"><?php echo 'Cabina Asociada'; ?></th>
    	<td><?php 
         /*BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA*/
                        $sql="SELECT nombre from cabina where id=:id;";
                        $connection=Yii::app()->db; 
                        $command=$connection->createCommand($sql);
                        $command->bindValue(":id", $model->CABINA_Id , PDO::PARAM_INT); // bind de parametro tipo de user       
                        $id=$command->query(); // execute a query SQL
                        $tipo=$id->readColumn(0);
                        /************************************************/
                        if($tipo==''){
                            echo 'N/A';
                        }else{
                            echo $tipo;
                        }?></td>
	</tr>
</table>
</div>