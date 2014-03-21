 <?php

    /**
     * @package reportes
     */
    class retesoMovimiento extends Reportes 
    {
        public static function reporte($id,$name,$type) 
        {
            $ingresos=null;
            $egresos=0;
            $model=Banco::model()->find('Id=:id',array(':id'=>$id));
	    $balances=Balance::model()->findAll('CUENTA_Id=:id AND FechaDep=:fecha',array(':id'=>$model->CUENTA_Id,':fecha'=>$model->Fecha));
	    $gastos=Detallegasto::model()->findAll('FechaTransf=:fecha AND CUENTA_Id=:id',array(':id'=>$model->CUENTA_Id,':fecha'=>$model->Fecha));

            if($model != NULL){
                    $ingresos=$model->SaldoApBanco;
                    $table="<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table width='100%' style=''>
			<tr style='background: #1967B2;color:white;text-align: left;'>
				<th colspan='2' style='text-align: left;'>".htmlentities('Banco Credito de Perú')."</th>
				<th style='text-align: right;'>INGRESOS</th>
			</tr>
			<tr style='background: #ECFBD4'>
				<td colspan='2'>Monto Inicial</td>
				<td style='text-align: right;'> ".Reportes::format($model->SaldoApBanco, $type)."
				
				</td>
			</tr>";
			
			
			foreach($balances as $key => $balance)
			{
				$ingresos=$ingresos+$balance->MontoBanco;
				if($key%2==0)
				{
					$clase="background: #F8F8F8;";
				}
				else
				{
					$clase="background: #E5F1F4;";
				}
                                setlocale(LC_TIME, 'esp');
                                $day = ucwords(strftime("%A", mktime(0, 0, 0, date('d',strtotime($balance->Fecha)))));
				$table.= "<tr style='".$clase."'>
						<td colspan='2'>".htmlentities($balance->cABINA->Nombre." ( cº. ".$balance->Fecha)." / ".utf8_encode($day).") </td>
						<td style='text-align: right;'>".Reportes::format($balance->MontoBanco, $type)."</td>
					  </tr>";
			}
			$table.= "<tr style='background: #ECFBD4'>
					<td colspan='2'>Sub-Total</td>
					<td style='text-align: right;'>".Reportes::format($ingresos, $type)."</td>
				  </tr>";
			
			$table.="<tr style='background: #1967B2;color:white;text-align: left;'>
				<th colspan='2' style='text-align: left;'>".htmlentities('Banco Credito de Perú')."</th>
				<th style='text-align: right;'>EGRESOS</th>
			</tr>";		
			
			foreach($gastos as $key => $gasto)
			{
				if($key%2==0)
				{
					$clase="background: #F8F8F8;";
				}
				else
				{
					$clase="background: #E5F1F4;";
				}
				$egresos=$egresos+$gasto->Monto;
				$table.= "<tr style='".$clase."'>
						<td>".htmlentities($gasto->cABINA->Nombre)."</td>
						<td>".htmlentities($gasto->tIPOGASTO->Nombre)."</td>
						<td style='text-align: right;'>".Reportes::format($gasto->Monto, $type)."</td>
					  </tr>";
			}
			$total=$ingresos-$egresos;
			$table.= "<tr style='background: #ECFBD4'>
					<td colspan='2'>Sub-Total</td>
					<td style='text-align: right;'>".Reportes::format($egresos, $type)."</td>
				  </tr>
				  <tr style='background:#1967B2;color:white;text-align: left;'>
				  	<td colspan='2'>Saldo Final</td>
				  	<td style='text-align: right;'>".Reportes::format($total, $type)."</td>
				  </tr>
			
                    </table>";
            }else{
                $table='Hubo un error';
            }
            return $table;
        }
        
    }
    ?>