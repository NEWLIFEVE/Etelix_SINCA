<?php

$this->pageTitle=Yii::app()->name;
$user_id = Yii::app()->user->id;
$cabina_id = Yii::app()->getModule("user")->user($user_id)->CABINA_Id;
$cabina_nombre = Cabina::getNombreCabina(Yii::app()->getModule("user")->user($user_id)->CABINA_Id);

$dias = array('Sun' => 'Domingo', 'Mon' => 'Lunes','Tue' => 'Martes','Wed' => 'Miercoles','Thu' => 'Jueves','Fri' => 'Viernes','Sat' => 'Sabado');

list($year, $mon, $day) = explode('-', date("Y-m-d", time()));

$fechaActual = date('Y-m-d', mktime(0, 0, 0,$mon, $day - 1, $year));
$fechaAyer = date('Y-m-d', mktime(0, 0, 0,$mon, $day-2, $year));
$fechamostrar = date('d/m/Y', mktime(0, 0, 0,$mon , $day - 1, $year));
$diaMostrar = $dias[date('D',mktime(0, 0, 0,$mon , $day - 1, $year))];
$horamostrar = "Hora Actual: ".date("h:i:s A",time())." Lima / Per&uacute;.";

$sqlCP1 = "SELECT DISTINCT(DATE_FORMAT(l.Hora, '%H:%i')) as HORA FROM log l, users u 
WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina ORDER BY HORA ASC";

$sqlCP = "SELECT DISTINCT(DATE_FORMAT(l.Hora, '%H:%i')) as HORA FROM log l, users u 
WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.FechaEsp = :fechaesp and l.USERS_Id = u.Id and u.CABINA_Id = :cabina ORDER BY HORA ASC";

$sqlCP2 = "SELECT DISTINCT(DATE_FORMAT(l.Hora, '%H:%i')) as HORA FROM log l, users u 
WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina and l.hora > '19:00:00'";

$sqlCP3 = Cabina::model()->findBySql("SELECT Id, Nombre, HoraIni, HoraFin, HoraIniDom, HoraFinDom FROM cabina WHERE Id = $cabina_id");
                


?>
<!-- <h1>Bienvenido a <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h1> -->
<h1 class="ocultar_linea">Bienvenido a SINCA</h1>
<br>
<h1>Recordatorio</h1>

<h3 class="ocultar_linea">Estimados empleados</h3>

<p>Les recordamos que es necesario y obligatorio que el empleado encargado de cerrar la cabina 
declare el saldo de cierre y la hora de fin de jornada. El empleado que no declare
los datos solicitados ser&aacute; penalizado.</p>

<p>Agradeciendo su colaboraci&oacute;n para el desarrollo de la empresa nos despedimos.</p>

<p>Copyright 2013 by <a href="www.sacet.com.ve">www.sacet.com.ve</a> Legal privacy</p>

<br>

<?php

$mensaje = '';

$ini_jornada = '';
$saldo_apertura = '';
$ventas_llamadas = '';
$depositos = '';
$saldo_cierre = '';
$fin_jornada = '';


/********************************INICIO JORNADA*******************************************************/

$mensaje = "<p> <h1>Faltas Cometidas</h1></p> 
<p> <h3 class='ocultar_linea'>El Día de Ayer ($fechaActual) la Cabina '$cabina_nombre' 
Incumplio con las Siguientes Actividades: </h3></p>
<br>";

$connection = Yii::app()->db;
$command = $connection->createCommand($sqlCP1);
$command->bindValue(":cabina", $cabina_id); // bind de parametro cabina del user
$command->bindValue(":accion", 9); // bind de parametro cabina del user
$command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
$id = $command->query(); // execute a query SQL

if(($diaMostrar != 'Domingo' && $sqlCP3->HoraIni != null) || ($diaMostrar == 'Domingo' && $sqlCP3->HoraIniDom != null)){

    if ($id->count()) {

        $hora = $id->readColumn(0); 
        if(($diaMostrar != 'Domingo' && $hora > $sqlCP3->HoraIni) || ($diaMostrar == 'Domingo' && $hora > $sqlCP3->HoraIniDom)){ 
          
            if($diaMostrar != 'Domingo')
                $ini_jornada = "<p><h3 class='ocultar_linea'>- Apertura de Cabina Tarde ($sqlCP3->HoraIni/$hora.':00')</h3></p>";
            else
                $ini_jornada = "<p><h3 class='ocultar_linea'>- Apertura de Cabina Tarde ($sqlCP3->HoraIniDom/$hora.':00')</h3></p>";

        }else{  
          $ini_jornada = "";
        }       
        
    } else { 
        $ini_jornada = "<p><h3 class='ocultar_linea'>- Apertura de Cabina No Declarada</h3></p>";
    } 

}else{ 
    $ini_jornada = "";
}

/********************************SALDO APERTURA*******************************************************/    

$connection = Yii::app()->db;
$command = $connection->createCommand($sqlCP1);
$command->bindValue(":cabina", $cabina_id); // bind de parametro cabina del user
$command->bindValue(":accion", 2); // bind de parametro cabina del user
$command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
//$command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
$id = $command->query(); // execute a query SQL

if(($diaMostrar != 'Domingo' && $sqlCP3->HoraIni != null) || ($diaMostrar == 'Domingo' && $sqlCP3->HoraIniDom != null)){

    if ($id->count()) {
        $saldo_apertura = "";
     } else { 
        $saldo_apertura = "<p><h3 class='ocultar_linea'>- Saldo de Apertura No Declarado</h3></p>";
    }

}else{ 
    $saldo_apertura = "";
}

/********************************LLAMADAS*******************************************************/

$connection = Yii::app()->db;
$command = $connection->createCommand($sqlCP);
$command->bindValue(":cabina", $cabina_id); // bind de parametro cabina del user
$command->bindValue(":accion", 3); // bind de parametro cabina del user
$command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario 
$command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
$id = $command->query(); // execute a query SQL

if(($diaMostrar != 'Domingo' && $sqlCP3->HoraIni != null) || ($diaMostrar == 'Domingo' && $sqlCP3->HoraIniDom != null)){

    if ($id->count()) {
        $ventas_llamadas = "";
     } else { 
        $ventas_llamadas = "<p><h3 class='ocultar_linea'>- Ventas de Llamadas No Declaradas</h3></p>";
    }

}else{ 
    $ventas_llamadas = "";
}

/********************************DEPOSITOS*******************************************************/

$connection = Yii::app()->db;
$command = $connection->createCommand($sqlCP);
$command->bindValue(":cabina", $cabina_id); // bind de parametro cabina del user
$command->bindValue(":accion", 4); // bind de parametro cabina del user
$command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario  
$command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
$id = $command->query(); // execute a query SQL

if(($diaMostrar != 'Domingo' && $sqlCP3->HoraIni != null) || ($diaMostrar == 'Domingo' && $sqlCP3->HoraIniDom != null)){

    if ($id->count()) {
        $depositos = "";
     } else { 
        $depositos = "<p><h3 class='ocultar_linea'>- Depositos No Declarados</h3></p>";
    }

}else{ 
    $depositos = "";
}

/********************************SALDO CIERRE*******************************************************/

$connection = Yii::app()->db;
$command = $connection->createCommand($sqlCP1);
$command->bindValue(":cabina", $cabina_id); // bind de parametro cabina del user
$command->bindValue(":accion", 8); // bind de parametro cabina del user
$command->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario   
//$command->bindValue(":fechaesp", $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
$id = $command->query(); // execute a query SQL

if(($diaMostrar != 'Domingo' && $sqlCP3->HoraIni != null) || ($diaMostrar == 'Domingo' && $sqlCP3->HoraIniDom != null)){

    if ($id->count()) {
        $saldo_cierre = "";
     } else { 
        $saldo_cierre = "<p><h3 class='ocultar_linea'>- Saldo de Cierre No Declarado</h3></p>";
    }

}else{ 
    $saldo_cierre = "";
}

/********************************FIN JORNADA*******************************************************/

$connection2 = Yii::app()->db;
$command2 = $connection2->createCommand($sqlCP2);
$command2->bindValue(":cabina", $cabina_id); // bind de parametro cabina del user
$command2->bindValue(":accion", 10); // bind de parametro cabina del user
$command2->bindValue(":fecha", $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
$id2 = $command2->query(); // execute a query SQL

if(($diaMostrar != 'Domingo' && $sqlCP3->HoraFin != null) || ($diaMostrar == 'Domingo' && $sqlCP3->HoraFinDom != null)){

    if ($id2->count()) {

        $hora2 = $id2->readColumn(0); 
        if(($diaMostrar != 'Domingo' && $hora2.':00' < $sqlCP3->HoraFin) || ($diaMostrar == 'Domingo' && $hora2.':00' < $sqlCP3->HoraFinDom)){ 
          
            if($diaMostrar != 'Domingo')
                $fin_jornada = "<p><h3 class='ocultar_linea'>- Cierre de Cabina Temprano ($sqlCP3->HoraFin/$hora2.':00')</h3></p>";
            else
                $fin_jornada = "<p><h3 class='ocultar_linea'>- Cierre de Cabina Temprano ($sqlCP3->HoraFinDom/$hora2.':00')</h3></p>";
        }else{  
          $fin_jornada = "";
        }       
        
    } else { 
        $fin_jornada = "<p><h3 class='ocultar_linea'>- Cierre de Cabina No Declarado</h3></p>";
    } 

}else{ 
    $fin_jornada = "";
}


/********************************MENSAJE*******************************************************/

if($ini_jornada != '' || $saldo_apertura != '' || $ventas_llamadas != '' || 
   $depositos != '' || $saldo_cierre != '' || $fin_jornada != ''){
    
    
    echo $mensaje;
    
    if($ini_jornada != '')
        echo $ini_jornada;
    if($saldo_apertura != '')
        echo $saldo_apertura;
    if($ventas_llamadas != '')
        echo $ventas_llamadas;
    if($depositos != '')
        echo $depositos;
    if($saldo_cierre != '')
        echo $saldo_cierre;
    if($fin_jornada != '')
        echo $fin_jornada;
    
}

?>