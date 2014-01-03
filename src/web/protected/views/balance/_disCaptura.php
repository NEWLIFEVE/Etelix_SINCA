<h1>Reporte de Trafico Captura</h1>
<?php 
$this->layout=$this->getLayoutFile('mainfancybox');
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteCaptura1',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteCaptura',
        ),
    'dataProvider'=>$model->disable(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'Fecha',
            'value'=>'$data->Fecha',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'CABINA_Id',
            'value'=>'$data->cABINA->Nombre',
            'type'=>'text',
            'filter'=>Cabina::getListCabina(),
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'TraficoCapturaDollar',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->TraficoCapturaDollar
                      )',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;'
                )
            ),
        array(
            'name'=>'Paridad',
            'value'=>'Yii::app()->format->formatDecimal(2.64)',
            'type'=>'text',
            ),
        array(
            'name'=>'CaptSoles',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->TraficoCapturaDollar*2.64
                      )',
            'type'=>'text',
            ),
        array(
            'name'=>'DifSoles',
            'value'=>'Yii::app()->format->formatDecimal(
                      ($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI)-($data->TraficoCapturaDollar*2.64)
                      )',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        array(
            'name'=>'DifDollar',
            'value'=>'Yii::app()->format->formatDecimal(
                      ($data->FijoLocal+$data->FijoProvincia+$data->FijoLima+$data->Rural+$data->Celular+$data->LDI-$data->TraficoCapturaDollar*2.64)/2.64
                      )',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        ),
));
?>
<!--</div>-->
