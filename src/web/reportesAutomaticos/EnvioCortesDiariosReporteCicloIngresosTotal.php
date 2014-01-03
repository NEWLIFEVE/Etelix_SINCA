<?php
/************************ PARAMETROS BASE DE DATOS - COMIENZO ***********************/

    $server     = "67.215.160.89:3306";
    $username   = "root";
    $password   = "Nsusfd8263";
    $dataBase   = "sinca";

/*----------------------- PARAMETROS BASE DE DATOS - FIN ---------------------------*/



/************************ CONECCION BASE DE DATOS - COMIENZO ************************/

    $conection = mysql_connect($server, $username, $password);
    mysql_select_db($dataBase, $conection);

/*----------------------- CONECCION BASE DE DATOS - FIN  ---------------------------*/



/************************ SENTENCIAS SQL - COMIENZO *********************************/

    $sql = "SELECT
                b.Fecha
                        AS 'Inicio del Balance',
                'Todas las Cabinas' 
                        AS 'Nombre de Cabina',
                TRUNCATE(SUM(
                            IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0) +
                            IFNULL(b.Rural,0)     +    IFNULL(b.Celular,0)    + IFNULL(b.LDI,0)      +
                            IFNULL(b.RecargaCelularMov,0)      +      IFNULL(b.RecargaFonoYaMov,0)   +
                            IFNULL(b.RecargaCelularClaro,0)    +      IFNULL(b.RecargaFonoClaro,0)   +
                            IFNULL(b.OtrosServicios,0)
                        ),2)
                        AS 'Total Ventas (S/.)',
                TRUNCATE(SUM(
                            IFNULL(b.MontoBanco,0) -
                            (
                              IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0) + IFNULL(b.Rural,0) +
                              IFNULL(b.Celular,0)   +      IFNULL(b.LDI,0)      + IFNULL(b.RecargaCelularMov,0) +
                              IFNULL(b.RecargaFonoYaMov,0)    +    IFNULL(b.RecargaCelularClaro,0) +
                              IFNULL(b.RecargaFonoClaro,0)    +    IFNULL(b.OtrosServicios,0)
                            )
                        ),2)
                        AS 'Diferencial Bancario (S/.)',
                TRUNCATE(SUM( IFNULL(b.MontoBanco,0) - IFNULL(b.MontoDeposito,0) ),2)
                        AS 'Conciliacion Bancaria (S/.)',
                TRUNCATE(SUM( IFNULL(b.RecargaVentasMov,0) - ( IFNULL(b.RecargaCelularMov,0) + IFNULL(b.RecargaFonoYaMov,0) ) ),2)
                        AS 'Diferencial Brightstar Movistar (S/.)',
                TRUNCATE(SUM( IFNULL(b.RecargaVentasClaro,0) - ( IFNULL(b.RecargaCelularClaro,0) + IFNULL(b.RecargaFonoClaro,0) ) ),2)
                        AS 'Diferencial Brightstar Claro (S/.)',
                TRUNCATE(IFNULL(p.Valor,0),2)
                        AS 'Paridad Cambiaria (S/.|$)',
                TRUNCATE(SUM(
                            (
                              IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0)  +
                              IFNULL(b.Rural,0)     +    IFNULL(b.Celular,0)    +  IFNULL(b.LDI,0)
                            ) -
                            ( IFNULL(b.TraficoCapturaDollar,0) * IFNULL(p.Valor,0) )
                        ),2)
                        AS 'Diferencial Captura Soles (S/.)',
                TRUNCATE(SUM(
                            ( IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0)  +
                              IFNULL(b.Rural,0)  +  IFNULL(b.Celular,0)  +  IFNULL(b.LDI,0) -
                              IFNULL(b.TraficoCapturaDollar,0) * IFNULL(p.Valor,0)
                            ) / IFNULL(p.Valor,0)
                        ),2)
                        AS 'Diferencial Captura Dollar (USD $)'

            FROM
                    balance AS b INNER JOIN cabina  AS c
					   ON b.CABINA_Id = c.Id
			  INNER JOIN paridad AS p ON b.PARIDAD_Id = p.Id

            WHERE
                    b.Fecha >= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-','01')
                    AND b.Fecha <= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-',DAY(CURDATE())-1)
                    AND b.CABINA_Id NOT IN (18,19)
			  AND c.status  = 1
                    GROUP BY b.Fecha
                    ORDER BY b.Fecha DESC;";

    $sqlTotal = "SELECT
                    b.Fecha
                            AS 'Inicio del Balance',
                    'Todas las Cabinas'
                            AS 'Nombre de Cabina',
                    TRUNCATE(SUM(
                                IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0) +
                                IFNULL(b.Rural,0)     +    IFNULL(b.Celular,0)    + IFNULL(b.LDI,0)      +
                                IFNULL(b.RecargaCelularMov,0)      +      IFNULL(b.RecargaFonoYaMov,0)   +
                                IFNULL(b.RecargaCelularClaro,0)    +      IFNULL(b.RecargaFonoClaro,0)   +
                                IFNULL(b.OtrosServicios,0)
                            ),2)
                            AS 'Total Ventas (S/.)',

                    TRUNCATE(SUM(
                                IFNULL(b.MontoBanco,0) -
                                (
                                  IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0) + IFNULL(b.Rural,0) +
                                  IFNULL(b.Celular,0)   +      IFNULL(b.LDI,0)      + IFNULL(b.RecargaCelularMov,0) +
                                  IFNULL(b.RecargaFonoYaMov,0)    +    IFNULL(b.RecargaCelularClaro,0) +
                                  IFNULL(b.RecargaFonoClaro,0)    +    IFNULL(b.OtrosServicios,0)
                                )
                            ),2)
                            AS 'Diferencial Bancario (S/.)',
                    TRUNCATE(SUM( IFNULL(b.MontoBanco,0) - IFNULL(b.MontoDeposito,0) ),2)
                            AS 'Conciliacion Bancaria (S/.)',
                    TRUNCATE(SUM( IFNULL(b.RecargaVentasMov,0) - ( IFNULL(b.RecargaCelularMov,0) + IFNULL(b.RecargaFonoYaMov,0) ) ),2)
                            AS 'Diferencial Brightstar Movistar (S/.)',
                    TRUNCATE(SUM( IFNULL(b.RecargaVentasClaro,0) - ( IFNULL(b.RecargaCelularClaro,0) + IFNULL(b.RecargaFonoClaro,0) ) ),2)
                            AS 'Diferencial Brightstar Claro (S/.)',
                    TRUNCATE((SELECT valor FROM paridad ORDER BY Id DESC LIMIT 1),2)
                            AS 'Paridad Cambiaria (S/.|$)',
                    TRUNCATE(SUM(
                                (
                                  IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0)  +
                                  IFNULL(b.Rural,0)     +    IFNULL(b.Celular,0)    +  IFNULL(b.LDI,0)
                                ) -
                                ( IFNULL(b.TraficoCapturaDollar,0) * IFNULL(p.Valor,0) )
                            ),2)
                            AS 'Diferencial Captura Soles (S/.)',
                    TRUNCATE(SUM(
                                ( IFNULL(b.FijoLocal,0) + IFNULL(b.FijoProvincia,0) + IFNULL(b.FijoLima,0)  +
                                  IFNULL(b.Rural,0)  +  IFNULL(b.Celular,0)  +  IFNULL(b.LDI,0) -
                                  IFNULL(b.TraficoCapturaDollar,0) * IFNULL(p.Valor,0)
                                ) / IFNULL(p.Valor,0)
                            ),2)
                            AS 'Diferencial Captura Dollar (USD $)'

                 FROM
                         balance AS b INNER JOIN cabina  AS c
                                 ON b.CABINA_Id = c.Id
                                      INNER JOIN paridad AS p
                                                         ON b.PARIDAD_Id = p.Id

                 WHERE
                         b.Fecha >= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-','01')
                         AND b.Fecha <= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-',DAY(CURDATE())-1)
                         AND b.CABINA_Id NOT IN (18,19)
				 AND c.status  = 1;";


/*----------------------- SENTENCIAS SQL - FIN  ------------------------------------*/



/************************ OBTENER DIA DE LA SEMANA - COMIENZO ***********************/

    function diaSemana($mes,$dia,$anio){
        // 0->domingo	 | 6->sabado
        $numeroDia= date("w",mktime(0, 0, 0, $mes, $dia, $anio));
        return $numeroDia;
    }

    $fechaActualVenezuela = date("Y-m-d", time());
    list($year, $mon, $day) = explode('-', $fechaActualVenezuela);

    $dia = array(   0 => "Domingo",
                    1 => "Lunes",
                    2 => "Martes",
                    3 => "Miercoles",
                    4 => "Jueves",
                    5 => "Viernes",
                    6 => "Sabado"   );
    
    $diaSemanaVenezuela = $dia[diaSemana($mon, $day-1, $year)];

/*----------------------- OBTENER DIA DE LA SEMANA - FIN ---------------------------*/



/************************ GENERACION CODIGO HTML - COMIENZO *************************/

$email = "
<div>
    <h1 style='border: 0 none; font:150% Arial,Helvetica,sans-serif; margin: 0;
        padding: 5; vertical-align: baseline;
        background: url('http://fullredperu.com/themes/mattskitchen/img/line_hor.gif') repeat-x scroll 0 100% transparent;'>
        Total Diario Ciclo de Ingresos
    </h1>
    <br/>
    <table style='font:13px/150% Arial,Helvetica,sans-serif;'>
        <tr>
            <th style='background-color:#009900; color:#ffffff; width:10%; height:100%;'>
                D&iacute;a del Balance
            </th>
            <th style='background-color:#009900; color:#ffffff; width:10%; height:100%;'>
                Cabina
            </th>
            <th style='background-color:#ffbb00; color:#ffffff; width:10%; height:100%;'>
                Total  Ventas (S/.)
            </th>
            <th style='background-color:#339999; color:#ffffff; width:10%; height:100%;'>
                Diferencial Bancario (S/.)
            </th>
            <th style='background-color:#339999; color:#ffffff; width:10%; height:100%;'>
                Conciliaci&oacute;n Bancaria (S/.)
            </th>
            <th style='background-color:#ff9933; color:#ffffff; width:10%; height:100%;'>
                Diferencial Brightstar Movistar (S/.)
            </th>
            <th style='background-color:#ff9933; color:#ffffff; width:10%; height:100%;'>
                Diferencial Brightstar Claro (S/.)
            </th>
            <th style='background-color:#cc99cc; color:#ffffff; width:10%; height:100%;'>
                Paridad Cambiaria (S/.|$)
            </th>
            <th style='background-color:#cc99cc; color:#ffffff; width:10%; height:100%;'>
                Diferencial Captura Soles (S/.)
            </th>
            <th style='background-color:#cc99cc; color:#ffffff; width:10%; height:100%;'>
                Diferencial Captura Dollar (USD $)
            </th>
        </tr>";

$resultado = mysql_query($sql,$conection);
$par=1;

while ($fila = mysql_fetch_row($resultado)){

    if($par%2!=0){

    $email .= "
        <tr style='background-color:#e5f1f4;'>
            <td style='text-align: center;' class='fecha'>
                $fila[0]
            </td>
            <td style='text-align: center;' class='cabina'>
                $fila[1]
            </td>
            <td style='text-align: center;' class='totalVentas'>
                $fila[2]
            </td>";

            if($fila[3]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialBancario'>
                $fila[3]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialBancario'>
                $fila[3]
            </td>";
            }

            if($fila[4]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif concilicacionBancaria'>
                $fila[4]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif concilicacionBancaria'>
                $fila[4]
            </td>";
            }

            if($fila[5]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialBrightstarMovistar'>
                $fila[5]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialBrightstarMovistar'>
                $fila[5]
            </td>";
            }

            if($fila[6]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialBrightstarClaro'>
                $fila[6]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialBrightstarClaro'>
                $fila[6]
            </td>";
            }

            $email.="
            <td style='text-align: center;' class='paridad'>
                $fila[7]
            </td>";

            if($fila[8]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialCapturaSoles'>
                $fila[8]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialCapturaSoles'>
                $fila[8]
            </td>";
            }

            if($fila[9]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialCapturaDollar'>
                $fila[9]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialCapturaDollar'>
                $fila[9]
            </td>";
            }

        $email .= "
        </tr>";
    }
    elseif($par%2==0){

    $email .= "
        <tr style='background-color:#f8f8f8;'>
            <td style='text-align: center;' class='fecha'>
                $fila[0]
            </td>
            <td style='text-align: center;' class='cabina'>
                $fila[1]
            </td>
            <td style='text-align: center;' class='totalVentas'>
                $fila[2]
            </td>";

            if($fila[3]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialBancario'>
                $fila[3]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialBancario'>
                $fila[3]
            </td>";
            }

            if($fila[4]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif concilicacionBancaria'>
                $fila[4]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif concilicacionBancaria'>
                $fila[4]
            </td>";
            }

            if($fila[5]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialBrightstarMovistar'>
                $fila[5]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialBrightstarMovistar'>
                $fila[5]
            </td>";
            }

            if($fila[6]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialBrightstarClaro'>
                $fila[6]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialBrightstarClaro'>
                $fila[6]
            </td>";
            }

            $email.="
            <td style='text-align: center;' class='paridad'>
                $fila[7]
            </td>";

            if($fila[8]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialCapturaSoles'>
                $fila[8]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialCapturaSoles'>
                $fila[8]
            </td>";
            }

            if($fila[9]>=0){
            $email .= "
            <td style='text-align: center; color: green;' class='dif diferencialCapturaDollar'>
                $fila[9]
            </td>";
            }

            else{
            $email .= "
            <td style='text-align: center; color: red;' class='dif diferencialCapturaDollar'>
                $fila[9]
            </td>";
            }

        $email .= "
        </tr>";
    }
    $par++;
}

$resultadoTotal = mysql_query($sqlTotal,$conection);

while ($filaTotal = mysql_fetch_row($resultadoTotal)){

    $email .= "
        <tr>
            <th style='background-color:#009900; color:white;'></th>
            <th style='background-color:#009900; color:white;'>$filaTotal[1]</th>
            <th style='background-color:#ffbb00; color:white;'>$filaTotal[2]</th>
            <th style='background-color:#339999; color:white;'>$filaTotal[3]</th>
            <th style='background-color:#339999; color:white;'>$filaTotal[4]</th>
            <th style='background-color:#ff9933; color:white;'>$filaTotal[5]</th>
            <th style='background-color:#ff9933; color:white;'>$filaTotal[6]</th>
            <th style='background-color:#cc99cc; color:white;'>N/A</th>
            <th style='background-color:#cc99cc; color:white;'>$filaTotal[8]</th>
            <th style='background-color:#cc99cc; color:white;'>$filaTotal[9]</th>
        </tr>";
    break;

}

$email .= "
    </table>
</div>";

/*----------------------- GENERACION CODIGO HTML - FIN -----------------------------*/



/************************ ENVIO DE CORREO ELECTRONICO - COMIENZO ********************/

    require_once('class.phpmailer.php');
    $mailer = new PHPMailer(TRUE);
    $mailer->IsSMTP();
    try{

        $mailer->Host     = 'smtp.gmail.com';
        $mailer->Port     = '587';
        //$mailer->SMTPDebug = 2;
        $mailer->SMTPSecure = 'tls';
        $mailer->Username = 'sinca.test@gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Password ="sincatest";
        $mailer->IsHTML(true);
        //$mailer->SetFrom('noresponder@sinca.com', 'Sistema S I N C A');
        $mailer->From     = 'sinca.test@gmail.com';
        $mailer->AddReplyTo('sinca.test@gmail.com');
        $mailer->FromName = 'SINCA';
        $mailer->CharSet  = 'UTF-8';
        $mailer->Subject  = "Total Diario Ciclo de Ingresos \"$diaSemanaVenezuela\" ".date("h",time()).':10 '.date("A",time()).' (Hasta Ayer)';
        $mailer->Body     = $email;
        $mailer->ClearAddresses();
        $mailer->AddAddress('eduardo@newlifeve.com');
        $mailer->Send();
        $mailer->ClearAddresses();
        $mailer->AddAddress('cabinasperu@etelix.com');
        $mailer->Send();

    }
    catch(phpmailerException $e){
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }
    catch(Exception $e){
        echo $e->getMessage(); //Boring error messages from anything else!
    }

/*----------------------- ENVIO DE CORREO ELECTRONICO - FIN ------------------------*/
?>