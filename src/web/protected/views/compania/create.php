<?php
/* @var $this CompaniaController */
/* @var $model Compania */

$this->breadcrumbs=array(
	'Companias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Compania', 'url'=>array('index')),
	array('label'=>'Manage Compania', 'url'=>array('admin')),
);
?>

<h1>Create Compania</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>