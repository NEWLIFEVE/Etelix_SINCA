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
<h1 class="ocultar_linea">Recordatorio</h1>


<br><br>
<p> <h1 class="ocultar_linea">Fallas Cometidas</h1></p>


<p> <h3 class="ocultar_linea">El Día de Ayer (<?php echo $fechaActual;?>) la Cabina "<?php echo $cabina_nombre; ?>" 
Incumplio con las Siguientes Actividades: </h3></p>
<br>

<?php


/********************************INICIO JORNADA*******************************************************/

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
          echo "<p><h3 class='ocultar_linea'>- Apertura de Cabina Tarde ($sqlCP3->HoraIni/$hora)</h3></p>";
        }else{  
          echo "";
        }       
        
    } else { 
        echo "<p><h3 class='ocultar_linea'>- Apertura de Cabina No Declarada</h3></p>";
    } 

}else{ 
    echo "";
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
        echo "";
     } else { 
        echo "<p><h3 class='ocultar_linea'>- Saldo de Apertura No Declarado</h3></p>";
    }

}else{ 
    echo "";
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
        echo "";
     } else { 
        echo "<p><h3 class='ocultar_linea'>- Ventas de Llamadas No Declaradas</h3></p>";
    }

}else{ 
    echo "";
}




?>