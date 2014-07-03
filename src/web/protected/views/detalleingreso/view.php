<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	$model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetalleingresoController::controlAccesoBalance($tipoUsuario);

$modelView = SaldoCabina::model()->findByPk($model->Id);
$modelDeposito = Deposito::model()->find("FechaCorrespondiente = '$modelView->Fecha' AND CABINA_Id = $modelView->CABINA_Id");
$totalLlamadas = Detalleingreso::getLibroVentas('Llamadas','TotalLlamadas',$modelView->Fecha,$modelView->CABINA_Id);
$background = '';
?>
<h1>
    <span class="enviar">
        Detalle del Ingreso # <?php echo $model->Id; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoDetail" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelDetail" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonDetail' />
    </span>
</h1>
<?php
    echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
    echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
    echo CHtml::textField('vista','view/'.$model->Id,array('id'=>'vista','style'=>'display:none'));
    echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
    echo CHtml::textField('asunto','Vista General del Balance # '.$model->Id.' Solicitado',array('id'=>'asunto','style'=>'display:none'));
    echo CHtml::endForm();
?>

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Detalle%20Balance" method="post" target="_blank" id="FormularioExportacion">
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<div id="detail" class="enviarTabla">
<?php
if(Yii::app()->getModule('user')->user()->tipo == '1')
{
    $this->widget('zii.widgets.CDetailView', array('data'=>$model,'attributes'=>array(),));
    
    
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

        <!-- TOTAL LLAMADAS --> 
        <tr class="resaltado even">
            <th>Total de Llamadas</th>
            <td><?php echo $totalLlamadas;?></td>
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
                                                        AND t.Id > 9 
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
                        <th>".$value->Nombre."</th>
                        <td>".$monto."</td>
                      </tr>";

            }
            
        }else{
            
            echo "<tr class='$background'>
                    <th>Ventas FullCarga</th>
                    <td>No Declaradas</td>
                  </tr>";
            
        }

        ?>
        
        <!-- TOTAL SERVICIOS --> 
        <tr class="resaltado even">
            <th>Total en Ventas FullCarga</th>
            <td><?php echo Yii::app()->format->formatDecimal($totalVentas);?></td>
        </tr>
        
        <!-- OTROS SERVICIOS --> 
        <tr class="even">
            <th>Otros Servicios (S/.)</th>
            <td><?php $otroServicios = Detalleingreso::getLibroVentas('LibroVentas','servicio',$modelView->Fecha,$modelView->CABINA_Id);
                      echo $otroServicios;?></td>
        </tr>
        
        <!-- TOTAL A DEPOSITAR --> 
        <tr class="resaltado even">
            <th>Total a Depositar</th>
            <td><?php echo  Yii::app()->format->formatDecimal($totalVentas+$totalLlamadas+$otroServicios);?></td>
        </tr>
        
        <!-- DATOS DEL DEPOSITO --> 
        <tr class="odd">
            <th>Monto Deposito (S/.) 'B'</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->MontoDep == NULL){
                    echo 'No asignado';
                }else{
                    echo Yii::app()->format->formatDecimal($modelDeposito->MontoDep);
                }
            }

            ?></td>
        </tr>
        <tr class="even">
            <th>Numero de Ref Deposito</th>
            <td><?php 

            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->NumRef == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->NumRef;
                }
            }
            
            ?></td>
        </tr>
        <tr class="odd">
            <th>Nombre del Depositante</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->Depositante == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->Depositante;
                }
            }

            ?></td>
        </tr>
        <tr class="even">
            <th>Fecha del Deposito</th>
            <td><?php 

            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->Fecha == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->Fecha;
                }
            }

            ?></td>
        </tr>
        <tr class="odd">
            <th>Hora del Deposito</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->Hora == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->Hora;
                }
            }
            

               ?></td>
        </tr>
        <tr class="even">
            <th>Tiempo de Cierre de Cabina (min)</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->TiempoCierre == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->TiempoCierre;
                }
            }

            ?></td>
        </tr>

    </tbody>
</table>    
    
<?php    

}
else 
{
    
$this->widget('zii.widgets.CDetailView', array('data'=>$model,'attributes'=>array(),));

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

        <!-- TOTAL LLAMADAS --> 
        <tr class="resaltado even">
            <th>Total de Llamadas</th>
            <td><?php echo $totalLlamadas;?></td>
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
                                                        AND t.Id > 9 
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
                        <th>".$value->Nombre." (S/.)</th>
                        <td>".$monto."</td>
                      </tr>";

            }
            
        }else{
            
            echo "<tr class='$background'>
                    <th>Ventas FullCarga (S/.)</th>
                    <td>No Declaradas</td>
                  </tr>";
            
        }

        ?>
        
        <!-- TOTAL SERVICIOS --> 
        <tr class="resaltado even">
            <th>Total en Ventas FullCarga</th>
            <td><?php echo Yii::app()->format->formatDecimal($totalVentas);?></td>
        </tr>
        
        <!-- OTROS SERVICIOS --> 
        <tr class="even">
            <th>Otros Servicios (S/.)</th>
            <td><?php $otroServicios = Detalleingreso::getLibroVentas('LibroVentas','servicio',$modelView->Fecha,$modelView->CABINA_Id);
                      echo $otroServicios;?></td>
        </tr>
        
        <!-- TOTAL A DEPOSITAR --> 
        <tr class="resaltado even">
            <th>Total a Depositar</th>
            <td><?php echo  Yii::app()->format->formatDecimal($totalVentas+$totalLlamadas+$otroServicios);?></td>
        </tr>
        
        <!-- DATOS DEL DEPOSITO --> 
        <tr class="even">
            <th>Monto Banco (S/.) 'C'</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->MontoBanco == NULL){
                    echo 'No asignado';
                }else{
                    echo Yii::app()->format->formatDecimal($modelDeposito->MontoBanco);
                }
            }

            ?></td>
        </tr>
        <tr class="odd">
            <th>Monto Deposito (S/.) 'B'</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->MontoDep == NULL){
                    echo 'No asignado';
                }else{
                    echo Yii::app()->format->formatDecimal($modelDeposito->MontoDep);
                }
            }

            ?></td>
        </tr>
        <tr class="even">
            <th>Numero de Ref Deposito</th>
            <td><?php 

            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->NumRef == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->NumRef;
                }
            }
            
            ?></td>
        </tr>
        <tr class="odd">
            <th>Nombre del Depositante</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->Depositante == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->Depositante;
                }
            }

            ?></td>
        </tr>
        <tr class="even">
            <th>Fecha del Deposito</th>
            <td><?php 

            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->Fecha == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->Fecha;
                }
            }

            ?></td>
        </tr>
        <tr class="odd">
            <th>Hora del Deposito</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->Hora == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->Hora;
                }
            }
            

               ?></td>
        </tr>
        <tr class="even">
            <th>Tiempo de Cierre de Cabina (min)</th>
            <td><?php 
            
            if($modelDeposito == NULL){
                echo 'No asignado';
            }else{
                if($modelDeposito->TiempoCierre == NULL){
                    echo 'No asignado';
                }else{
                    echo $modelDeposito->TiempoCierre;
                }
            }

            ?></td>
        </tr>
    </tbody>
</table>    
    
<?php    

}

?>


    

 
    
    
    
    
</div>