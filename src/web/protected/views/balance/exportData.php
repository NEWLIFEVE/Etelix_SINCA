<?php
set_time_limit(3600); 
//
///*-------------------INICIO - EXPORTAR DATA DE BALANCE A DEPOSITO--------------------------------------*/
//
//$sql = "SELECT Fecha, FechaDep, HoraDep, MontoDeposito, MontoBanco, NumRefDeposito, Depositante, 
//        CUENTA_Id, CABINA_Id 
//        FROM balance
//        WHERE FechaDep IS NOT NULL AND HoraDep IS NOT NULL AND MontoDeposito IS NOT NULL 
//	AND NumRefDeposito IS NOT NULL AND CUENTA_Id IS NOT NULL AND CUENTA_Id IS NOT NULL 
//        AND FechaDep != '0000-00-00'
//        ORDER BY FechaDep;";
//
//$depositos = Balance::model()->findAllBySql($sql);
//
////echo '<table>';
////
////echo "<tr><td>Fecha</td> <td>Hora</td> <td>MontoDeposito</td> <td>MontoBanco</td> 
////              <td>NumReferencia</td> <td>Depositante</td> <td>CuentaId</td> <td>CabinaId</td></tr>";
//
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
//    // CREATE DEPOSITOS
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
//$sql = "SELECT Fecha, SaldoApMov, SaldoApClaro, SaldoCierreMov, SaldoCierreClaro, CABINA_Id 
//        FROM balance
//        WHERE SaldoApMov IS NOT NULL AND SaldoApClaro IS NOT NULL 
//	AND CUENTA_Id IS NOT NULL AND FechaDep != '0000-00-00'
//        ORDER BY Fecha;";
//
//$saldos = Balance::model()->findAllBySql($sql);
//
////echo '<table>';
////
////echo "<tr><td>Fecha</td> <td>Saldo Apertura Mov</td> <td>Saldo Apertura Claro</td>
////          <td>Saldo Cierre Mov</td> <td>Saldo Cierre Claro</td> <td>CabinaId</td></tr>";
//
//foreach ($saldos as $key => $value) {
//    
//    $Fecha = $value->Fecha;
//    $SaldoApMov = $value->SaldoApMov;
//    $SaldoApClaro = $value->SaldoApClaro;
//    $SaldoCierreMov = $value->SaldoCierreMov;
//    $SaldoCierreClaro = $value->SaldoCierreClaro;
//    $CabinaId = $value->CABINA_Id;
//    
////    echo "<tr>
////            <td>$Fecha</td> <td>$SaldoApMov</td> <td>$SaldoApClaro</td>
////            <td>$SaldoCierreMov</td> <td>$SaldoCierreClaro</td> <td>$CabinaId</td>
////          </tr>";
//    
//    // CREATE SALDOS    
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

$sql = "SELECT Fecha, FijoLocal, FijoProvincia, FijoLima, Rural, Celular, LDI, OtrosServicios,
        RecargaCelularMov, RecargaFonoYaMov, RecargaCelularClaro, RecargaFonoClaro, CABINA_Id, CUENTA_Id, 
        RecargaVentasMov, RecargaVentasClaro, TraficoCapturaDollar
        FROM balance
        WHERE Fecha IS NOT NULL AND Fecha != '0000-00-00' AND CABINA_Id != 18 AND CABINA_Id != 19
        AND (RecargaVentasMov IS NOT NULL
        OR RecargaVentasClaro IS NOT NULL
        OR TraficoCapturaDollar IS NOT NULL)
        ORDER BY Fecha;";

$ingresos = Balance::model()->findAllBySql($sql);

$arrayIngresosMonto = Array('FijoLocal','FijoProvincia','FijoLima','Rural','Celular','LDI','OtrosServicios',
                            'RecargaCelularMov','RecargaFonoYaMov','RecargaCelularClaro','RecargaFonoClaro',
                            'RecargaVentasMov','RecargaVentasClaro','TraficoCapturaDollar');

$arrayIngresosTipo = Array(2,3,4,5,6,7,8,9,10,11,12,13,14,15);

//echo '<table>';

//echo "<tr><td>Fecha</td> <td>Hora</td> <td>MontoDeposito</td> <td>MontoBanco</td> 
//              <td>NumReferencia</td> <td>Depositante</td> <td>CuentaId</td> <td>CabinaId</td></tr>";

foreach ($ingresos as $key => $value) {
    
    $Fecha = $value->Fecha;
    $RecargaVentasMov = $value->RecargaVentasMov;
    $RecargaVentasClaro = $value->RecargaVentasClaro;
    $TraficoCapturaDollar = $value->TraficoCapturaDollar;
    $CabinaId = $value->CABINA_Id;
    $CuentaId = 4;
//    
    for($i=0;$i<15;$i++){
        // CREATE INGRESOS
        if($$arrayIngresosMonto[$i] != NULL){
            
            $Ingreso = new Detalleingreso;
            $Ingreso->unsetAttributes(); 

            $Ingreso->FechaMes = $Fecha;
            $Ingreso->Monto = $$arrayIngresosMonto[$i];     
            $Ingreso->CABINA_Id = $CabinaId;
            
            if($arrayIngresosTipo[$i] > 12 && $arrayIngresosTipo[$i] < 16){
                $Ingreso->USERS_Id = 40;
            }else{
                $Ingreso->USERS_Id = Users::getUserIdFromCabina($CabinaId);
            }
            
            $Ingreso->TIPOINGRESO_Id = $arrayIngresosTipo[$i];
            $Ingreso->moneda = 2;
            
            if($CabinaId == 17){
                $Ingreso->CUENTA_Id = 2;
            }else{
                $Ingreso->CUENTA_Id = 4;
            }
            
            $Ingreso->FechaTransf = NULL;
            $Ingreso->TransferenciaPago = NULL;
            $Ingreso->Descripcion = NULL;
            $Ingreso->save();
            
        }
    }
    
    
    
}

    

    

//echo '</table>';

   

/*-------------------FIN - EXPORTAR DATA DE BALANCE A DEPOSITO--------------------------------------*/