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

    $sql = "SELECT
                id,
                Nombre
            FROM
                  cabina
            WHERE
                  status = 1
                  AND id NOT IN (18,19)
                  ORDER BY Nombre;";

/*----------------------- SENTENCIAS SQL - FIN  -------------------------------------*/



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
    
    $diaSemanaMostrarPeru   = $dia[diaSemana($mon,$day,$year)];
    $horaMostrarPeru        = date("h:i:s A",time());
    $fechaMostrarPeru       = date("d/m/Y"  ,time());
    $fechaAyerPeru          = date('Y-m-d'  ,mktime(0,0,0,$mon,$day-1,$year));

//-- MANTENER LA FECHA DEL DIA ANTERIOR SI LA HORA ES MENOR A LAS 06:00 AM - COMIENZO --

    if (date("H",time())<6){
        $fechaActualPeru        = date('Y-m-d',mktime(0,0,0,$mon,$day-1,$year));
        $fechaMostrarPeru       = date('d/m/Y',mktime(0,0,0,$mon,$day-1,$year));
        $fechaAyerPeru          = date('Y-m-d',mktime(0,0,0,$mon,$day-2,$year));
        $diaSemanaMostrarPeru   = $dia[diaSemana($mon,$day-1,$year)];
    }

//__ MANTENER LA FECHA DEL DIA ANTERIOR SI LA HORA ES MENOR A LAS 06:00 AM - FIN _______

/*----------------------- OBTENER FECHA, HORA Y DIA - FIN ----------------------------*/



/******************** CAMBIO DE ZONA HORARIA CARACAS/VENEZUELA - COMIENZO ************/

    date_default_timezone_set('America/Caracas');

/*------------------- CAMBIO DE ZONA HORARIA CARACAS/VENEZUELA - FIN ----------------*/



/************************ OBTENER HORA CARACAS/VENEZUELA - COMIENZO ******************/
    
    $horaMostrarCcs = date("h:i:s A",time());

/*----------------------- OBTENER HORA CARACAS/VENEZUELA  - FIN ---------------------*/



/************** GENERAR ARREGLOS CON EL ID Y NOMBRE DE CABINA - COMIENZO *************/

    $resultado = mysql_query($sql,$conection);
    $i=0;

    while($fila = mysql_fetch_row($resultado)){
        $codigo[$i]  = $fila[0];
        $nombre[$i]  = $fila[1];
        $i++;
    }

/*------------- GENERAR ARREGLOS CON EL ID Y NOMBRE DE CABINA - FIN -----------------*/



/********************************** GENERACION CODIGO HTML - COMIENZO ************************************/

    $email = "
    <div>
        <h1 style='border: 0 none; font:150% Arial,Helvetica,sans-serif; margin: 0;
                   padding: 5; vertical-align: baseline;
                   background: url('http://fullredperu.com/themes/mattskitchen/img/line_hor.gif') repeat-x scroll 0 100% transparent;'>
            Tablero de Control de Actividades
        </h1>
        </br>
        <table style='border:0;'>
            <tr>
                <td>Día de la data: <span style='color:forestgreen;'>$diaSemanaMostrarPeru </span> $fechaMostrarPeru</td>
            </tr>
            <tr>
                <td>Hora Actual: $horaMostrarPeru Lima/Perú</td>
            </tr>
            <tr>
                <td>Hora Actual: $horaMostrarCcs Caracas/Venezuela</td>
            </tr>
        </table>"; 

    $resultadoz = mysql_query($sql,$conection);
    if(mysql_num_rows($resultadoz) != FALSE){
        $x=1;
        $email .= "
        <table style='background-color:#F2F4F2;border:0;'>
            <tr>
                <td style='font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <img style='padding-left: 16px;' src='http://fullredperu.com/images/Activity%20Monitor.png' />
                </td>
                <td style='width: 120px; font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <h3 align='center' style='font-size:14px; color:#FFFFFF;'>Inicio Jornada</h3>
                </td>
                <td style='width: 120px; font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <h3 align='center' style='font-size:14px; color:#FFFFFF;'>Saldo Apertura</h3>
                </td>
                <td style='width: 120px; font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <h3 align='center' style='font-size:14px; color:#FFFFFF;'>Ventas Llamadas</h3>
                </td>
                <td style='width: 120px; font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <h3 align='center' style='font-size:14px; color:#FFFFFF;'>Depositos</h3>
                </td>
                <td style='width: 120px; font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <h3 align='center' style='font-size:14px; color:#FFFFFF;'>Saldo Cierre</h3>
                </td>
                <td style='width: 120px; font-weight:bold; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                    <h3 align='center' style='font-size:14px; color:#FFFFFF;'>Fin Jornada</h3>
                </td>
            </tr>"; 

        $i=0;
        while($fila = mysql_fetch_row($resultadoz)){
            if(($x++) % 2 == 0){
              $email .= "<tr style='background-color:#CCC;'>";
            }
            else{
              $email .= "<tr>";
            }
            $email .= "
            <td style='font-size:10px; font-weight:bold; color:#FFFFFF; background: url(http://fullredperu.com/themes/mattskitchen/img/footer_bg.gif) repeat scroll 0 0 #2D2D2D;' >
                <div align='center' style='width:80px;'> $nombre[$i] </div>
            </td>
            <td>";

/******************************** INICIO JORNADA *******************************************************/

            $sqlCP = "SELECT
                            DISTINCT(DATE_FORMAT(l.Hora, '%H:%i'))
                                    AS HORA
                            FROM
                                    log AS l, users AS u 
                            WHERE
                                    l.ACCIONLOG_Id  = 9
                                    AND l.Fecha     = '$fechaActualPeru'
                                    AND l.USERS_Id  = u.Id
                                    AND u.CABINA_Id = $codigo[$i]
                                    ORDER BY HORA ASC";
            
            $resultado = mysql_query($sqlCP,$conection);
            if (mysql_num_rows($resultado) != FALSE){
                $fila = mysql_fetch_row($resultado);
                $email .= "<div align='center' style='color:#36C; font-family:'Trebuchet MS', cursive; font-size:20px;'>$fila[0] </div>";
            }
            else{
                $email .= "<div align='center'><img src='http://fullredperu.com/images/no-icon.png'></div>";
            }
            $email .= "</td>
            <td>";

/******************************** SALDO APERTURA *******************************************************/

            $sqlCP1 = "SELECT
                             DISTINCT(DATE_FORMAT(l.Hora, '%H:%i'))
                                    AS HORA
                             FROM
                                    log AS l, users AS u 
                             WHERE
                                    l.ACCIONLOG_Id  = 2
                                    AND l.Fecha     = '$fechaActualPeru'
                                    AND l.USERS_Id  = u.Id
                                    AND u.CABINA_Id = $codigo[$i]
                                    ORDER BY HORA ASC";
            
            $resultado1 = mysql_query($sqlCP1,$conection);
            if (mysql_num_rows($resultado1) != FALSE){
                $email .= "<div align='center'><img src='http://fullredperu.com/images/check-icon.png'></div>";
            }
            else{
                $email .= "<div align='center'><img src='http://fullredperu.com/images/no-icon.png'></div>";
            }
            $email .= "</td>
            <td>";

/******************************** LLAMADAS *******************************************************/

            $sqlCP2 = "SELECT
                             DISTINCT(DATE_FORMAT(l.Hora, '%H:%i'))
                                    AS HORA
                             FROM
                                    log AS l, users AS u 
                             WHERE
                                    l.ACCIONLOG_Id  = 3
                                    AND l.Fecha     = '$fechaActualPeru'
                                    AND l.USERS_Id  = u.Id
                                    AND l.FechaEsp  = '$fechaAyerPeru'
                                    AND u.CABINA_Id = $codigo[$i]
                                    ORDER BY HORA ASC";
            
            $resultado2 = mysql_query($sqlCP2,$conection);
            if (mysql_num_rows($resultado2) != FALSE){
               $email .= "<div align='center'><img src='http://fullredperu.com/images/check-icon.png'></div>";
            }
            else{
               $email .= "<div align='center'><img src='http://fullredperu.com/images/no-icon.png'></div>";
            }
            $email .= "</td>
            <td>";
/******************************** DEPOSITOS *******************************************************/

            $sqlCP3 = "SELECT
                             DISTINCT(DATE_FORMAT(l.Hora, '%H:%i'))
                                    AS HORA
                             FROM
                                    log AS l, users AS u 
                             WHERE
                                    l.ACCIONLOG_Id  = 4
                                    AND l.Fecha     = '$fechaActualPeru'
                                    AND l.USERS_Id  = u.Id
                                    AND l.FechaEsp  = '$fechaAyerPeru'
                                    AND u.CABINA_Id = $codigo[$i]
                                    ORDER BY HORA ASC";
            
            $resultado3 = mysql_query($sqlCP3,$conection);
            if (mysql_num_rows($resultado3) != FALSE){
               $email .= "<div align='center'><img src='http://fullredperu.com/images/check-icon.png'></div>";
            }
            else{
               $email .= "<div align='center'><img src='http://fullredperu.com/images/no-icon.png'></div>";
            }
            $email .= "</td>
            <td>";

/******************************** SALDO CIERRE *******************************************************/

            $sqlCP4 = "SELECT
                             DISTINCT(DATE_FORMAT(l.Hora, '%H:%i'))
                                    AS HORA
                             FROM
                                    log AS l, users AS u 
                             WHERE
                                    l.ACCIONLOG_Id  = 8
                                    AND l.Fecha     = '$fechaActualPeru'
                                    AND l.USERS_Id  = u.Id
                                    AND u.CABINA_Id = $codigo[$i]
                                    ORDER BY HORA ASC";
            
            $resultado4 = mysql_query($sqlCP4,$conection);
            if (mysql_num_rows($resultado4) != FALSE){
               $email .= "<div align='center'><img src='http://fullredperu.com/images/check-icon.png'></div>";
            }
            else{
               $email .= "<div align='center'><img src='http://fullredperu.com/images/no-icon.png'></div>";
            }
            $email .= "</td>
            <td>";

/******************************** FIN JORNADA *******************************************************/

            $sqlCP5 = "SELECT
                             DISTINCT(DATE_FORMAT(l.Hora, '%H:%i'))
                                    AS HORA
                             FROM
                                    log AS l, users AS u 
                             WHERE
                                    l.ACCIONLOG_Id  = 10
                                    AND l.Fecha     = '$fechaActualPeru'
                                    AND l.USERS_Id  = u.Id
                                    AND u.CABINA_Id = $codigo[$i]
                                    AND l.hora      > '21:00:00'";
            
            $resultado5 = mysql_query($sqlCP5,$conection);
            if (mysql_num_rows($resultado5) != FALSE){
               $fila5 = mysql_fetch_row($resultado5);
               $email .= "<div align='center' style='color:#36C; font-family:'Trebuchet MS', cursive; font-size:20px;'> $fila5[0] </div>";
            }
            else{
               $email .= "<div align='center'><img src='http://fullredperu.com/images/no-icon.png'></div>";
            }             
            $email .= "</td>
            </tr>";
            $i++;
            }

    $email .= "
            <tr>
                <td colspan='7'>
                    <span>Copyright 2013 by <a href='http://www.sacet.com.ve/' rel='external'> www.sacet.com.ve</a> Legal privacy</span>
                </td>
            </tr>
        </table>
    </div>
    <div style='margin-top: 3%;'>
        <div style='background-color:green;color:#fff;font-size:1em;font-weight:bold;padding: 1% 0 1% 1%;'>
            Reglas de declaraci&oacute;n
        </div>
        <div>
            <table style='border:1px green solid;border-collapse:collapse;background-color:#e4fde4;width:auto;'>
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
    </div>";
    }

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
        $mailer->Subject  = "Status Tablero de Control \"$diaSemanaMostrarPeru\" ".date("h",time()).':00 '.date("A",time());
        $mailer->Body     = $email;
        $mailer->ClearAddresses();
        $mailer->AddAddress('eduardo@newlifeve.com');
        $mailer->Send();
        $mailer->ClearAddresses();
        $mailer->AddAddress('cabinasperu@etelix.com');
        $mailer->Send();

    }
    catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }
    catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }

/*----------------------- ENVIO DE CORREO ELECTRONICO - FIN ------------------------*/
?>