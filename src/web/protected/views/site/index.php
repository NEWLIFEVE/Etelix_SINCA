<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

     
?>
<!-- <h1>Bienvenido a <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h1> -->
<h1>Bienvenido <i><?php echo CHtml::encode(Yii::app()->user->name); ?></i></h1>

<p> <h3>Haga click en una pestaña del menu para comenzar</h3></p>


<p><?php  
//CabinaController::getNombreCabina(Yii::app()->getModule('user')->user(Yii::app()->user->id)->CABINA_Id);?></p>
<ul>
	<!--<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>-->
</ul>

<p></p>
