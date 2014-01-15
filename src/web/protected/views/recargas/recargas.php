<head>
	<script type="text/javascript">
	$(document).on('ready',function(){
		totalesRecargados();
	});
	</script>
</head>
<?php
Yii::import('webroot.protected.controllers.PabrightstarController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
$this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'recargados',
	'dataProvider'=>$model->searchEs('recargas'/*,$idBalancesActualizados*/),
	'columns'=>array(
		array(
			'name'=>'CABINA_Id',
			'value'=>'Cabina::getNombreCabina($data->CABINA_Id)',
                    'htmlOptions'=>array(
                            'style'=>'text-align: center;'
				)
			),
		array(
			'header'=>'Monto Recarga',
			'value'=>'Recargas::getMontoRecarga($data->CABINA_Id,"'.$compania.'",$data->Fecha)',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'montoRecarga'
				)
			),
		array(
			/*Saldo Actual: Saldo Apertura - Ventas + Recargas*/
			'header'=>'Saldo Actual',
			'value'=>'Balance::Saldo($data->CABINA_Id,"'.$compania.'",$data->Fecha)',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'saldoActual'
				)
			),
		array(
			/*Dias a Venta Maxima: Saldo Actual / La venta maxima */
			'header'=>'Dias a Venta Maxima',
			'value'=>'Yii::app()->format->formatDecimal(Utility::notNull(Balance::DiasVentaMaxima($data->CABINA_Id,"'.$compania.'",$data->Fecha)))',
                    'htmlOptions'=>array(
                            'style'=>'text-align: center;'
				)
			)
		)
	)
);
?>
<div id="totalesPronostico" class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th id='totalCabinas'>Cabinas</th>
            <th id='totalRecargadas'>Monto Recargas</th>
            <th id="totalSaldoActual">Saldo Actual</th>
            <th id='diasMaxima'>Dias a venta maxima</th>
        </tr>
    </thead>
    <tbody>
      	<tr class="odd">
        	<td id='totalCabinas'>Todas</td>
        	<td id="totalRecargadas"></td>
        	<td id="totalSaldoActual"></td>
        	<td id='diasMaxima'>N/A</td> 
      	</tr>
    </tbody>
</table>
</div>