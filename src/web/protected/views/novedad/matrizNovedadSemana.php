<?php
/**
* @var $this DetallegastoController
* @var $model Detallegasto
*/
$mes=date("Y-m-d");

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
        
$sql="SELECT * FROM cabina WHERE status = 1  AND Id !=18 AND Id !=19 ORDER BY nombre";
$model = Cabina::model()->findAllBySql($sql);
$tipoUsuario=Yii::app()->getModule('user')->user()->tipo;
$this->menu=  NovedadController::controlAcceso($tipoUsuario);
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
        Matriz Total de TT´s por Cabina  
        <?php echo '<font style="font-size:20px;">('.date('Y-m-j',strtotime("-6 day",strtotime($mes))).'/'.$mes.')</font>'; ?>
    </span>
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoMatriz" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelMatriz" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonMatriz' />
    </span>
</h1>
<form name="Detallegasto" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('novedad/matrizNovedadSemana') ?>">
    <div style="float: left;width: 36%;padding-top: 1%;padding-left: 4%;">
        <div style="width: 40em;">
            <div class="buttons" style="float: right;">
                <input type="submit" name="boton" value="Actualizar"/>
                <input type="submit" name="boton" value="Resetear Valores"/>
            </div>
            <label for="dateMonth">
                Seleccione un Día:
            </label>
            <?php
            
            $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                        'language' => 'es', 
                        'model' =>$model,
                        //'value' =>date('d/m/Y',strtotime($model->admission_date)),
                        'attribute'=>'Fecha', 
                        'options' => array(
                        'dateFormat'=>'yy-mm-dd',
                        'changeMonth' => 'true',//para poder cambiar mes
                        'changeYear' => 'true',//para poder cambiar año
                        'showButtonPanel' => 'false', 
                        'constrainInput' => 'false',
                        'showAnim' => 'show',
                        //'minDate'=>'-30D', //fecha minima
                        'maxDate'=> "-0D", //fecha maxima
                         ),
                            'htmlOptions'=>array(
                                'readonly'=>'readonly',
                                'name'=>'formFecha',
                                ),
                    ));
            
            
            ?>  
        </div>
    </div>
</form>
<div style="display: block;">&nbsp;</div>
<div style="display: block;">&nbsp;</div>
<br>
<!--
<div id="mostrarFormulas">
    Leyenda
</div>

<div id="tablaFormulas" class="ocultar">
<table>
    <tr>
        <td> Azul = Soles </td>
    </tr>
    <tr>
        <td> Verde = Dolares </td>
    </tr>
</table>
</div>
-->
<br>
<div id="fecha" style="display: none;"><?php echo '('.date('Y-m-j',strtotime("-6 day",strtotime($mes))).'/'.$mes.')';?></div>
<div id="fecha2" style="display: none;"><?php echo $mes;?></div>

<?php 

    $dia_array = Array();
    for($i=6;$i>=0;$i--){
         
        $dia_array[$i] = date('Y-m-j',strtotime("-$i day",strtotime($mes)));
    } 
    //var_dump($dia_array);
    
    
    ?>

<?php 

if (count($model)> 0) { ?>
<table id="tablaNovedadSemana" class="matrizGastos" border="1" style="border-collapse:collapse;width:auto;">
    <thead>
        
        <th style="background-color: #ff9900;"><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Monitor.png" /></th>
        <?php 
        
        for($i=6;$i>=0;$i--){ 
            if(date("w", strtotime($dia_array[$i])) != 5)
                echo "<th style='background-color: #ff9900;font-size:12px;'><h3>$dia_array[$i]</h3></th>";
            else
                echo "<th style='background-color: #00992B;font-size:12px;'><h3>$dia_array[$i]</h3></th>";
        } 
        
         ?>
        
        <th style='background-color: #ff9900;font-size:12px;'><h3>Total por Cabina</h3></th>
        
</thead>
<tbody>
    <tr style="background-color: #DADFE4;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
 <?php    
 
        $row="<tr style='height: em; background-color: #DADFE4;'>
                <td style='background-color: none;'></td>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>";
 
        foreach ($model as $key => $gasto) {
            $tr="";
            $content="";

            $content.="<td style='width: 200px; background: #1967B2'><h3>$gasto->Nombre</h3></td>";

            for($i=6;$i>=0;$i--){ 
                
              $Total_Fallas = Novedad::getLocutorioTotalesCabinas($gasto->Id,$dia_array[$i]);  
              
              $content.="<td style='width: 80px;color: #; font-size:12px;'>".$Total_Fallas."</td>";
            }
            
            $Total_Cabinas = Novedad::getTotalesCabina($gasto->Id,$dia_array[6],$dia_array[0]);  

            $tr.="<tr id='ordenPago'> 

                 $content   
                 


                 <td style='height: em; background-color: #DADFE4;'>".$Total_Cabinas."</td> 

             </tr>";
            
            echo$tr;

         }
    
    //echo $row;
    
    echo "<tr id='TotalesNovedad'> 
    <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;'><h3>Total por Día</h3></td>";
            
            $TotalTotales = 0;
    
            for($i=6;$i>=0;$i--){ 
                 
                $Totales =  Novedad::getTotalesDias($dia_array[$i]);
                $TotalTotales = $TotalTotales + $Totales;
                echo "<td style='width: 80px;color: #;background-color: #DADFE4; font-size:12px;'>".$Totales."</td>";
             }    
                 
           echo "<td style='color: #FFFFFF; height: em; background-color: #1967B2;'>".$TotalTotales."</td></tr>";      

    ?>
    
    
</tbody>
</table>
<?php }?>

