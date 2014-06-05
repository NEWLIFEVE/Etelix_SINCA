 <?php

    /**
     * @package reportes
     */
    class cicloIngresoTotal extends Reportes 
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
                $balance = cicloIngresoTotal::get_Model($ids);
            }else{
//                $balance = cicloIngresoTotal::get_Model_Ayer($report);
            }
            
            $acumulado_total = 0;
            $sobranteacumulado_total = 0;
            
            if($balance != NULL){
                
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("cicloI")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $paridad = Paridad::getParidad($registro->Fecha);
                    
                    $totalVentas = Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $registro->Fecha, NULL);
                    $diferencialBancario = CicloIngresoModelo::getDifConBancario($registro->Fecha,NULL,1);
                    $conciliacionBancaria = CicloIngresoModelo::getDifConBancario($registro->Fecha,NULL,2);
                    
                    $diferencialMovistar = CicloIngresoModelo::getDifFullCarga($registro->Fecha, NULL, 1);
                    $diferencialClaro = CicloIngresoModelo::getDifFullCarga($registro->Fecha, NULL, 2);
                    $diferencialDirectv = CicloIngresoModelo::getDifFullCarga($registro->Fecha, NULL, 4);
                    $diferencialNextel = CicloIngresoModelo::getDifFullCarga($registro->Fecha, NULL, 3);
                    
                    $diferencialCapturaSolres = CicloIngresoModelo::getDifCaptura($registro->Fecha,NULL,2);
                    $diferencialCapturaDollar = CicloIngresoModelo::getDifCaptura($registro->Fecha,NULL,1);
                    
                    $acumuladoCaptura = CicloIngresoModelo::getDifCaptura($registro->Fecha,NULL,3);
                    $sobrante = CicloIngresoModelo::getSobrante($registro->Fecha,NULL,false);
                    $acumuladoSobrante = CicloIngresoModelo::getSobrante($registro->Fecha,NULL,true);
                    
                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>Todas</td>
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
//                if($report != null){
//                 $balanceTotals = cicloIngresoTotal::get_ModelTotal_Ayer($ids);
//                }else{
//                 $balanceTotals = cicloIngresoTotal::get_ModelTotal($ids);   
//                }
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
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($TotalAcumuladoCaptura,$TotalAcumuladoCaptura), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($TotalSobrante,2),round($TotalSobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($TotalAcumuladoSobrante,$TotalAcumuladoSobrante), $type).'</td>   
                                      </tr>
                                    </tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            
        }
        else{
            
            $balance = cicloIngreso::get_ModelComplete($ids);
            $acumulado_total = 0;
            $sobranteacumulado_total = 0;
            
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("cicloIC")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                        
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->Trafico), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->RecargaMovistar), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->RecargaClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->OtrosServicios), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->TotalVentas), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->FechaDep).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->HoraDep).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MontoDeposito), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MontoBanco), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DiferencialBancario,$registro->DiferencialBancario), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->ConciliacionBancaria,$registro->ConciliacionBancaria), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->RecargaVentasMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DifMov,$registro->DifMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->RecargaVentasClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DifClaro,$registro->DifClaro), $type).'</td>

                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->TraficoCapturaDollar), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->Paridad).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->CaptSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DifSoles,$registro->DifSoles), $type).'</td>   
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DifDollar,$registro->DifDollar), $type).'</td>      

                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round(Balance::Acumulado($registro->Fecha,NULL,true),2),round(Balance::Acumulado($registro->Fecha,NULL,true),2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto($registro->Sobrante,$registro->Sobrante), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round(Balance::SobranteAcumulado($registro->Fecha,NULL,true),2),round(Balance::SobranteAcumulado($registro->Fecha,NULL,true),2)), $type).'</td>    
                                </tr>
                                ';
                    
                    $acumulado_total = $acumulado_total + round(Balance::Acumulado($registro->Fecha,NULL,true),2);
                    $sobranteacumulado_total = $sobranteacumulado_total + round(Balance::SobranteAcumulado($registro->Fecha,NULL,true),2);

                }
                
                 $balanceTotals = cicloIngreso::get_ModelTotalComplete($ids);
                 $table.=  Reportes::defineHeader("cicloIC")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->Trafico), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaMovistar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->OtrosServicios), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->TotalVentas), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->MontoDeposito), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->MontoBanco), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DiferencialBancario,$registro->DiferencialBancario), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->ConciliacionBancaria,$registro->ConciliacionBancaria), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaVentasMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifMov,$registro->DifMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaVentasClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifClaro,$registro->DifClaro), $type).'</td>

                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->TraficoCapturaDollar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->CaptSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifSoles,$registro->DifSoles), $type).'</td>   
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifDollar,$registro->DifDollar), $type).'</td>      

                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineMonto($acumulado_total,$acumulado_total), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineMonto($balanceTotals->Sobrante,$registro->Sobrante), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineMonto($sobranteacumulado_total,$sobranteacumulado_total), $type).'</td>      
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
            $sql = "SELECT s.Fecha
                    FROM saldo_cabina as s
                    INNER JOIN cabina as c ON c.id = s.CABINA_Id
                    WHERE s.Id IN($ids) 
                    GROUP BY s.Fecha     
                    ORDER BY s.Fecha DESC, c.Nombre ASC;";
            
              return SaldoCabina::model()->findAllBySql($sql); 
         
        }
        
//        public static function get_Model_Ayer($date) 
//        {
//            $sql = "SELECT  b.fecha as Fecha,
//	           SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
//                   SUM((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
//                   SUM((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
//                   SUM((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
//                   SUM((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
//                   TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
//		   SUM(TRUNCATE((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as DifSoles,
//                   SUM(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
//                   SUM(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
//                   SUM(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
//                   SUM(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum
//
//                   FROM balance b
//                   INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
//		   WHERE b.fecha >= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-','01')
//                   AND b.fecha <= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-',DAY(CURDATE())-1)
//                   AND b.CABINA_Id NOT IN (18,19)
//                   group by b.fecha
//                   order by b.fecha desc;";
//            
//              return Balance::model()->findAllBySql($sql); 
//         
//        }
//        
//        public static function get_ModelComplete($ids) 
//        {
//            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
//                    TRUNCATE(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0),2) as Trafico, 
//                    TRUNCATE(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0),2) as RecargaMovistar,
//                    TRUNCATE(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0),2) as RecargaClaro,
//                    b.OtrosServicios as OtrosServicios,
//                   (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) as TotalVentas,  
//                    b.FechaDep as FechaDep,
//                    b.HoraDep as HoraDep,
//                    b.MontoDeposito as MontoDeposito,
//                    b.MontoBanco as MontoBanco, 
//                   (IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as DiferencialBancario,
//                   (IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)) as ConciliacionBancaria,
//                    b.RecargaVentasMov as RecargaVentasMovistar,
//                   (IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))) as DifMov,
//                    b.RecargaVentasClaro as RecargaVentasClaro, 
//                   (IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))) as DifClaro,
//                    b.TraficoCapturaDollar as TraficoCapturaDollar,
//		    TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
//		    TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2) as CaptSoles,
//		    TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2) as DifSoles,
//                    TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2) as DifDollar,
//                   TRUNCATE(IFNULL(b.Acumulado,0),2) AS Acumulado,
//                   TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2) AS Sobrante,
//                   TRUNCATE(IFNULL(b.SobranteAcum,0),2) AS SobranteAcum
//                    FROM balance b
//                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
//                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
//                    WHERE b.id IN ($ids) 
//                    order by b.fecha desc, c.nombre asc;";
//            
//              return Balance::model()->findAllBySql($sql); 
//         
//        }
//        
//        public static function get_ModelTotal($ids) 
//        {
//            $sql = "SELECT b.id as id,b.fecha as Fecha,
//                    SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
//                   SUM((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
//                   SUM((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
//                   SUM((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
//                   SUM((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
//                   TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
//		   SUM(TRUNCATE((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as DifSoles,
//                   SUM(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
//                   SUM(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
//                   SUM(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
//                   SUM(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum
//
//
//                    FROM balance as b
//                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
//		    WHERE b.fecha In ($ids)
//                    order by b.fecha desc;";
//            
//              return Balance::model()->findBySql($sql); 
//         
//        }
//        
//        public static function get_ModelTotal_Ayer($ids) 
//        {
//            $sql = "SELECT b.fecha as Fecha,
//                    SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
//                   SUM((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
//                   SUM((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
//                   SUM((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
//                   SUM((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
//                   TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
//		   SUM(TRUNCATE((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as DifSoles,
//                   SUM(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
//                   SUM(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
//                   SUM(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
//                   SUM(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum
//
//
//                    FROM balance as b
//                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
//                    WHERE b.fecha >= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-','01')
//                    AND b.fecha <= CONCAT(YEAR(CURDATE()),'-0',MONTH(CURDATE()),'-',DAY(CURDATE())-1)
//                    AND b.CABINA_Id NOT IN (18,19)
//                    ORDER BY b.fecha DESC;";
//            
//              return Balance::model()->findBySql($sql); 
//         
//        }
//        
//        public static function get_ModelTotalComplete($ids) 
//        {
//            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
//                    sum(TRUNCATE(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0),2)) as Trafico, 
//                    sum(TRUNCATE(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0),2)) as RecargaMovistar,
//                    sum(TRUNCATE(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0),2)) as RecargaClaro,
//                    sum(b.OtrosServicios) as OtrosServicios,
//                   sum((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
//                   
//                    b.FechaDep as FechaDep,
//                    b.HoraDep as HoraDep,
//                   
//                    sum(b.MontoDeposito) as MontoDeposito,
//                    sum(b.MontoBanco) as MontoBanco, 
//                   sum((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
//                   sum((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
//                   
//                   sum( b.RecargaVentasMov) as RecargaVentasMov,
//                   sum((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
//                   sum( b.RecargaVentasClaro) as RecargaVentasClaro, 
//                   sum((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
//                    
//                    sum(b.TraficoCapturaDollar) as TraficoCapturaDollar,
//					TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
//					sum(TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as CaptSoles,
//					sum(TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2)) as DifSoles,
//                    sum(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
//
//                   sum(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
//                   sum(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
//                   sum(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum
//                    FROM balance b
//                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
//                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
//                    WHERE b.id IN ($ids)";
//            
//              return Balance::model()->findBySql($sql); 
//         
//        }
    }
    ?>