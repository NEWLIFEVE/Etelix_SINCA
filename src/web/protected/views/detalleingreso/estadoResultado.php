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
             Generar Exportables   <img id="CorreoResumidoER" title="Enviar Consolidado Resumido por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoConsolidado" />
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



    
    
    
  
    
