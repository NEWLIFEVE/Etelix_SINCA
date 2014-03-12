 <?php

    /**
     * @package reportes
     */
    class cicloIngreso extends Reportes 
    {
        public static function reporte($ids,$complete,$type) 
        {

            if($complete==false){
                
            $balance = cicloIngreso::get_Model($ids);
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("cicloI")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineMonto($registro->TotalVentas), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineMonto($registro->DiferencialBancario,$registro->DiferencialBancario), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalTrafico">'.Reportes::format(Reportes::defineMonto($registro->ConciliacionBancaria,$registro->ConciliacionBancaria), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineMonto($registro->DifMov,$registro->DifMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineMonto($registro->DifClaro,$registro->DifClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->Paridad).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto($registro->DifSoles,$registro->DifSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto($registro->DifDollar,$registro->DifDollar), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto($registro->Acumulado,$registro->Acumulado), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto($registro->Sobrante,$registro->Sobrante), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto($registro->SobranteAcum,$registro->SobranteAcum), $type).'</td>    
                                </tr>
                                ';

                }
                
                 $balanceTotals = cicloIngreso::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("cicloI")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals($balanceTotals->TotalVentas), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals($balanceTotals->DiferencialBancario,$balanceTotals->DiferencialBancario), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($balanceTotals->ConciliacionBancaria,$balanceTotals->ConciliacionBancaria), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->DifMov,$balanceTotals->DifMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($balanceTotals->DifClaro,$balanceTotals->DifClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($balanceTotals->DifSoles,$balanceTotals->DifSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($balanceTotals->DifDollar,$balanceTotals->DifDollar), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($balanceTotals->Acumulado,$balanceTotals->Acumulado), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($balanceTotals->Sobrante,$balanceTotals->Sobrante), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($balanceTotals->SobranteAcum,$balanceTotals->SobranteAcum), $type).'</td>   
                                      </tr>
                                    </tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            
        }else{
            
            $balance = cicloIngreso::get_ModelComplete($ids);
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

                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto($registro->Acumulado,$registro->Acumulado), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto($registro->Sobrante,$registro->Sobrante), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto($registro->SobranteAcum,$registro->SobranteAcum), $type).'</td>    
                                </tr>
                                ';

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
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DiferencialBancario,$balanceTotals->DiferencialBancario), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->ConciliacionBancaria,$balanceTotals->ConciliacionBancaria), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaVentasMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifMov,$balanceTotals->DifMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaVentasClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifClaro,$balanceTotals->DifClaro), $type).'</td>

                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->TraficoCapturaDollar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->CaptSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifSoles,$balanceTotals->DifSoles), $type).'</td>   
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals($balanceTotals->DifDollar,$balanceTotals->DifDollar), $type).'</td>      

                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($balanceTotals->Acumulado,$balanceTotals->Acumulado), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($balanceTotals->Sobrante,$balanceTotals->Sobrante), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($balanceTotals->SobranteAcum,$balanceTotals->SobranteAcum), $type).'</td>      
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
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                   (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) as TotalVentas,  
                   (IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as DiferencialBancario,
                   (IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)) as ConciliacionBancaria,
                   (IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))) as DifMov,
                   (IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))) as DifClaro,
                   TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
		   TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2) as DifSoles,
                   TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2) as DifDollar,
                   TRUNCATE(IFNULL(b.Acumulado,0),2) AS Acumulado,
                   TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2) AS Sobrante,
                   TRUNCATE(IFNULL(b.SobranteAcum,0),2) AS SobranteAcum

                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelComplete($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
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
		    TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
		    TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2) as CaptSoles,
		    TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2) as DifSoles,
                    TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2) as DifDollar,
                   TRUNCATE(IFNULL(b.Acumulado,0),2) AS Acumulado,
                   TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2) AS Sobrante,
                   TRUNCATE(IFNULL(b.SobranteAcum,0),2) AS SobranteAcum
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                   sum((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,
                   sum((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                   sum((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
                   sum((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                   sum((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
                   sum(TRUNCATE(IFNULL(p.Valor,0),2)) AS Paridad,
		   sum(TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2)) as DifSoles,
                   sum(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
                   sum(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
                   sum(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
                   sum(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum

                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
        
        public static function get_ModelTotalComplete($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                    sum(TRUNCATE(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0),2)) as Trafico, 
                    sum(TRUNCATE(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0),2)) as RecargaMovistar,
                    sum(TRUNCATE(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0),2)) as RecargaClaro,
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
					sum(TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as CaptSoles,
					sum(TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2)) as DifSoles,
                    sum(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,

                   sum(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
                   sum(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
                   sum(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>