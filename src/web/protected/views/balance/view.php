<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	$model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);

$modelView = SaldoCabina::model()->findByPk($model->Id);
$modelDeposito = Deposito::model()->find("FechaCorrespondiente = '$modelView->Fecha' AND CABINA_Id = $modelView->CABINA_Id");
$totalLlamadas = Detalleingreso::getLibroVentas('Llamadas','TotalLlamadas',$modelView->Fecha,$modelView->CABINA_Id);

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
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'Id',
            array(
                'name'=>'Cabina',
                'value'=>$model->cABINA->Nombre,
                ),
            'Fecha',
            array(
                'name'=>'SaldoAp',
                'cssClass'=>'apertura',
                ),
            'SaldoCierre',
            
            /*
            'FijoLocal',
            'FijoProvincia',
            'FijoLima',
            'Rural',
            'Celular',
            'LDI',
            */
            /*
            array(
                'name'=>'Total de llamadas',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI
                    ),
                'cssClass'=>'resaltado',
                ),
            'RecargaCelularMov',
            'RecargaFonoYaMov',
            'RecargaCelularClaro',
            'RecargaFonoClaro',
            array(
                'name'=>'Total en Recargas',
                'value' => Yii::app()->format->formatDecimal(
                    $model->RecargaCelularMov + $model->RecargaCelularClaro + $model->RecargaFonoYaMov + $model->RecargaFonoClaro
                    ),
                'cssClass'=>'resaltado',
                ),
            'OtrosServicios',
            array(
                'name'=>'Total a Depositar',
                'value'=>Yii::app()->format->formatDecimal(
                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI + $model->RecargaCelularMov + $model->RecargaCelularClaro + $model->RecargaFonoYaMov + $model->RecargaFonoClaro + $model->OtrosServicios
                    ),
                'cssClass'=>'resaltado',
                ),
            'MontoDeposito',
            'NumRefDeposito',
            'Depositante',
            'FechaDep',
            'HoraDep',
            'TiempoCierre',
             */
            ),
        )
    );
}
else 
{
    
    

    
    
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
//            'Id',
//            array(
//                'name'=>'Cabina',
//                'value'=>$model->cABINA->Nombre,
//                ),
//            'Fecha',
//            array(
//                'name'=>'SaldoAp',
//                'value'=>SaldoCabina::getSaldoAp($model->Fecha,$model->CABINA_Id),
//                'cssClass'=>'apertura',
//                ),
//            array(
//                'name'=>'SaldoCierre',
//                'value'=>SaldoCabina::getSaldoCierre($model->Fecha,$model->CABINA_Id),
//                'cssClass'=>'apertura',
//                ),
//            array(
//                'name'=>'FijoLocal',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','FijoLocal',$model->Fecha,$model->CABINA_Id),
//                ),
//            array(
//                'name'=>'FijoProvincia',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','FijoProvincia',$model->Fecha,$model->CABINA_Id),
//                ),
//            array(
//                'name'=>'FijoLima',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','FijoLima',$model->Fecha,$model->CABINA_Id),
//                ),
//            array(
//                'name'=>'Rural',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','Rural',$model->Fecha,$model->CABINA_Id),
//                ),
//            array(
//                'name'=>'Celular',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','Celular',$model->Fecha,$model->CABINA_Id),
//                ),
//            array(
//                'name'=>'LDI',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','LDI',$model->Fecha,$model->CABINA_Id),
//                ),
//            array(
//                'name'=>'Total de Llamadas',
//                'value'=>Detalleingreso::getLibroVentas('Llamadas','TotalLlamadas',$model->Fecha,$model->CABINA_Id),
//                'cssClass'=>'resaltado',
//                ),

            
//            'SaldoCierreClaro',
//            'FijoLocal',
//            'FijoProvincia',
//            'FijoLima',
//            'Rural',
//            'Celular',
//            'LDI',
//            array(
//                'name'=>'Total de llamadas',
//                'value'=>Yii::app()->format->formatDecimal(
//                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI
//                    ),
//                'cssClass'=>'resaltado',
//                ),
//            'RecargaCelularMov',
//            'RecargaFonoYaMov',
//            'RecargaCelularClaro',
//            'RecargaFonoClaro',
//            array(
//                'name'=>'Total en Recargas',
//                'value' => Yii::app()->format->formatDecimal(
//                    $model->RecargaCelularMov + $model->RecargaCelularClaro + $model->RecargaFonoYaMov + $model->RecargaFonoClaro
//                    ),
//                'cssClass'=>'resaltado',
//                ),
//            'OtrosServicios',
//            array(
//                'name'=>'Total a Depositar',
//                'value'=>Yii::app()->format->formatDecimal(
//                    $model->FijoLocal + $model->FijoProvincia + $model->FijoLima + $model->Rural + $model->Celular + $model->LDI + $model->RecargaCelularMov + $model->RecargaCelularClaro + $model->RecargaFonoYaMov + $model->RecargaFonoClaro + $model->OtrosServicios
//                    ),
//                'cssClass'=>'resaltado',
//                ),
//            'MontoBanco',
//            'MontoDeposito',
//            'NumRefDeposito',
//            'Depositante',
//            'FechaDep',
//            'HoraDep',
//            'TiempoCierre',
            ),
             
        )
    );
}
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
        <tr class="even">
            <th>Monto Banco (S/.) 'C'</th>
            <td><?php echo Yii::app()->format->formatDecimal($modelDeposito->MontoBanco);?></td>
        </tr>
        <tr class="even">
            <th>Monto Deposito (S/.) 'B'</th>
            <td><?php echo Yii::app()->format->formatDecimal($modelDeposito->MontoDep);?></td>
        </tr>
        <tr class="even">
            <th>Numero de Ref Deposito</th>
            <td><?php echo ($modelDeposito->NumRef == NULL) ? 'No asignado' : $modelDeposito->NumRef;?></td>
        </tr>
        <tr class="even">
            <th>Nombre del Depositante</th>
            <td><?php echo ($modelDeposito->Depositante == NULL) ? 'No asignado' : $modelDeposito->Depositante;?></td>
        </tr>
        <tr class="even">
            <th>Fecha del Deposito</th>
            <td><?php echo $modelDeposito->Fecha;?></td>
        </tr>
        <tr class="even">
            <th>Hora del Deposito</th>
            <td><?php echo $modelDeposito->Hora;?></td>
        </tr>
        <tr class="even">
            <th>Tiempo de Cierre de Cabina (min)</th>
            <td><?php echo ($modelDeposito->TiempoCierre == NULL) ? 'No asignado' : $modelDeposito->TiempoCierre;?></td>
        </tr>

    </tbody>
</table>
 
    
    
    
    
</div>