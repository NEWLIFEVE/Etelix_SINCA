<?php
/************************ PARAMETROS BASE DE DATOS - COMIENZO ************************/

    $server     = "67.215.160.89:3306";
    $username   = "root";
    $password   = "Nsusfd8263";
    $dataBase   = "sinca";

/*----------------------- PARAMETROS BASE DE DATOS - FIN ----------------------------*/



/************************ CONECCION BASE DE DATOS - COMIENZO *************************/

    $conection = mysql_connect($server,$username,$password);
    mysql_select_db($dataBase,$conection);

/*----------------------- CONECCION BASE DE DATOS - FIN  ----------------------------*/



/************************ SENTENCIAS SQL - COMIENZO **********************************/

//    $sql = "SELECT
//                id,
//                Nombre
//            FROM
//                  cabina
//            WHERE
//                      status = 1
//                  AND id    not in (18,19)
//                  ORDER BY Nombre;";

    $sqlObtenerCorreoDeCabinas = "SELECT DISTINCT(u.email) from users u, cabina c  where u.CABINA_Id IS NOT NULL and c.id not in (18,19) and c.status = 1 and u.CABINA_Id = c.id;";

/*----------------------- SENTENCIAS SQL - FIN  -------------------------------------*/



/******************** CAMBIO DE ZONA HORARIA CARACAS/VENEZUELA - COMIENZO ************/

    date_default_timezone_set('America/Caracas');

/*------------------- CAMBIO DE ZONA HORARIA CARACAS/VENEZUELA - FIN ----------------*/



/************************ OBTENER HORA CARACAS/VENEZUELA - COMIENZO ******************/
    
//    $horaMostrarCcs = date("h:i:s A",time());

/*----------------------- OBTENER HORA CARACAS/VENEZUELA  - FIN ---------------------*/



/************************ CAMBIO DE ZONA HORARIA LIMA/PERU - COMIENZO ****************/

    date_default_timezone_set('America/Lima');

/*----------------------- CAMBIO DE ZONA HORARIA LIMA/PERU - FIN --------------------*/



/************************ FUNCION PARA OBTENER NUMERO DE DIA - COMIENZO **************/

    function diaSemana($mes,$dia,$anio){
        // 0->domingo	 | 6->sabado
        $numeroDia = date("w",mktime(0,0,0,$mes,$dia,$anio));
        return $numeroDia;
    }

/*----------------------- FUNCION PARA OBTENER NUMERO DE DIA - FIN ------------------*/



/************************ OBTENER FECHA, HORA Y DIA - COMIENZO ************************/

    $fechaActualPeru = date("Y-m-d",time());
    list($year,$mon,$day) = explode('-',$fechaActualPeru);
    
    $dia = array(   0 => "Domingo",
                    1 => "Lunes",
                    2 => "Martes",
                    3 => "Miercoles",
                    4 => "Jueves",
                    5 => "Viernes",
                    6 => "Sabado"   );
    
//    $diaSemanaAyerPeru   = $dia[diaSemana($mon,$day-1,$year)];
//    $horaMostrarPeru        = date("h:i:s A",time());
    $fechaMostrarPeru       = date("d/m/Y"  ,time());
//    $fechaMostrarAyerPeru   = date("d/m/Y"  ,mktime(0,0,0,$mon,$day-1,$year));
    $fechaAyerPeru          = date('Y-m-d'  ,mktime(0,0,0,$mon,$day-1,$year));

//-- MANTENER LA FECHA DEL DIA ANTERIOR SI LA HORA ES MENOR A LAS 06:00 AM - COMIENZO --

    if (date("H",time())<6){
        $fechaActualPeru        = date('Y-m-d',mktime(0,0,0,$mon,$day-1,$year));
        $fechaMostrarPeru       = date('d/m/Y',mktime(0,0,0,$mon,$day-1,$year));
        $fechaAyerPeru          = date('Y-m-d',mktime(0,0,0,$mon,$day-2,$year));
//        $diaSemanaMostrarPeru   = $dia[diaSemana($mon,$day-1,$year)];
    }

//__ MANTENER LA FECHA DEL DIA ANTERIOR SI LA HORA ES MENOR A LAS 06:00 AM - FIN _______

/*----------------------- OBTENER FECHA, HORA Y DIA - FIN ----------------------------*/



/************** GENERAR ARREGLOS CON EL ID Y NOMBRE DE CABINA - COMIENZO *************/

//    $resultado = mysql_query($sql,$conection);
//    $i=0;

//    while($fila = mysql_fetch_row($resultado)){
//        $codigo[$i]  = $fila[0];
//        $nombre[$i]  = $fila[1];
//        $i++;
//    }

/*------------- GENERAR ARREGLOS CON EL ID Y NOMBRE DE CABINA - FIN -----------------*/



/********************************** GENERACION CODIGO HTML - COMIENZO ************************************/

    $emailRecordatorio = '
<html>
    <head>
    </head>

    <body style="font-family:Arial;">
        <div style="background-color:#e4fde4;padding:0.9% 3%;border:1 solid;">
            <h4>Estimados empleados</h4>

            <p>Les recordamos que es necesario y obligatorio que el empleado encargado de cerrar la cabina 
               declare el saldo de cierre y la hora de fin de jornada. El empleado que no declare
               los datos solicitados ser&aacute; penalizado.</p>

            <p>Agradeciendo su colaboraci&oacute;n para el desarrollo de la empresa nos despedimos.</p>

            <p>Copyright 2013 by <a href="www.sacet.com.ve">www.sacet.com.ve</a> Legal privacy</p>

        </div>
    </body>

</html>';

/*------------------------------- GENERACION CODIGO HTML - FIN ------------------------------------------*/



/************************ ENVIO DE CORREO ELECTRONICO - COMIENZO ********************/

    require_once('class.phpmailer.php');
    $mailer = new PHPMailer(TRUE);
    $mailer->IsSMTP();
    try {

        $mailer->Host     = 'smtp.gmail.com';
        $mailer->Port     = '587';
        //$mailer->SMTPDebug = 2;
        $mailer->SMTPSecure = 'tls';
        $mailer->Username = 'sinca.test@gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Password = "sincatest";
        $mailer->IsHTML(true);
        //$mailer->SetFrom('noresponder@sinca.com', 'Sistema S I N C A');
        $mailer->From     = 'sinca.test@gmail.com';
        $mailer->AddReplyTo('sinca.test@gmail.com');
        $mailer->FromName = 'SINCA';
        $mailer->CharSet  = 'UTF-8';

        $resultadoObtenerCorreoDeCabinas = mysql_query($sqlObtenerCorreoDeCabinas,$conection);

        while($fila = mysql_fetch_array($resultadoObtenerCorreoDeCabinas)){

            $mailer->Subject  = "Recordatorio";
            $mailer->Body     = $emailRecordatorio;
            //Descomentar para mandar a las cabinas

            $mailer->ClearAddresses();
            $mailer->AddAddress($fila[0]);
            $mailer->Send();

//            $mailer->ClearAddresses();
//            $mailer->AddAddress('eduardo@newlifeve.com');
//            $mailer->Send();

        }

    }
    catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }
    catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }

/*----------------------- ENVIO DE CORREO ELECTRONICO - FIN ------------------------*/
?>