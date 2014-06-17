<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m");

if(isset($_POST["boton"]) && $_POST["boton"]== "Resetear Valores")
{
    Yii::app()->user->setState('mesSesionMS',date("Y-m-d"));
}
else
{
    if(isset($_POST["formFecha"]) && $_POST["formFecha"] != "")
    {
        Yii::app()->user->setState('mesSesionMS',$_POST["formFecha"]);
        $mes=Yii::app()->user->getState('mesSesionMS');
    }
    elseif(strlen(Yii::app()->user->getState('mesSesionMS')) && Yii::app()->user->getState('mesSesionMS')!="")
    {
        $mes = Yii::app()->user->getState('mesSesionMS');
    } 
}

$año = date("Y", strtotime($mes)); 
$mes2 = date("m", strtotime($mes));
        
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu= DetalleingresoController::controlAcceso($tipoUsuario);
?>
<script>
    $(document).ready(function(){
        $("#mostrarFormulas").click(function(){
            $("#tablaFormulas").slideToggle("slow");
        });
    });
</script>
<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>
<h1>
    <span class="enviar">
        Estado de Resultados  
        <?php echo $mes != NULL ?" - ". Utility::monthName($mes.'-01').' '.$año : ""; ?>
    </span>
    <!--
    <span>
        <img title="Enviar por Correo" src="<?php //echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoConsolidado" />
        <img title="Exportar a Excel" src="<?php //echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelConsolidado" />
    </span>
    -->
</h1>
<div id="cicloingresosbotons">
    <div id="botonsExport">
    <ul>
        <li style="width: 200px;">
             Por Cabinas   <img id="CorreoResumido" title="Enviar Consolidado Resumido por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoConsolidado" />
                           <img id="ExcelCabina" title="Exportar Consolidado Resumido a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelConsolidado" />
        </li>
        <li style="width: 200px;display: none;">
           
                Completo   <img id="CorreoCompleto" title="Enviar Consolidado Completo por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoConsolidado" />
                           <img id="ExcelMeses" title="Exportar Consolidado Completo a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelConsolidado" />
        </li>
    </ul>
    <div>
        <form name="Resultado" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('detalleingreso/estadoResultado') ?>">
            <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
                <div style="width: 40em;">
                    <div class="buttons" style="float: right;">
                        <input type="submit" name="boton" value="Actualizar"/>
                        <input type="submit" name="boton" value="Resetear Valores"/>
                    </div>
                    <label for="dateMonth">
                        Seleccione un Mes:
                    </label>
                    <input type="text" id="dateMonth" name="formFecha" size="30" readonly/>  
                </div>
            </div>
        </form>
    </div>
    </div>
</div>

<div style="display: block;">&nbsp;</div>
<div style="display: block;">&nbsp;</div>
<br>

<br>
<div id="fecha" style="display: none;"><?php echo $mes != NULL ? date('Ym',strtotime($mes)): "";?></div>
<div id="fecha2" style="display: none;"><?php echo $mes;?></div>


<div style="width: 100%;">

    <div class="linked" style="width: 90px;float: left;height:513px; ">

    <table id="estadoResultado" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
        <thead class="scrollTable">
            <th style="background-color: #ff9900;height: 32px;"><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></th>

        </thead>
        <tbody class="scrollTable">
            <?php

                $i = 0;
                $arrayIngresos = Array('Ingresos Llamadas','Ingresos Por Servicios','Ingresos Servicios Movistar',
                                     'Ingresos Servicios Claro','Ingresos Servicios DirecTv','Ingresos Servicios Nextel',
                                     'Ingresos Varios (Subarriendos)');

                $arrayMargen = Array('Ingresos Llamadas','Ingresos Por Servicios','Ingresos Servicios Movistar',
                                     'Ingresos Servicios Claro','Ingresos Servicios DirecTv','Ingresos Servicios Nextel',
                                     'Ingresos Varios (Subarriendos)');

                $arrayEgresos = Array('Alquiler Local','Nomina','Servicios Generales',
                                     'Otros Gastos (Rep, Mto., Reemplazo Eq.)');    

                $arrayImpuesto = Array('Osiptel (0.5% de las Vts Llamadas)','Fitel (1% de las Vts Llamadas)',
                                       'MTC (0.5% de las Vts Llamadas)','Sunat (IGV)',
                                       'Sunat (Renta 3era) (1.5% de las Vtas TOTALES)','Arbitrios',
                                        'Otros Impuestos');

    //----------INGRESOS
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 29px;'>"
                                    . "<h3 style='color: #000000;'>INGRESOS</h3>"
                            . "</td>"
                        ."</tr>";

                for($i=0;$i<7;$i++){

                    echo "<tr>"
                            . "<td rowspan='1' style='width: 200px; background: #1967B2;height: 51px;'>"
                                    . "<h3>$arrayIngresos[$i]</h3>"
                            . "</td>"
                        ."</tr>";

                }

    //----------MARGEN
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>MARGEN OPERATIVO BRUTO</h3>"
                            . "</td>"
                        ."</tr>";

                for($i=0;$i<7;$i++){

                    echo "<tr>"
                            . "<td rowspan='1' style='width: 200px; background: #1967B2;height: 51px;'>"
                                    . "<h3>$arrayMargen[$i]</h3>"
                            . "</td>"
                        ."</tr>";

                }

    //----------EGRESOS
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>EGRESOS</h3>"
                            . "</td>"
                        ."</tr>";

                for($i=0;$i<4;$i++){

                    echo "<tr>"
                            . "<td rowspan='1' style='width: 200px; background: #1967B2;height: 51px;'>"
                                    . "<h3>$arrayEgresos[$i]</h3>"
                            . "</td>"
                        ."</tr>";

                }

    //----------TOTAL EBITDA
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>TOTAL EBITDA</h3>"
                            . "</td>"
                        ."</tr>";


    //----------IMPUESTOS (Alicuota sobre las ventas)
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>IMPUESTOS (Alicuota sobre las ventas)</h3>"
                            . "</td>"
                        ."</tr>";

                for($i=0;$i<7;$i++){

                    echo "<tr>"
                            . "<td rowspan='1' style='width: 200px; background: #1967B2;height: 51px;'>"
                                    . "<h3>$arrayImpuesto[$i]</h3>"
                            . "</td>"
                        ."</tr>";

                }     

    //----------Ganancia Neta (Sin Merma Ciclo de Ingreso)
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>Ganancia Neta (Sin Merma Ciclo de Ingreso)</h3>"
                            . "</td>"
                        ."</tr>";

    //----------AJUSTE POR CICLO DE INGRESOS
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>AJUSTE POR CICLO DE INGRESOS</h3>"
                            . "</td>"
                        ."</tr>";


    //----------GANANCIA TOTAL NETA
                echo "<tr style='height: em; background-color: #DADFE4; color: #000000;'>"
                            . "<td style='height: 51px;'>"
                                    . "<h3 style='color: #000000;'>GANANCIA TOTAL NETA</h3>"
                            . "</td>"
                        ."</tr>";





            ?>
        </tbody>
    </table>



    </div>


    <div class="linked" style="float: left;width: 830px;overflow-y: hidden;height:513px;">

    <table id="estadoResultado" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
        <thead class="scrollTable">
            <!--<th style="background-color: #ff9900;"><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></th>-->
            <?php 

            $nombre_cabinas = Cabina::model()->findAllBySQL("SELECT Id, Nombre FROM cabina 
                                           WHERE status = 1  AND Id !=18 AND Id !=19
                                          ORDER BY Nombre = 'COMUN CABINA', Nombre;");

            foreach ($nombre_cabinas as $key => $value) {
                $cabinass[$key] = $value->Nombre;
                echo "<th style='background-color: #ff9900;height: 32px;'><h3>".$cabinass[$key]."</h3></th>";
            }

            ?>

    </thead>
    <tbody class="scrollTable" style="overflow: hidden;width: 100%;">

        <?php

            $paridad = Paridad::model()->findBySql("SELECT Valor FROM paridad WHERE Fecha <= '$mes-31' ORDER BY Fecha DESC LIMIT 1;")->Valor;
            
            for($i=0;$i<65;$i++) {
                $tr="";
                $content="";
                $count = 0;
                $traficoTotal = 0;
                $traficoTotalDollar = 0;

                foreach ($nombre_cabinas as $key => $cabina) {
                    
                    $trafico = Detalleingreso::getDataFullCarga($mes,$cabina->Id,5);
                    $traficoSoles = $trafico;
                    $traficoTotal = $traficoTotal + $trafico;
                    $traficoDollar = round(($traficoSoles/$paridad),2);
                    $traficoTotalDollar = $traficoTotalDollar + round(($trafico/$paridad),2);

                    $servMov = Detalleingreso::getDataFullCarga($mes,$cabina->Id,1);
                    $servClaro = Detalleingreso::getDataFullCarga($mes,$cabina->Id,2);
                    $servDirecTv = Detalleingreso::getDataFullCarga($mes,$cabina->Id,4);
                    $servNextel = Detalleingreso::getDataFullCarga($mes,$cabina->Id,3);
                    $subArriendo = Detalleingreso::getDataFullCarga($mes,$cabina->Id,'SubArriendos');

                    $servMovDollar = round(($servMov/$paridad),2);
                    $servClaroDollar = round(($servClaro/$paridad),2);
                    $servDirecTvDollar = round(($servDirecTv/$paridad),2);
                    $servNextelDollar = round(($servNextel/$paridad),2);
                    $subArriendoDollar = round(($subArriendo/$paridad),2);
                    
                    $ventas = round(($servMovDollar + $servClaroDollar + $servDirecTvDollar + $servNextelDollar),2);
                    $ingresosTotal = ($traficoDollar+$ventas+$subArriendoDollar);

                    //INGRESOS
                    if($i == 0){
                        $content.="<td style='background-color: #DADFE4;height: 29px;vertical-align: middle;text-align: right;margin-bottom: 0px;font-size: 10px;'>
                                        $".$ingresosTotal."
                                   </td>";
                    }elseif($i == 16 || $i == 32 || $i == 42 || $i == 44 || $i == 60 || $i == 62 || $i == 64 || $i == 65){
                        $content.="<td style='background-color: #DADFE4;height: 51px;vertical-align: middle;text-align: right;margin-bottom: 0px;font-size: 10px;'>
                                        $i
                                   </td>";
                    }else{
                        if($i == 2){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: right;margin-bottom: 0px;font-size: 10px;'>
                                        $".$traficoDollar."
                                   </td>";
                        }
                        if($i == 4){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: right;margin-bottom: 0px;font-size: 10px;'>
                                        $".$ventas."
                                   </td>";
                        }
                        if($i == 6){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: left;margin-bottom: 0px;font-size: 10px;'>
                                        $".$servMovDollar."
                                   </td>";
                        }
                        if($i == 8){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: left;margin-bottom: 0px;font-size: 10px;'>
                                        $".$servClaroDollar."
                                   </td>";
                        }
                        if($i == 10){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: left;margin-bottom: 0px;font-size: 10px;'>
                                        $".$servDirecTvDollar."
                                   </td>";
                        }
                        if($i == 12){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: left;margin-bottom: 0px;font-size: 10px;'>
                                        $".$servNextelDollar."
                                   </td>";
                        }
                        if($i == 14){
                        $content.="<td style='height: 51px;vertical-align: middle;text-align: right;margin-bottom: 0px;font-size: 10px;'>
                                        $".$subArriendoDollar."
                                   </td>";
                        }
                    }


                    $count++;




                }

                $i++;

                $tr.="<tr id='ordenPago'> 

                 $content ";


    //             $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;'></td>";
    //             $tr.="<td style='width: 80px;color: #FFF; background: none; font-size:10px;'></td>";


                $tr.="</tr>";

                echo $tr;

            }    

        ?>


    </tbody>

    </table>
        

    </div>
    
    
    
</div>    
    
