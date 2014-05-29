<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	$model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetalleingresoController::controlAccesoBalance($tipoUsuario);
//$this->menu=array(
//	array('label'=>'Listar Balance', 'url'=>array('index')),
//	//array('label'=>'Create Balance', 'url'=>array('create')),
//	array('label'=>'Actualizar Balance', 'url'=>array('update', 'id'=>$model->Id)),
//	array('label'=>'Eliminar Balance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Administrar Balance', 'url'=>array('admin')),
//        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
//	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
//	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
//);

$modelView = SaldoCabina::model()->findByPk($model->Id);
$modelDeposito = Deposito::model()->find("FechaCorrespondiente = '$modelView->Fecha' AND CABINA_Id = $modelView->CABINA_Id");
$totalLlamadas = Detalleingreso::getLibroVentas('Llamadas','TotalLlamadas',$modelView->Fecha,$modelView->CABINA_Id);
$background = '';
?>

<h1>Vista General del Balance #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
        
        //$model->SaldoApMov->afterRequiredLabel,
	'data'=>$model,
	'attributes'=>array(
	),
));

?>
<table class="detail-view" id="yw0">
    <tbody>
 
        <tr class="odd">
            <th>ID</th>
            <td><?php echo $modelView->Id;?></td>
        </tr>

        <tr class="even">
            <th>Cabina</th>
            <td><?php echo $modelView->cABINA->Nombre;?></td>
        </tr>

        <tr class="odd">
            <th>Fecha del Balance</th>
            <td><?php echo $modelView->Fecha;?></td>
        </tr>

        <tr class="apertura even">
            <th>Saldo Apertura (S/.)</th>
            <td><?php echo SaldoCabina::getSaldoAp($modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>

        <tr class="apertura odd">
            <th>Saldo Cierre (S/.)</th>
            <td><?php echo SaldoCabina::getSaldoCierre($modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>

        <!-- LLAMADAS -->    
        <tr class="even">
            <th>Fijo Local (S/.)</th>
            <td><?php echo Detalleingreso::getLibroVentas('Llamadas','FijoLocal',$modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>
        <tr class="odd">
            <th>Fijo Provincia (S/.)</th>
            <td><?php echo Detalleingreso::getLibroVentas('Llamadas','FijoProvincia',$modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>
        <tr class="even">
            <th>Fijo Lima (S/.)</th>
            <td><?php echo Detalleingreso::getLibroVentas('Llamadas','FijoLima',$modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>
        <tr class="odd">
            <th>Rural (S/.)</th>
            <td><?php echo Detalleingreso::getLibroVentas('Llamadas','Rural',$modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>
        <tr class="even">
            <th>Celular (S/.)</th>
            <td><?php echo Detalleingreso::getLibroVentas('Llamadas','Celular',$modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>
        <tr class="odd">
            <th>LDI (S/.)</th>
            <td><?php echo Detalleingreso::getLibroVentas('Llamadas','LDI',$modelView->Fecha,$modelView->CABINA_Id);?></td>
        </tr>

        <!-- SERVICIOS REGISTRADOS --> 
        <?php 
        $totalVentas = 0;
        
        $dataIn = TipoIngresos::model()->findAllBySql("SELECT t.Nombre
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        WHERE d.FechaMes = '$modelView->Fecha' 
                                                        AND d.CABINA_Id = $modelView->CABINA_Id 
                                                        AND t.Clase = 1 
                                                        AND t.Id > 8 
                                                        GROUP BY t.Nombre
                                                        ORDER BY d.TIPOINGRESO_Id;");
        
        
        
        if(count($dataIn) > 0){

            foreach ($dataIn as $key => $value) {

                if($key%2 == 0){
                    $background = 'odd';
                }else{
                    $background = 'even';
                }    
                
                $monto = Detalleingreso::getLibroVentas('Servicios',$value->Nombre,$modelView->Fecha,$modelView->CABINA_Id);
                $totalVentas = $totalVentas + $monto;

                echo "<tr class='$background'>
                        <th>".Detalleingreso::changeName($value->Nombre)."</th>
                        <td>".$monto."</td>
                      </tr>";

            }
            
        }else{
            
            echo "<tr class='even'>
                    <th>Ventas FullCarga</th>
                    <td>No Declaradas</td>
                  </tr>";
            
        }

        ?>
        
        <!-- OTROS SERVICIOS --> 
        <tr class="odd">
            <th>Otros Servicios (S/.)</th>
            <td><?php $otroServicios = Detalleingreso::getLibroVentas('LibroVentas','servicio',$modelView->Fecha,$modelView->CABINA_Id);
                      echo $otroServicios;?></td>
        </tr>
        
        <!-- DATOS DEL DEPOSITO --> 
        <tr class="even">
            <th>Monto Deposito (S/.)</th>
            <td><?php echo ($modelDeposito == NULL) ? '0.00' : Yii::app()->format->formatDecimal($modelDeposito->MontoDep); ?></td>
        </tr>
        <tr class="odd">
            <th>Numero de Ref Deposito</th>
            <td><?php if($modelDeposito == NULL || $modelDeposito->NumRef) echo 'No Declarado'; else echo $modelDeposito->NumRef;?></td>
        </tr>
        <tr class="even">
            <th>Monto Banco (S/.)</th>
            <td><?php echo ($modelDeposito == NULL) ? '0.00' : Yii::app()->format->formatDecimal($modelDeposito->MontoBanco); ?></td>
        </tr>
        
        <tr class="odd">
            <th>Conciliacion Bancaria (S/.)</th>
            <td><?php 
            
            if($modelDeposito != NULL)
                echo CicloIngresoModelo::getDifConBancario($modelDeposito->FechaCorrespondiente,$modelDeposito->CABINA_Id,2); 
            else
                echo 'No Declarado';
            
            ?></td>
        </tr>
        
        <tr class="even">
            <th>Trafico Captura Dollar (USD$)</th>
            <td><?php 
            
            if($modelDeposito != NULL)
                echo Detalleingreso::TraficoCapturaDollar($modelDeposito->FechaCorrespondiente,$modelDeposito->CABINA_Id); 
            else
                echo 'No Declarado';
            
            ?></td>
        </tr>
        
        
        
    </tbody>
</table> 
