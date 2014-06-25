<?php
set_time_limit(7200); 

//
///*-------------------INICIO - EXPORTAR DATA DE BALANCE A DEPOSITO--------------------------------------*/
//
//$sql = "SELECT Fecha, FechaDep, HoraDep, MontoDeposito, MontoBanco, NumRefDeposito, Depositante, 
//        CUENTA_Id, CABINA_Id 
//        FROM balance
//        WHERE FechaDep IS NOT NULL 
//        AND MontoDeposito IS NOT NULL 
//        AND FechaDep != '0000-00-00'
//        AND CABINA_Id != 18
//        AND CABINA_Id != 19
//        ORDER BY FechaDep;";
////
//$depositos = Balance::model()->findAllBySql($sql);
////
//////echo '<table>';
//////
//////echo "<tr><td>Fecha</td> <td>Hora</td> <td>MontoDeposito</td> <td>MontoBanco</td> 
//////              <td>NumReferencia</td> <td>Depositante</td> <td>CuentaId</td> <td>CabinaId</td></tr>";
////
//foreach ($depositos as $key => $value) {
//    
//    $Fecha = $value->Fecha;
//    $FechaDep = $value->FechaDep;
//    $Hora = $value->HoraDep;
//    $MontoDeposito = $value->MontoDeposito;
//    $MontoBanco = $value->MontoBanco;
//    $NumReferencia = $value->NumRefDeposito;
//    $Depositante = $value->Depositante;
//    $CuentaId = $value->CUENTA_Id;
//    $CabinaId = $value->CABINA_Id;
//    
////    echo "<tr>
////            <td>$Fecha</td> <td>$Hora</td> <td>$MontoDeposito</td> <td>$MontoBanco</td> 
////            <td>$NumReferencia</td> <td>$Depositante</td> <td>$CuentaId</td> <td>$CabinaId</td>
////          </tr>";
//    
    // CREATE DEPOSITOS
//    $Deposito = new Deposito;
//    $Deposito->unsetAttributes(); 
//
//    $Deposito->FechaCorrespondiente = $Fecha;
//    $Deposito->Fecha = $FechaDep;
//    $Deposito->Hora = $Hora;
//    $Deposito->MontoDep = $MontoDeposito;
//    $Deposito->MontoBanco = $MontoBanco;
//    $Deposito->NumRef = $NumReferencia;
//    $Deposito->Depositante = $Depositante;
//    $Deposito->CUENTA_Id = $CuentaId;
//    $Deposito->CABINA_Id = $CabinaId;
//    $Deposito->save();
//    
//}
//
////echo '</table>';
//
///*-------------------FIN - EXPORTAR DATA DE BALANCE A DEPOSITO--------------------------------------*/
//
//
//
//
///*-------------------INICIO - EXPORTAR DATA DE BALANCE A SALDO CABINA--------------------------------------*/
//
//$sql = "SELECT Fecha, IF(SaldoApMov = -1.00,0.00,SaldoApMov) as SaldoApMov, 
//        IF(SaldoApClaro = -1.00,0.00,SaldoApClaro) as SaldoApClaro, SaldoCierreMov, SaldoCierreClaro, CABINA_Id 
//        FROM balance
//        WHERE Fecha != '0000-00-00'
//        AND CABINA_Id != 18
//        AND CABINA_Id != 19
//        ORDER BY Fecha DESC;";
//
//$saldos = Balance::model()->findAllBySql($sql);
//////
////echo '<table>';
//////
//////echo "<tr><td>Fecha</td> <td>Saldo Apertura Mov</td> <td>Saldo Apertura Claro</td>
//////          <td>Saldo Cierre Mov</td> <td>Saldo Cierre Claro</td> <td>CabinaId</td></tr>";
//////
//foreach ($saldos as $key => $value) {
//    
//    $Fecha = $value->Fecha;
//    $SaldoApMov = $value->SaldoApMov;
//    $SaldoApClaro = $value->SaldoApClaro;
//    $SaldoCierreMov = $value->SaldoCierreMov;
//    $SaldoCierreClaro = $value->SaldoCierreClaro;
//    $CabinaId = $value->CABINA_Id;
//////    
////    echo "<tr>
////            <td>$Fecha</td> <td>$SaldoApMov</td> <td>$SaldoApClaro</td>
////            <td>$SaldoCierreMov</td> <td>$SaldoCierreClaro</td> <td>$CabinaId</td>
////          </tr>";
//////    
//////    // CREATE SALDOS    
//    for($i=1;$i<3;$i++){
//        $SaldoCabina = new SaldoCabina;
//        $SaldoCabina->unsetAttributes(); 
//        $SaldoCabina->Fecha = $Fecha;
//        
//        if($i==1){
//            $SaldoCabina->SaldoAp = $SaldoApMov;
//            $SaldoCabina->SaldoCierre = $SaldoCierreMov;
//        }elseif($i==2){
//            $SaldoCabina->SaldoAp = $SaldoApClaro;
//            $SaldoCabina->SaldoCierre = $SaldoCierreClaro;
//        }   
//        
//        $SaldoCabina->COMPANIA_Id = $i;
//        $SaldoCabina->CABINA_Id = $CabinaId;
//        $SaldoCabina->save();
//    }
//
//}
//
//echo '</table>';

/*-------------------FIN - EXPORTAR DATA DE BALANCE A SALDO CABINA--------------------------------------*/




/*-------------------INICIO - EXPORTAR DATA DE BALANCE A DETALLE INGRESO---------------------------------*/
//
//$sql = "SELECT Fecha, FijoLocal, FijoProvincia, FijoLima, Rural, Celular, LDI, OtrosServicios,
//        RecargaCelularMov, RecargaFonoYaMov, RecargaCelularClaro, RecargaFonoClaro, CABINA_Id, CUENTA_Id, 
//        RecargaVentasMov, RecargaVentasClaro, TraficoCapturaDollar
//        FROM balance
//        WHERE EXTRACT(YEAR FROM Fecha) = '2013' 
//        AND EXTRACT(MONTH FROM Fecha) = '03'
//        AND Fecha IS NOT NULL 
//        AND Fecha != '0000-00-00' 
//        AND CABINA_Id != 18 AND CABINA_Id != 19
//        AND (RecargaVentasMov IS NOT NULL
//        OR RecargaVentasClaro IS NOT NULL
//        OR TraficoCapturaDollar IS NOT NULL)
//        ORDER BY Fecha;";
//
//$ingresos = Balance::model()->findAllBySql($sql);
//
//$arrayIngresosMonto = Array('FijoLocal','FijoProvincia','FijoLima','Rural','Celular',
//                            'LDI','OtrosServicios', 'RecargaCelularMov','RecargaFonoYaMov',
//                            'RecargaCelularClaro','RecargaFonoClaro','RecargaVentasMov',
//                            'RecargaVentasClaro','TraficoCapturaDollar');
//
//$arrayIngresosTipo = Array(3,4,5,6,7,8,9,11,10,12,13,14,15,16);
////
//////echo '<table>';
////
//////echo "<tr><td>Fecha</td> <td>Hora</td> <td>MontoDeposito</td> <td>MontoBanco</td> 
//////              <td>NumReferencia</td> <td>Depositante</td> <td>CuentaId</td> <td>CabinaId</td></tr>";
////
//foreach ($ingresos as $key => $value) {
//    
//    $Fecha = $value->Fecha;
//    
//    for($i=0;$i<  count($arrayIngresosMonto);$i++){
//        $$arrayIngresosMonto[$i] = $value->$arrayIngresosMonto[$i];
//    }
//    
//    
//    
//    $CabinaId = $value->CABINA_Id;
//    $CuentaId = 4;
////    
//    for($i=0;$i<  count($arrayIngresosMonto);$i++){
//        // CREATE INGRESOS
//        if($$arrayIngresosMonto[$i] != NULL){
//            
//            $Ingreso = new Detalleingreso;
//            $Ingreso->unsetAttributes(); 
//
//            $Ingreso->FechaMes = $Fecha;
//            $Ingreso->Monto = $$arrayIngresosMonto[$i];     
//            $Ingreso->CABINA_Id = $CabinaId;
//            
//            if($arrayIngresosTipo[$i] > 13 && $arrayIngresosTipo[$i] < 17){
//                $Ingreso->USERS_Id = 58;
//            }else{
//                $Ingreso->USERS_Id = Users::getUserIdFromCabina($CabinaId);
//            }
//            
//            $Ingreso->TIPOINGRESO_Id = $arrayIngresosTipo[$i];
//            
//            if($arrayIngresosTipo[$i] == 16){
//                $Ingreso->moneda = 1;
//            }else{
//                $Ingreso->moneda = 2;
//            }
//            
//            if($CabinaId == 17){
//                $Ingreso->CUENTA_Id = 2;
//            }else{
//                $Ingreso->CUENTA_Id = 4;
//            }
//            
//            $Ingreso->FechaTransf = NULL;
//            $Ingreso->TransferenciaPago = NULL;
//            $Ingreso->Descripcion = NULL;
//            $Ingreso->save();
//            
//        }
//    }
//    
//    
//    
//}

    

    

//echo '</table>';

   

/*-------------------FIN - EXPORTAR DATA DE BALANCE A DETALLE INGRESO--------------------------------------*/

///*-------------------INICIO - EXPORTAR DATA DE BALANCE A CICLO INGRESO--------------------------------------*/
//
//$sql = "SELECT b.*, p.Valor as Paridad
//        FROM balance as b
//        INNER JOIN paridad as p ON p.Id = b.PARIDAD_Id
//        WHERE b.CABINA_Id != 18 
//        AND b.CABINA_Id != 19
//        AND b.Fecha != '0000-00-00'
//        ORDER BY b.Fecha;";
//
//$cicloIngresos = Balance::model()->findAllBySql($sql);
////
////echo '<table>';
//////
//////echo "<tr><td>Fecha</td> <td>Hora</td> <td>MontoDeposito</td> <td>MontoBanco</td> 
//////              <td>NumReferencia</td> <td>Depositante</td> <td>CuentaId</td> <td>CabinaId</td></tr>";
////
//foreach ($cicloIngresos as $key => $value) {
//    
//    $Paridad = $value->Paridad;
//    
//    $Fecha = $value->Fecha;
//    $FechaDep = $value->FechaDep;
//    $Hora = $value->HoraDep;
//    $MontoDeposito = $value->MontoDeposito;
//    $MontoBanco = $value->MontoBanco;
//    $NumReferencia = $value->NumRefDeposito;
//    $Depositante = $value->Depositante;
//    $CuentaId = $value->CUENTA_Id;
//    $CabinaId = $value->CABINA_Id;
//    
//    $RecargaVentasMov = $value->RecargaVentasMov;
//    $RecargaVentasClaro = $value->RecargaVentasClaro;
//    $TraficoCapturaDollar = $value->TraficoCapturaDollar;
//    
//    $FijoLocal = $value->FijoLocal;
//    $FijoProvincia = $value->FijoProvincia;
//    $FijoLima = $value->FijoLima;
//    $Rural = $value->Rural;
//    $Celular = $value->Celular;
//    $LDI = $value->LDI;
//    
//    $OtrosServicios = $value->OtrosServicios;
//    $RecargaCelularMov = $value->RecargaCelularMov;
//    $RecargaFonoYaMov = $value->RecargaFonoYaMov;
//    $RecargaCelularClaro = $value->RecargaCelularClaro;
//    $RecargaFonoClaro = $value->RecargaFonoClaro;
//    
//    $Trafico = $FijoLocal+$FijoProvincia+$FijoLima+$Rural+$Celular+$LDI;
//    $TotalVentas = $Trafico+$RecargaCelularMov+$RecargaFonoYaMov+$RecargaCelularClaro+$RecargaFonoClaro+$OtrosServicios;
//    
//    $DifBancario = $MontoBanco - $TotalVentas;
//    $ConBancaria = $MontoBanco - $MontoDeposito;
//    
//    $DiferencialMov = ($RecargaVentasMov-($RecargaCelularMov+$RecargaFonoYaMov));
//    $DiferencialClaro = ($RecargaVentasClaro-($RecargaCelularClaro+$RecargaFonoClaro));
//    
//    $DiferencialCaptura = (($Trafico-$TraficoCapturaDollar*$Paridad)/$Paridad);
//    
//    $AcumuladoCaptura = $value->Acumulado;
//    
//    $Sobrante = (($DifBancario+$DiferencialMov+$DiferencialClaro+($DiferencialCaptura*$Paridad))/$Paridad);
//    $AcumuladoSobrante = $value->SobranteAcum;
//    
//    
////    echo "<tr>
////            <td>$Fecha</td> <td>$CabinaId</td> <td>$DifBancario</td> <td>$ConBancaria</td> 
////            <td>$DiferencialMov</td> <td>$DiferencialClaro</td> <td>$DiferencialCaptura</td> <td>$AcumuladoCaptura</td>
////            <td>$Sobrante</td> <td>$AcumuladoSobrante</td>    
////          </tr>";
//    
//    // CREATE DEPOSITOS
//    $CicloIngreso = new CicloIngresoModelo;
//    $CicloIngreso->unsetAttributes(); 
//    
//    $CicloIngreso->Fecha = $Fecha;
//    $CicloIngreso->CABINA_Id = $CabinaId;
//    
//    $CicloIngreso->DiferencialBancario = round($DifBancario,2);
//    $CicloIngreso->ConciliacionBancaria = round($ConBancaria,2);
//    
//    $CicloIngreso->DiferencialMovistar = round($DiferencialMov,2);
//    $CicloIngreso->DiferencialClaro = round($DiferencialClaro,2);
//    
//    $CicloIngreso->DiferencialCaptura = round($DiferencialCaptura,2);
//    $CicloIngreso->AcumuladoCaptura = round($AcumuladoCaptura,2);
//            
//    $CicloIngreso->Sobrante = round($Sobrante,2);
//    $CicloIngreso->AcumuladoSobrante = round($AcumuladoSobrante,2);       
//    
//    $CicloIngreso->save();
//    
////    echo'<pre>'.print_r($CicloIngreso).'</pre>';
//    
//}
//
//echo '</table>';
//
///*-------------------FIN - EXPORTAR DATA DE BALANCE A CICLO INGRESO--------------------------------------*/






///*---------------------------------------------------------*/
//
$sql = "SELECT * FROM sinca2prod.tipo_ingresos WHERE COMPANIA_Id = 1 AND ID NOT IN(10,18,47,14);";

$depositos = TipoIngresos::model()->findAllBySql($sql);

foreach ($depositos as $key => $value) {
    
    $Fecha = '2014-03-24';
    $Valor = 0.050;
    $Compania = 1;
    $TipoComision = 1;
    $TipoIngreso = $value->Id;
    

    
    //CREATE DEPOSITOS
    $Deposito = new Comision;
    $Deposito->unsetAttributes(); 

    $Deposito->Fecha = $Fecha;
    $Deposito->Valor = $Valor;
    $Deposito->COMPANIA_Id = $Compania;
    $Deposito->TIPOCOMISION_Id = $TipoComision;
    $Deposito->TIPOINGRESO_Id = $TipoIngreso;
    $Deposito->save();
    
}


///*---------------------------------------------------------*/