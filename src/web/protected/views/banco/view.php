<?php
/**
* @var $this BancoController
* @var $model Banco
*/

$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	'Manage',
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
$ingresos=null;
$egresos=0;
?>
<h1>
    <span class="enviar">
        RETESO MOVIMIENTOS <?php echo $model->cUENTA->Nombre; echo " ".$model->Fecha; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoDetail" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonDetail' />
    </span>
</h1>
<?php
    echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
    echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
    echo CHtml::textField('vista','/banco/'.$model->Id,array('id'=>'vista','style'=>'display:none'));
    echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
    echo CHtml::textField('asunto','RETESO MOVIMIENTOS '.$model->cUENTA->Nombre.' '.$model->Fecha,array('id'=>'asunto','style'=>'display:none'));
    echo CHtml::endForm();
    
echo "<form action='";?><?php echo Yii::app()->request->baseUrl; ?><?php echo"/ficheroExcel.php?nombre=RETESO%20MOVIMIENTOS%20".$model->cUENTA->Nombre.'%20'.$model->Fecha."' method='post' target='_blank' id='FormularioExportacion'>
          <input type='hidden' id='datos_a_enviar' name='datos_a_enviar' />
        </form>";
    ?>


<!--<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=RETESO%20MOVIMIENTOS%20<?php echo $model->cUENTA->Nombre.'%20'.$model->Fecha; ?>" method="post" target="_blank" id="FormularioExportacion">
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>-->
<div  rel="total" class="grid-view enviarTabla detalleCuenta">
    <div class="summary"></div>
	<table class="items">
			<tr>
				<th colspan='2'>Banco Credito de Perú</th>
				<th class="titulo">INGRESOS</th>
			</tr>
			<tr class="dis">
				<td colspan='2'>Monto Inicial</td>
				<td><?php echo $model->SaldoApBanco;
				$ingresos=$model->SaldoApBanco;
				?></td>
			</tr>
			
			<?php
			foreach($balances as $key => $balance)
			{
				$ingresos=$ingresos+$balance->MontoBanco;
				if($key%2==0)
				{
					$clase="even";
				}
				else
				{
					$clase="odd";
				}
				echo "<tr class='".$clase."'>
						<td colspan='2'>".$balance->cABINA->Nombre." ( cº. ".$balance->Fecha.")</td>
						<td>".$balance->MontoBanco."</td>
					  </tr>";
			}
			echo "<tr class='dis'>
					<td colspan='2'>Sub-Total</td>
					<td>".$ingresos."</td>
				  </tr>";
			?>
			<tr>
				<th colspan="2" class="banco">Banco Credito de Perú</th>
				<th class="titulo">EGRESOS</th>
			</tr>		
			<?php
			foreach($gastos as $key => $gasto)
			{
				if($key%2==0)
				{
					$clase="even";
				}
				else
				{
					$clase="odd";
				}
				$egresos=$egresos+$gasto->Monto;
				echo "<tr class='".$clase."'>
						<td>".$gasto->cABINA->Nombre."</td>
						<td>".$gasto->tIPOGASTO->Nombre."</td>
						<td>".$gasto->Monto."</td>
					  </tr>";
			}
			$total=$ingresos-$egresos;
			echo "<tr class='dis'>
					<td colspan='2'>Sub-Total</td>
					<td>".$egresos."</td>
				  </tr>
				  <tr class='total'>
				  	<td colspan='2'>Saldo Final</td>
				  	<td>".$total."</td>
				  </tr>";
			?>
	</table>
</div>

