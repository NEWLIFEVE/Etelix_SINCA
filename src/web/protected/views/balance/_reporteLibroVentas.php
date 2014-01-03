<h1>Reporte Libro de Ventas </h1>
<?php
$this->layout=$this->getLayoutFile('mainfancybox');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'balanceLibroVentas1',
    'htmlOptions'=>array(
        'class'=>'grid-view LibroVentas',
    ),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'Fecha',
            'value'=>'$data->Fecha',                    
            'type'=>'text',
            'htmlOptions'=>array('style'=>'text-align: center;')
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array('style'=>'text-align: center;')
            ),
        array(
            'name'=>'Trafico',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI
                      )',
            'type'=>'text',
            ),
        array(
            'name'=>'RecargaMovistar',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->RecargaCelularMov+$data->RecargaFonoYaMov
                      )',
            'type'=>'text',
            ),
        array(
            'name'=>'RecargaClaro',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->RecargaCelularClaro+$data->RecargaFonoClaro
                      )',
            'type'=>'text',
            ),
        'OtrosServicios',
        array(
            'name'=>'Total',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios
                      )',
            'type'=>'text',
            ),
        ),
));
?>
