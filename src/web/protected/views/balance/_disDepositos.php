<h1>Reporte de Depositos Bancarios</h1>
<?php 
$this->layout=$this->getLayoutFile('mainfancybox');
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteDepositos1',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteDepositos',
        ),
    'dataProvider'=>$model->disable(),
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
            'name'=>'TotalVentas',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios
                      )',
            'type'=>'text',
            ),
        'MontoDeposito',
        'NumRefDeposito',
        'MontoBanco',
        array(
            'name' => 'DiferencialBancario',
            'value' => 'Yii::app()->format->formatDecimal(
                        $data->MontoBanco-($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI+$data->RecargaCelularMov+$data->RecargaFonoYaMov+$data->RecargaCelularClaro+$data->RecargaFonoClaro+$data->OtrosServicios)
                        )',
            'type' => 'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array(
            'name' => 'ConciliacionBancaria',
            'value' => 'Yii::app()->format->formatDecimal(
                        $data->MontoBanco-$data->MontoDeposito
                        )',
            'type' => 'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: green;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        ),
));
?>
