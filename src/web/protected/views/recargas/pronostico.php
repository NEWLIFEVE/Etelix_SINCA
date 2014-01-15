<?php
Yii::import('webroot.protected.controllers.PabrightstarController');
Yii::import('webroot.protected.controllers.BalanceController');
$this->breadcrumbs=array(
	'Recargas'=>array('index'),
	'Recargas',
);
?>
<h1>Pronostico P.D.V. <?php echo BalanceController::getHeader($compania); ?></h1>
<?php
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
echo "Dia Laborable ".CHtml::textField("laborable",'2')." Fin de Semana: ".CHtml::textField("fin",'4');
echo CHtml::beginForm("/recargas/actRecargas/".$compania,'post',array('name'=>$compania, 'id'=>$compania));
$this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'pronosticos',
	'htmlOptions'=>array(
      'rel'=>'total',
      'name'=>'vista',
      ),
	'dataProvider'=>$model->searchEs("pronostico"),
	'columns'=>array(
		array(
			'name'=>'CABINA_Id',
			'value'=>'Cabina::getNombreCabina($data->CABINA_Id)',
			),
		array(
			'header'=>'Monto Recarga',
			'type'=>'raw',
			'value'=>'CHtml::textField("'.$compania.'$data->Id","",array("style"=>"width:50px;"))',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'propuesta'
				)
			),
		array(
			'header'=>'Total Venta '.BalanceController::getHeader($compania).'',
			'value'=>'Balance::totalVentasMes($data->CABINA_Id,"'.$compania.'",$data->Fecha)',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'totalVentaPronostico'
				)
			),
		array(
			'header'=>'Venta Maxima '.BalanceController::getHeader($compania).'',
			'value'=>'Balance::mayorVentaMes($data->CABINA_Id,"'.$compania.'",$data->Fecha)',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'ventaMaxima'
				)
			),
		array(
			/*Comision: Total ventas - (Total Ventas / 1.06)*/
			'header'=>'Comision',
			'value'=>'Yii::app()->format->formatDecimal(Balance::totalVentasMes($data->CABINA_Id,"'.$compania.'",$data->Fecha)-(Balance::totalVentasMes($data->CABINA_Id,"'.$compania.'",$data->Fecha)/1.06))',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'comision'
				)
			),
		array(
			'header'=>'Saldo '.BalanceController::getHeader($compania).'',
			'value'=>'Yii::app()->format->formatDecimal(Utility::NotNull(Balance::Saldo($data->CABINA_Id,'.$compania.',$data->Fecha)))',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'saldo'
				)
			),
		array(
			'header'=>'Nuevo Saldo',
			'value'=>'""',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'nuevoSaldo'
				)
			),
		array(
			/*Dias a Venta Maxima: Saldo Actual / La venta maxima */
			'header'=>'Dias a Venta Maxima',
			'value'=>'Yii::app()->format->formatDecimal(Balance::DiasVentaMaxima($data->CABINA_Id,'.$compania.',$data->Fecha))',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'dias'
				)			
			),
		array(
			'header'=>'Status Dia Laboral',
			'value'=>'""',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'laboral'
				)
			),
		array(
			'header'=>'Status Fin de Semana',
			'value'=>'""',
			'htmlOptions'=>array(
                            'style'=>'text-align: center;',
				'id'=>'fin'
				)
			)
		),
	));
?>
<div id="totalesPronostico" class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th id="cabinasPronostico">Cabinas</th>
            <th id='totalMontoRecargas'>Monto Recargas</th>
            <th id="TotalVentasPronostico"></th>
            <th id="totalVentaMaxima"></th>
            <th id="totalComision"></th>
            <th id="totalSaldo"></th>
            <th id="totalNuevoSaldo"></th>
            <th id="disponible">Disponible en P.A.B.</th>
            <th>Aprobación</th>
        </tr>
    </thead>
    <tbody>
      <tr class="odd">
        <td id="cabinasPronostico">Todas</td>
        <td id="totalMontoRecargas"></td>
        <td id="TotalVentasPronostico"></td>
        <td id="totalVentaMaxima"></td>
        <td id="totalComision"></td>
        <td id="totalSaldo"></td>
        <td id="totalNuevoSaldo"></td>
        <td id="disponible"><?php echo Pabrightstar::getSaldoPorDia(null,$idCompania); ?></td>   
        <td id="aprobacion"></td>   
      </tr>
    </tbody>
</table>
</div>
<?php
echo "<div class='row buttons'><input type='submit' value='Recargar'></div>";
echo CHtml::endForm();
?>
