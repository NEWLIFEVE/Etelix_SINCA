 <?php

    /**
     * @package reportes
     */
    class cicloIngreso extends Reportes 
    {
        public static function reporte($ids=null,$name,$complete,$type,$report=false) 
        {

            $traficoTotal = 0;
            $recargaMovTotal = 0;
            $recargaClaroTotal = 0;
            $servDirecTvTotal = 0;
            $servNextelTotal = 0;
            $otrosServFullCargaTotal = 0;
            $otrosServTotal = 0;
            
            $TotalVentasTotal = 0;
            $TotalDepTotal = 0;
            $TotalBancoTotal = 0;
            $TotalDiferencialBancario = 0;
            $TotalConciliciaionBancaria = 0;
            
            $TotalDiferencialMovistar = 0;
            $TotalDiferencialClaro = 0;
            $TotalDiferencialDirectv = 0;
            $TotalDiferencialNextel = 0;
            
            $TotalTraficoCaptura = 0;
            $TotalCapturaSoles = 0;
            $TotalDiferencialCapturaSoles = 0;
            $TotalDiferencialCapturaDollar = 0;
            
            $TotalAcumuladoCaptura = 0;
            $TotalSobrante = 0;
            $TotalAcumuladoSobrante = 0;
            
            
            if($complete==false){
                
            if($report == null){    
                $balance = cicloIngreso::get_Model($ids);
            }else{
                $balance = cicloIngreso::get_Model_Ayer($report);
            }

            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("cicloI")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {
                    
                    $paridad = Paridad::getParidad($registro->Fecha);
                    
                    $totalVentas = Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $registro->Fecha, $registro->CABINA_Id);
                    $diferencialBancario = CicloIngresoModelo::getDifConBancario($registro->Fecha,$registro->CABINA_Id,1);
                    $conciliacionBancaria = CicloIngresoModelo::getDifConBancario($registro->Fecha,$registro->CABINA_Id,2);
                    
                    $diferencialMovistar = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 1);
                    $diferencialClaro = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 2);
                    $diferencialDirectv = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 4);
                    $diferencialNextel = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 3);
                    
                    $diferencialCapturaSolres = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,2);
                    $diferencialCapturaDollar = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,1);
                    
                    $acumuladoCaptura = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,3);
                    $sobrante = CicloIngresoModelo::getSobrante($registro->Fecha,$registro->CABINA_Id,false);
                    $acumuladoSobrante = CicloIngresoModelo::getSobrante($registro->Fecha,$registro->CABINA_Id,true);

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineMonto(round($totalVentas,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineMonto(round($diferencialBancario,2),round($diferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalTrafico">'.Reportes::format(Reportes::defineMonto(round($conciliacionBancaria,2),round($conciliacionBancaria,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineMonto(round($diferencialMovistar,2),$diferencialMovistar), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineMonto(round($diferencialClaro,2),$diferencialClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineMonto(round($diferencialDirectv,2),$diferencialDirectv), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineMonto(round($diferencialNextel,2),$diferencialNextel), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto(round($paridad,2)).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($diferencialCapturaSolres,2),round($diferencialCapturaSolres,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($diferencialCapturaDollar,2),round($diferencialCapturaDollar,2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($acumuladoCaptura,2),round($acumuladoCaptura,2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($sobrante,2),round($sobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($acumuladoSobrante,2),round($acumuladoSobrante,2)), $type).'</td>    
                                </tr>
                                ';
                    
                    $TotalVentasTotal = $TotalVentasTotal + $totalVentas;
                    $TotalDiferencialBancario = $TotalDiferencialBancario + $diferencialBancario;
                    $TotalConciliciaionBancaria = $TotalConciliciaionBancaria + $conciliacionBancaria;

                    $TotalDiferencialMovistar = $TotalDiferencialMovistar + $diferencialMovistar;
                    $TotalDiferencialClaro = $TotalDiferencialClaro + $diferencialClaro;
                    $TotalDiferencialDirectv = $TotalDiferencialDirectv + $diferencialDirectv;
                    $TotalDiferencialNextel = $TotalDiferencialNextel + $diferencialNextel;

                    $TotalDiferencialCapturaSoles = $TotalDiferencialCapturaSoles + $diferencialCapturaSolres;
                    $TotalDiferencialCapturaDollar = $TotalDiferencialCapturaDollar + $diferencialCapturaDollar;

                    $TotalAcumuladoCaptura = $TotalAcumuladoCaptura + $acumuladoCaptura;
                    $TotalSobrante = $TotalSobrante + $sobrante;
                    $TotalAcumuladoSobrante = $TotalAcumuladoSobrante + $acumuladoSobrante;
                    

                }
                
                if($report == null){    
                    $balanceTotals = cicloIngreso::get_ModelTotal($ids);
                }else{
                    $balanceTotals = cicloIngreso::get_Model_Ayer_Total($report);
                }

                 $table.=  Reportes::defineHeader("cicloI")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$registro->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals(round($TotalVentasTotal,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialBancario,2),round($TotalDiferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals(round($TotalConciliciaionBancaria,2),round($TotalConciliciaionBancaria,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialMovistar,2),round($TotalDiferencialMovistar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialClaro,2),round($TotalDiferencialClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialDirectv,2),round($TotalDiferencialDirectv,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialNextel,2),round($TotalDiferencialNextel,2)), $type).'</td>    
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialCapturaSoles,2),round($TotalDiferencialCapturaSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialCapturaDollar,2),round($TotalDiferencialCapturaDollar,2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">N/A</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($TotalSobrante,2),round($TotalSobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">N/A</td>   
                                      </tr>
                                    </tbody>
                           </table>';

            }else{
                $table='Hubo un error';
            }
            
        }else{
            $acumulado_total = 0;
            $sobranteacumulado_total = 0;
            $balance = cicloIngreso::get_Model($ids);
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("cicloIC")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {
                    
                $paridad = Paridad::getParidad($registro->Fecha);
                    
                    //LIBRO DE VENTAS
                    $trafico = Detalleingreso::getLibroVentas("LibroVentas","trafico", $registro->Fecha, $registro->CABINA_Id);
                    $servMovistar = Detalleingreso::getLibroVentas("LibroVentas","ServMov", $registro->Fecha, $registro->CABINA_Id);
                    $servClaro = Detalleingreso::getLibroVentas("LibroVentas","ServClaro", $registro->Fecha, $registro->CABINA_Id);
                    $servDirectv = Detalleingreso::getLibroVentas("LibroVentas","ServDirecTv", $registro->Fecha, $registro->CABINA_Id);
                    $servNextel = Detalleingreso::getLibroVentas("LibroVentas","ServNextel", $registro->Fecha, $registro->CABINA_Id);
                    $otrosServiciosFullCarga = Detalleingreso::getLibroVentas("LibroVentas","OtrosServiciosFullCarga", $registro->Fecha, $registro->CABINA_Id, 8);
                    $otrosServicios = Detalleingreso::getLibroVentas("LibroVentas","servicio", $registro->Fecha, $registro->CABINA_Id, 8);
                    $totalVentas = Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $registro->Fecha, $registro->CABINA_Id);
                    
                    //DEPOSITOS
                    $fechaDeposito = Deposito::getDataDeposito($registro->Fecha,$registro->CABINA_Id,'Fecha');
                    $horaDeposito = Deposito::getDataDeposito($registro->Fecha,$registro->CABINA_Id,'Hora');
                    $montoBanco = Deposito::valueNull(Deposito::getMontoBanco($registro->Fecha, $registro->CABINA_Id));
                    $montoDep = Deposito::valueNull(Deposito::getDeposito($registro->Fecha, $registro->CABINA_Id));
                    $diferencialBancario = CicloIngresoModelo::getDifConBancario($registro->Fecha,$registro->CABINA_Id,1);
                    $conciliacionBancaria = CicloIngresoModelo::getDifConBancario($registro->Fecha,$registro->CABINA_Id,2);
                    
                    //FULLCARGA
                    $diferencialMovistar = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 1);
                    $diferencialClaro = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 2);
                    $diferencialDirectv = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 4);
                    $diferencialNextel = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 3);
                    
                    //CAPTURA
                    $traficoCarptura = Detalleingreso::TraficoCapturaDollar($registro->Fecha,$registro->CABINA_Id);
                    $paridad = Paridad::getParidad($registro->Fecha);
                    $capturaSoles = round((Detalleingreso::TraficoCapturaDollar($registro->Fecha,$registro->CABINA_Id)*Paridad::getParidad($registro->Fecha)),2);
                    $diferencialCapturaSolres = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,2);
                    $diferencialCapturaDollar = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,1);

                    //ACUMULADOS Y SOBRANTES    
                    $acumuladoCaptura = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,3);
                    $sobrante = CicloIngresoModelo::getSobrante($registro->Fecha,$registro->CABINA_Id,false);
                    $acumuladoSobrante = CicloIngresoModelo::getSobrante($registro->Fecha,$registro->CABINA_Id,true);
                

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                                        
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($trafico,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($servMovistar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($servClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($servDirectv,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($servNextel,2)), $type).'</td>    
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($otrosServiciosFullCarga,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($otrosServicios,2)), $type).'</td>    
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($totalVentas,2)), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.$fechaDeposito.'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.$horaDeposito.'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($montoDep,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($montoBanco,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialBancario,2),round($diferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($conciliacionBancaria,2),round($conciliacionBancaria,2)), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialMovistar,2),round($diferencialMovistar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialClaro,2),round($diferencialClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialDirectv,2),round($diferencialDirectv,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialNextel,2),round($diferencialNextel,2)), $type).'</td>

                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($traficoCarptura,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto(round($paridad,2)).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($capturaSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialCapturaSolres,2),round($diferencialCapturaSolres,2)), $type).'</td>   
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($diferencialCapturaDollar,2),round($diferencialCapturaDollar,2)), $type).'</td>      

                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round($acumuladoCaptura,2),round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round($sobrante,2),round($sobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round($acumuladoSobrante,2),round($acumuladoSobrante,2)), $type).'</td>    
                                </tr>
                                ';
                    
                    $traficoTotal = $traficoTotal + $trafico;
                    $recargaMovTotal = $recargaMovTotal + $servMovistar;
                    $recargaClaroTotal = $recargaClaroTotal + $servClaro;
                    $servDirecTvTotal = $servDirecTvTotal + $servDirectv;
                    $servNextelTotal = $servNextelTotal + $servNextel;
                    $otrosServFullCargaTotal = $otrosServFullCargaTotal + $otrosServiciosFullCarga;
                    $otrosServTotal = $otrosServTotal + $otrosServicios;

                    $TotalVentasTotal = $TotalVentasTotal + $totalVentas;
                    $TotalDepTotal = $TotalDepTotal + $montoDep;
                    $TotalBancoTotal = $TotalBancoTotal + $montoBanco;
                    $TotalDiferencialBancario = $TotalDiferencialBancario + $diferencialBancario;
                    $TotalConciliciaionBancaria = $TotalConciliciaionBancaria + $conciliacionBancaria;

                    $TotalDiferencialMovistar = $TotalDiferencialMovistar + $diferencialMovistar;
                    $TotalDiferencialClaro = $TotalDiferencialClaro + $diferencialClaro;
                    $TotalDiferencialDirectv = $TotalDiferencialDirectv + $diferencialDirectv;
                    $TotalDiferencialNextel = $TotalDiferencialNextel + $diferencialNextel;

                    $TotalTraficoCaptura = $TotalTraficoCaptura + $traficoCarptura;
                    $TotalCapturaSoles = $TotalCapturaSoles + $capturaSoles;
                    $TotalDiferencialCapturaSoles = $TotalDiferencialCapturaSoles + $diferencialCapturaSolres;
                    $TotalDiferencialCapturaDollar = $TotalDiferencialCapturaDollar + $diferencialCapturaDollar;

                    $TotalAcumuladoCaptura = $TotalAcumuladoCaptura + $acumuladoCaptura;
                    $TotalSobrante = $TotalSobrante + $sobrante;
                    $TotalAcumuladoSobrante = $TotalAcumuladoSobrante + $acumuladoSobrante;     
                    
                }
                
                 $balanceTotals = cicloIngreso::get_ModelTotalComplete($ids);
                 $table.=  Reportes::defineHeader("cicloIC")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$registro->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($traficoTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($recargaMovTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($recargaClaroTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($servDirecTvTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($servNextelTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($otrosServFullCargaTotal), $type).'</td>    
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($otrosServTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($TotalVentasTotal), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDepTotal,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalBancoTotal,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialBancario,2),round($TotalDiferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalConciliciaionBancaria,2),round($TotalConciliciaionBancaria,2)), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialMovistar,2),round($TotalDiferencialMovistar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialClaro,2),round($TotalDiferencialClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialDirectv,2),round($TotalDiferencialDirectv,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialNextel,2),round($TotalDiferencialNextel,2)), $type).'</td>

                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalTraficoCaptura,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalCapturaSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialCapturaSoles,2),round($TotalDiferencialCapturaSoles,2)), $type).'</td>   
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($TotalDiferencialCapturaDollar,2),round($TotalDiferencialCapturaDollar,2)), $type).'</td>      

                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($TotalAcumuladoCaptura,$TotalAcumuladoCaptura), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals(round($TotalSobrante,2),round($TotalSobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($TotalAcumuladoSobrante,$TotalAcumuladoSobrante), $type).'</td>      
                                      </tr>
                                    </tbody>
                           </table>';

            }else{
                $table='Hubo un error';
            }
            
        }  
            return $table;
        }
            
         
        public static function get_Model($ids) 
        {
            $sql = "SELECT s.Id, s.Fecha, s.CABINA_Id, c.Nombre as Cabina
                    FROM saldo_cabina as s
                    INNER JOIN cabina as c ON c.id = s.CABINA_Id
                    WHERE s.Id IN ($ids) 
                    order by s.Fecha DESC, c.Nombre ASC;";
            
              return SaldoCabina::model()->findAllBySql($sql); 
         
        }
        
        public static function get_Model_Ayer($date) 
        {
            $sql = "SELECT b.CABINA_Id, b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                   (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) as TotalVentas,  
                   (IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as DiferencialBancario,
                   (IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)) as ConciliacionBancaria,
                   (IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))) as DifMov,
                   (IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))) as DifClaro,
                   IFNULL(p.Valor,0) AS Paridad,
		   ((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)) as DifSoles,
                   (((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor) as DifDollar,
                   IFNULL(b.Acumulado,0) AS Acumulado,
                   sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar) AS Sobrante,
                   IFNULL(b.SobranteAcum,0) AS SobranteAcum

                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.Fecha = CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-',DAY(CURDATE())-1)
                    AND b.CABINA_Id NOT IN (18,19)
		    AND c.status  = 1
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelComplete($ids) 
        {
            $sql = "SELECT b.CABINA_Id, b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                    TRUNCATE(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0),2) as Trafico, 
                    TRUNCATE(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0),2) as RecargaMovistar,
                    TRUNCATE(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0),2) as RecargaClaro,
                    b.OtrosServicios as OtrosServicios,
                   (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) as TotalVentas,  
                    b.FechaDep as FechaDep,
                    b.HoraDep as HoraDep,
                    b.MontoDeposito as MontoDeposito,
                    b.MontoBanco as MontoBanco, 
                   (IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as DiferencialBancario,
                   (IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)) as ConciliacionBancaria,
                    b.RecargaVentasMov as RecargaVentasMovistar,
                   (IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))) as DifMov,
                    b.RecargaVentasClaro as RecargaVentasClaro, 
                   (IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))) as DifClaro,
                    b.TraficoCapturaDollar as TraficoCapturaDollar,
		    IFNULL(p.Valor,0) AS Paridad,
		    (IFNULL(b.TraficoCapturaDollar,0)*p.Valor) as CaptSoles,
		    ((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)) as DifSoles,
                    (((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor) as DifDollar,
                   IFNULL(b.Acumulado,0) AS Acumulado,
                   sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar) AS Sobrante,
                   IFNULL(b.SobranteAcum,0) AS SobranteAcum
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.CABINA_Id, b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                   sum((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,
                   sum((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                   sum((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
                   sum((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                   sum((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
                   sum(IFNULL(p.Valor,0)) AS Paridad,
		   sum(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))) as DifSoles,
                   sum((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor)) as DifDollar,
                   sum(IFNULL(b.Acumulado,0)) AS Acumulado,
                   sum(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar)) AS Sobrante,
                   sum(IFNULL(b.SobranteAcum,0)) AS SobranteAcum

                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
        
        public static function get_Model_Ayer_Total($date) 
        {
            $sql = "SELECT b.CABINA_Id, b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                   sum((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,
                   sum((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                   sum((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
                   sum((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                   sum((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
                   sum(IFNULL(p.Valor,0)) AS Paridad,
		   sum(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))) as DifSoles,
                   sum((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor)) as DifDollar,
                   sum(IFNULL(b.Acumulado,0)) AS Acumulado,
                   sum(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar)) AS Sobrante,
                   sum(IFNULL(b.SobranteAcum,0)) AS SobranteAcum

                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.Fecha = CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-',DAY(CURDATE())-1)
                    AND b.CABINA_Id NOT IN (18,19)
		    AND c.status  = 1";
            
              return Balance::model()->findBySql($sql); 
         
        }
        
        public static function get_ModelTotalComplete($ids) 
        {
            $sql = "SELECT b.CABINA_Id, b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                    sum(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)) as Trafico, 
                    sum(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)) as RecargaMovistar,
                    sum(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)) as RecargaClaro,
                    sum(b.OtrosServicios) as OtrosServicios,
                   sum((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
                   
                    b.FechaDep as FechaDep,
                    b.HoraDep as HoraDep,
                   
                    sum(b.MontoDeposito) as MontoDeposito,
                    sum(b.MontoBanco) as MontoBanco, 
                   sum((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                   sum((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
                   
                   sum( b.RecargaVentasMov) as RecargaVentasMov,
                   sum((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                   sum( b.RecargaVentasClaro) as RecargaVentasClaro, 
                   sum((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
                    
                    sum(b.TraficoCapturaDollar) as TraficoCapturaDollar,
					TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
					sum((IFNULL(b.TraficoCapturaDollar,0)*p.Valor)) as CaptSoles,
					sum(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))) as DifSoles,
                    sum((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor)) as DifDollar,

                   sum(IFNULL(b.Acumulado,0)) AS Acumulado,
                   sum(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar)) AS Sobrante,
                   sum(IFNULL(b.SobranteAcum,0)) AS SobranteAcum
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>