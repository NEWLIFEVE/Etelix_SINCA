<?php

date_default_timezone_set('America/Caracas');

$horaMostrarCaracas = "Hora Actual: ".date("h:i:s A",time())." Caracas / Venezuela.";

date_default_timezone_set('America/Lima');

/* BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA PARA VALIDAR QUE NO EXISTA */
$sql = "SELECT id,Nombre FROM cabina WHERE status = 1 AND Id NOT IN  (18,19) ORDER BY Nombre";
$connection0 = Yii::app()->db;
$command0 = $connection0->createCommand($sql);
$cabinas = $command0->query(); // execute a query SQL

$dias = array('Sun' => 'Domingo', 'Mon' => 'Lunes','Tue' => 'Martes','Wed' => 'Miercoles','Thu' => 'Jueves','Fri' => 'Viernes','Sat' => 'Sabado');

//$connection01 = Yii::app()->db;
$command01 = $connection0->createCommand($sql);
$cabinas1 = $command01->query(); // execute a query SQL

//$connection02 = Yii::app()->db;
$command02 = $connection0->createCommand($sql);
$cabinas2 = $command02->query(); // execute a query SQL

if(!isset($_POST["formFecha"]) || $_POST["formFecha"]==""){
    
    list($year, $mon, $day) = explode('-', date("Y-m-d", time()));
    $fechaActual = date('Y-m-d', mktime(0, 0, 0,$mon, $day, $year));
    $fechaAyer = date('Y-m-d', mktime(0, 0, 0,$mon, $day-1, $year));
    $fechamostrar = date('d/m/Y', mktime(0, 0, 0,$mon , $day, $year));
    $diaMostrar = $dias[date('D',mktime(0, 0, 0,$mon , $day, $year))];
    $horamostrar = "Hora Actual: ".date("h:i:s A",time())." Lima / Per&uacute;.";
    
}
elseif(isset($_POST["formFecha"])){

    $date = $_POST["formFecha"];
    list($year2, $mon2, $day2) = explode('-', $_POST["formFecha"]);
    list($year, $mon, $day) = explode('-', $_POST["formFecha"]);
    $fechaActual = date('Y-m-d', mktime(0, 0, 0,$mon, $day, $year));
    $fechaAyer = date('Y-m-d', mktime(0, 0, 0,$mon, $day-1, $year));
    $fechamostrar = date('d/m/Y', mktime(0, 0, 0,$mon2 , $day2, $year2));
    $diaMostrar = $dias[date('D',mktime(0, 0, 0,$mon2 , $day2, $year2))];
    $horamostrar = "Hora Actual: ".date("h:i:s A",time())." Lima / Per&uacute;.";

}

if (date("H",time())<6 && !isset($_POST["formFecha"])){
    list($year, $mon, $day) = explode('-', date("Y-m-d", time()));
    
    $fechaActual = date('Y-m-d', mktime(0, 0, 0,$mon, $day - 1, $year));
    $fechaAyer = date('Y-m-d', mktime(0, 0, 0,$mon, $day-2, $year));
    $fechamostrar = date('d/m/Y', mktime(0, 0, 0,$mon , $day - 1, $year));
    $diaMostrar = $dias[date('D',mktime(0, 0, 0,$mon , $day - 1, $year))];
    $horamostrar = "Hora Actual: ".date("h:i:s A",time())." Lima / Per&uacute;.";
    
}
$codigo = array();
$nombre = array();
for ($i = 1; $i <= $cabinas1->count(); $i++) {
    $codigo[$i]  = $cabinas1->readColumn(0);
    $nombre[$i]  = $cabinas2->readColumn(1);
}
//$cabinas->rewind();
//for ($i = 1; $i <= $cabinas->count(); $i++) {
//    $nombre[$i]  = $cabinas->readColumn(1);  
//}

Yii::import('webroot.protected.controllers.CabinaController');

$this->breadcrumbs=array(
        'Balances'=>array('index'),
        'Manage',     
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>

<head>
  <meta charset="utf-8" />
  <title>jQuery UI Datepicker - Format date</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
<script>

    $(function() {
        
        $( "#datepicker" ).datepicker();
        $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        
    });
  
    $(function($){
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });

    $(document).ready(function(){

        $("#mostrarReglas").click(function(){
            $("#tablaReglas").slideToggle("slow");
        });
        
        $("#mostrarHorario").click(function(){
            $("#tablaHorarios").slideToggle("slow");
        });

    });

  </script>
</head>


<input id="fecha_hidden" type="hidden" value="<?php echo $fechamostrar; ?>" />
<?php
echo CHtml::beginForm(Yii::app()->createUrl('balance/enviarEmail'),'post',array('name'=>'FormularioCorreo','id'=>'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html','Hay Efectivo',array('id'=>'html','style'=>'display:none'));
echo CHtml::textField('vista','controlPanel',array('id'=>'vista','style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto','Tablero de Control de Actividades Solicitado',array('id'=>'asunto','style'=>'display:none'));
echo CHtml::endForm();

?>

<div id="nombreContenedor" class="black_overlay"></div>
<div id="loading" class="ventana_flotante"></div>
<div id="complete" class="ventana_flotante2"></div>
<div id="error" class="ventana_flotante3"></div>

<div id="fecha" style="display: none;"><?php echo $date != NULL ? date('Ymd',strtotime($date)): date("Ymd", time());?></div>
<div id="fecha2" style="display: none;"><?php echo $date != NULL ? $date: "";?></div>

<h1>
    <span class="enviar">
    Tablero de Control de Actividades
    </span>
    <span>
    <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/mail.png" class="botonCorreoPanel" />
    <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/excel.png" class="botonExcelPanel" />
    <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/print.png' class='printButtonPanel' />
    </span>
</h1> 
<div id="enviar" rel="total">
    <div>
        <div>
            <div style="float: left;">D&iacute;a: <?php echo CHtml::label($diaMostrar, 'diaSemana', array('id' => 'diaSemana', 'style' => 'color:forestgreen')) . ' ' . $fechamostrar; ?></div>
            <div class="filters" style="float: right;">
                <form class="filters" method="post" action="<?php Yii::app()->createAbsoluteUrl('balance/controlPanel') ?>">
                    <label for="datepicker" class="filters">
                        Seleccione un d&iacute;a:
                    </label>
                    <input type="text" class="filters" id="datepicker" name="formFecha" size="30" readonly/>
                    <span class="buttons">
                        <input type="submit" class="filters" value="Actualizar"/>
                    </span>
                </form>
            </div>
        </div>
        <div>
            <!-- Leyenda de las Reglas de Declaracion -->
            <div style="width: 56%;float: left;" class="filters">&nbsp;</div>
            <div style="width: 60%;float: right;" class="filters">
                <div style="padding-top: 5%;" class="filters"></div>
                <div id="mostrarReglas" class="filters">
                    Reglas de declaraci&oacute;n
                </div>
                <div id="tablaReglas" class="ocultar filters">
                    <table class="filters">
                        <tr>
                            <td> Las Declaraciones de 'Saldo Apertura' y 'Ventas' son hasta las 12:00pm. </td>
                        </tr>
                        <tr>
                            <td> Las Declaraciones de 'Depósitos' son hasta las 3:00pm. </td>
                        </tr>
                        <tr>
                            <td> Debe declarar solo un Deposito correspondiente al día, en el
                                caso que el pago de ese día se haya efectuado a través de
                                varios Depósitos, declare la suma de los montos en el campo
                                'Monto Deposito' y declare los diferentes num de referencia
                                separados por una coma (,) en el campo 'Monto de Ref. Deposito'.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Leyenda del Horario de las Cabinas -->
            <div style="width: 60%;float: right;" class="filters">
                <div style="padding-top: 2%;" class="filters"></div>
                <div id="mostrarHorario" class="filters">
                    Horario de trabajo de las cabinas
                </div>
                <div id="tablaHorarios" class="ocultar filters">
                    <table class="filters">
                        
                        <tr >
                            <td> Cabina </td> 
                            <td> Hora Inicio </td> 
                            <td> Hora Fin </td> 
                            <td> Hora Inicio Domingo </td> 
                            <td> Hora Fin Domingo</td>
                        </tr>
                        
                        <?php 
                        
                        $modelHours = Cabina::model()->findAll('status=:status AND Nombre!=:nombre AND Nombre!=:nombre2 ORDER BY nombre',array(':status'=>'1', ':nombre'=>'ZPRUEBA', ':nombre2'=>'COMUN CABINA'));
                        
                        foreach ($modelHours as $key => $hours) {
                            
                        
                        ?>
                        
                        <tr>
                            <td> <?php echo $hours->Nombre; ?> </td> 
                            <td> <?php echo $hours->HoraIni; ?> </td> 
                            <td> <?php echo $hours->HoraFin; ?> </td> 
                            <td> <?php echo $hours->HoraIniDom; ?> </td> 
                            <td> <?php echo $hours->HoraFinDom; ?> </td>
                        </tr>
                        
                        <?php 
                        
                        }
                        
                        ?>
                        
                    </table>
                </div>
            </div>
            <div style="width: 56%;float: left;" class="filters">&nbsp;</div>
        </div>
    </div>
    <br/>
    <br/>
    <?php echo $horamostrar; ?>
    <br/>
    <br/>
    <?php echo $horaMostrarCaracas; ?>
    <br/>
    <br/>
<?php if ($model !== null) { ?>
<table id="tabla3" class="tabla2 items" border="1" style="background-color:#F2F4F2; border-collapse:collapse;width:100%;">
    <tr>
        <td style='font-weight:bold; background: #1967B2' ><span style="background: url("<?php echo Yii::app()->theme->baseUrl; ?>/img/footer_bg.gif&quot;) repeat scroll 0 0 #2D2D2D;"><img style="padding-left: 24px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/Activity-w.png" /></span></td>
        <td style='width: 120px; font-weight:bold; background: #1967B2;' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'><?php //echo $fechaActual.' '; ?>Inicio Jornada</h3></td>
        <td style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Saldo Apertura</h3></td>
        <td style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Ventas Llamadas</h3></td>
        <td style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Depositos</h3></td>
        <td style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Saldo Cierre</h3></td>
        <td style='width: 120px; font-weight:bold; background: #1967B2' ><h3 align="center" style='font-size:14px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Fin Jornada</h3></td>
    </tr>
    <tr>
<?php for ($i = 1; $i <= $cabinas->count(); $i++) {
                $sqlCP1 = "SELECT DISTINCT(DATE_FORMAT(l.Hora, '%H:%i')) as HORA FROM log l, users u 
WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina ORDER BY HORA ASC";
                
                $sqlCP = "SELECT DISTINCT(DATE_FORMAT(l.Hora, '%H:%i')) as HORA FROM log l, users u 
WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.FechaEsp = :fechaesp and l.USERS_Id = u.Id and u.CABINA_Id = :cabina ORDER BY HORA ASC";
                
                $sqlCP2 = "SELECT DISTINCT(DATE_FORMAT(l.Hora, '%H:%i')) as HORA FROM log l, users u 
WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina and l.hora > '19:00:00'";

                $sqlCP3 = Cabina::model()->findBySql("SELECT Id, Nombre, HoraIni, HoraFin, HoraIniDom, HoraFinDom FROM cabina WHERE Id = $codigo[$i]");
                
                
    $post = $model->find('CABINA_Id = :id and Fecha = :fecha', array(':id' => $i, ':fecha' => $fechaActual));
    ?><tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
        <td style='font-size:10px; font-weight:bold; color:#FFFFFF; background: #1967B2' >
                <div align="center" style="width:80px;"><?php echo $nombre[$i];//$cabinas->readColumn(1); ?></div>
        </td>
        
            <td><?php 
/********************************INICIO JORNADA*******************************************************/
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP1);
                $command->bindValue(":cabina", $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(":accion", 9); // bind de parametro cabina del user
                $command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    ?>
                
                    <!-- COMPARA LA HORA DE INICIO DE JORDADA CON LA HORA DE INICIO NORMAL DE LA CABINA -->
                    <?php $hora = $id->readColumn(0); 
                          if(($diaMostrar != 'Domingo' && $hora <= $sqlCP3->HoraIni) || ($diaMostrar == 'Domingo' && $hora <= $sqlCP3->HoraIniDom)){                               ?>
                                <div align="center" style="color:#36C; font-family:'Trebuchet MS', cursive; font-size:20px;"><?php echo $hora; ?></div>
                    <?php }else{  ?>
                                <div align="center" style="color:#ff9900; font-family:'Trebuchet MS', cursive; font-size:20px;"><img src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/warning.png' style="width:16px;height: 16px;"/> <?php echo $hora; ?></div>
                    <?php }  ?> 
                     
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                     <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">08:00:00</td>-->
                    <?php
                }?>
            </td>
            <td><?php 
/********************************SALDO APERTURA*******************************************************/            
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP1);
                $command->bindValue(":cabina", $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(":accion", 2); // bind de parametro cabina del user
                $command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                //$command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
            
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                    <?php
                }?>
            </td>
            
<!--            <td><?php if ($post->SaldoApMov !== null) {
                ?>
                    <div align="center"><img  src="<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                    <?php }
                    ?>
            </td>-->
            
            <td><?php 
/********************************LLAMADAS*******************************************************/
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP);
                $command->bindValue(":cabina", $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(":accion", 3); // bind de parametro cabina del user
                $command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario 
                $command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
            
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                     <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">08:00:00</td>-->
                    <?php
                }?>
            </td>
            
            <!--<td><?php if ($post->FechaIngresoLlamadas !== null) {
                ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                    <?php }
                    ?>            
            </td>-->
            
            <td><?php 
/********************************DEPOSITOS*******************************************************/
            
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP);
                $command->bindValue(":cabina", $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(":accion", 4); // bind de parametro cabina del user
                $command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario  
                $command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
            
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                     <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">08:00:00</td>-->
                    <?php
                }?>
            </td>
            
<!--            <td><?php if ($post->FechaIngresoDeposito !== null) {
                ?>
                    <div align="center"><img src=""<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
                <?php } else { ?>
                   <div align="center"> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                    <?php }
                    ?>            
            </td>-->
            
            <td><?php 
/********************************SALDO CIERRE*******************************************************/
           
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP1);
                $command->bindValue(":cabina", $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(":accion", 8); // bind de parametro cabina del user
                $command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario   
                //$command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/si.png"></div>
            
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                     <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">08:00:00</td>-->
                    <?php
                }?>
            </td>
            
<!--            <td><?php if ($post->SaldoCierreMov !== null) {
                ?>
                    <div align="center"><img src="http://fullredperu.com/images/check-icon.png"></div>
                <?php } else { ?>
                    <div align="center"><img src="http://fullredperu.com/images/no-icon.png"></div>
                    <?php }
                    ?>            
            </td>-->
            
            <td><?php 
/********************************FIN JORNADA*******************************************************/
         
                $connection2 = Yii::app()->db;
                $command2 = $connection2->createCommand($sqlCP2);
                $command2->bindValue(":cabina", $codigo[$i]); // bind de parametro cabina del user
                $command2->bindValue(":accion", 10); // bind de parametro cabina del user
                $command2->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                $id2 = $command2->query(); // execute a query SQL
                if ($id2->count()) {
                    ?>
                    
                    <!-- COMPARA LA HORA DE FIN DE JORDADA CON LA HORA DE FIN NORMAL DE LA CABINA -->
                    <?php $hora2 = $id2->readColumn(0); 
                          if(($diaMostrar != 'Domingo' && $hora2.':00' < $sqlCP3->HoraFin) || ($diaMostrar == 'Domingo' && $hora2.':00' < $sqlCP3->HoraFinDom)){  ?>
                                <div align="center" style="color:#ff9900; font-family:'Trebuchet MS', cursive; font-size:20px;"><img src='<?php echo Yii::app()->request->baseUrl; ?>/themes/mattskitchen/img/warning.png' style="width:16px;height: 16px;"/> <?php echo $hora2; ?></div>
                   <?php }else{  ?>
                                <div align="center" style="color:#36C; font-family:'Trebuchet MS', cursive; font-size:20px;"><?php echo $hora2; ?></div>
                    <?php }  ?> 
                                
                                
                <?php } else { ?>
                    <div align="center"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/no.png"></div>
                    <?php
                } ?>            
            </td>
        </tr>

<?php } ?>
</table>
<?php }?>
</div>
<div class="ocultar">
    <div id="reglasCorreo">
        <div style="background-color:green;color:#fff;font-size:1em;font-weight:bold;padding: 1% 0 1% 1%;">
            Reglas de declaraci&oacute;n
        </div>
        <div>
            <table style='border:1px green solid;border-collapse:collapse;background-color:#e4fde4;width: auto;'>
                <tr style='border:1px green solid;'>
                    <td> Las Declaraciones de 'Saldo Apertura' y 'Ventas' son hasta las 12:00pm. </td>
                </tr>
                <tr style='border:1px green solid;'>
                    <td> Las Declaraciones de 'Depósitos' son hasta las 3:00pm. </td>
                </tr>
                <tr style='border:1px green solid;'>
                    <td> Debe declarar solo un Deposito correspondiente al día, en el
                         caso que el pago de ese día se haya efectuado a través de
                         varios Depósitos, declare la suma de los montos en el campo
                         'Monto Deposito' y declare los diferentes num de referencia
                         separados por una coma (,) en el campo 'Monto de Ref. Deposito'.
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
