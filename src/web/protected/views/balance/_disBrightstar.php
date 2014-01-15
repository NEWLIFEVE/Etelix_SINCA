<h1>Reporte de Ventas Recargas Brightstar</h1>
<?php 
$this->layout=$this->getLayoutFile('mainfancybox');
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'balanceReporteBrighstar1',
    'htmlOptions'=>array(
        'class'=>'grid-view ReporteBrighstar',
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
        'RecargaVentasMov',
        array(
            'name'=>'DifMov',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->RecargaVentasMov-($data->RecargaCelularMov+$data->RecargaFonoYaMov)
                      )',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        'RecargaVentasClaro',
        array(
            'name'=>'DifClaro',
            'value'=>'Yii::app()->format->formatDecimal(
                      $data->RecargaVentasClaro-($data->RecargaCelularClaro+$data->RecargaFonoClaro)
                      )',
            'type'=>'text',
            'htmlOptions'=>array(
                'style'=>'text-align: center; color: red;',
                'class'=>'dif',
                'name'=>'dif',
                ),
            ),
        ),
));
?>
<!--</div>-->
