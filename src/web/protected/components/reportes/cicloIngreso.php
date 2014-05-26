 <?php

    /**
     * @package reportes
     */
    class cicloIngreso extends Reportes 
    {
        public static function reporte($ids=null,$name,$complete,$type,$report=false) 
        {

            if($complete==false){
            
            if($report == null)    
                $balance = cicloIngreso::get_Model($ids);
            else
                $balance = cicloIngreso::get_Model_Ayer($report);
            
            $acumulado_total = 0;
            $sobranteacumulado_total = 0;
            
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("cicloI")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineMonto(round($registro->TotalVentas,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineMonto(round($registro->DiferencialBancario,2),round($registro->DiferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalTrafico">'.Reportes::format(Reportes::defineMonto(round($registro->ConciliacionBancaria,2),round($registro->ConciliacionBancaria,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineMonto(round($registro->DifMov,2),$registro->DifMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineMonto(round($registro->DifClaro,2),$registro->DifClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto(round($registro->Paridad,2)).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($registro->DifSoles,2),round($registro->DifSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($registro->DifDollar,2),round($registro->DifDollar,2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2),round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round($registro->Sobrante,2),round($registro->Sobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineMonto(round(Balance::SobranteAcumulado($registro->Fecha,$registro->CABINA_Id,false),2),round(Balance::SobranteAcumulado($registro->Fecha,$registro->CABINA_Id,false),2)), $type).'</td>    
                                </tr>
                                ';
                    $acumulado_total = $acumulado_total + round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2);
                    $sobranteacumulado_total = $sobranteacumulado_total + round(Balance::SobranteAcumulado($registro->Fecha,$registro->CABINA_Id,false),2);

                }
                
                if($report == null)    
                    $balanceTotals = cicloIngreso::get_ModelTotal($ids);
                else
                    $balanceTotals = cicloIngreso::get_Model_Ayer_Total($report);
                 
                 $table.=  Reportes::defineHeader("cicloI")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->TotalVentas,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DiferencialBancario,2),round($balanceTotals->DiferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->ConciliacionBancaria,2),round($balanceTotals->ConciliacionBancaria,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifMov,2),round($balanceTotals->DifMov,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifClaro,2),round($balanceTotals->DifClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifSoles,2),round($balanceTotals->DifSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifDollar,2),round($balanceTotals->DifDollar,2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($acumulado_total,$acumulado_total), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals(round($balanceTotals->Sobrante,2),round($balanceTotals->Sobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals($sobranteacumulado_total,$sobranteacumulado_total), $type).'</td>   
                                      </tr>
                                    </tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            
        }else{
            $acumulado_total = 0;
            $sobranteacumulado_total = 0;
            $balance = cicloIngreso::get_ModelComplete($ids);
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("cicloIC")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                        
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->Trafico,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->RecargaMovistar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->RecargaClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->OtrosServicios,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->TotalVentas,2)), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaDep.'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.$registro->HoraDep.'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->MontoDeposito,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->MontoBanco,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->DiferencialBancario,2),round($registro->DiferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->ConciliacionBancaria,2),round($registro->ConciliacionBancaria,2)), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->RecargaVentasMov,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->DifMov,2),round($registro->DifMov,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->RecargaVentasClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->DifClaro,2),round($registro->DifClaro,2)), $type).'</td>

                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->TraficoCapturaDollar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto(round($registro->Paridad,2)).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->CaptSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->DifSoles,2),round($registro->DifSoles,2)), $type).'</td>   
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto(round($registro->DifDollar,2),round($registro->DifDollar,2)), $type).'</td>      

                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2),round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2)), $type).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round($registro->Sobrante,2),round($registro->Sobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::format(Reportes::defineMonto(round(Balance::SobranteAcumulado($registro->Fecha,$registro->CABINA_Id,false),2),round(Balance::SobranteAcumulado($registro->Fecha,$registro->CABINA_Id,false),2)), $type).'</td>    
                                </tr>
                                ';
                    
                    $acumulado_total = $acumulado_total + round(Balance::Acumulado($registro->Fecha,$registro->CABINA_Id,false),2);
                    $sobranteacumulado_total = $sobranteacumulado_total + round(Balance::SobranteAcumulado($registro->Fecha,$registro->CABINA_Id,false),2);
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
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->MontoDeposito,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->MontoBanco,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DiferencialBancario,2),round($balanceTotals->DiferencialBancario,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->ConciliacionBancaria,2),round($balanceTotals->ConciliacionBancaria,2)), $type).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->RecargaVentasMov,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifMov,2),round($balanceTotals->DifMov,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->RecargaVentasClaro,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifClaro,2),round($balanceTotals->DifClaro,2)), $type).'</td>

                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->TraficoCapturaDollar,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->CaptSoles,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifSoles,2),round($balanceTotals->DifSoles,2)), $type).'</td>   
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineTotals(round($balanceTotals->DifDollar,2),round($balanceTotals->DifDollar,2)), $type).'</td>      

                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($acumulado_total,$acumulado_total), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals(round($balanceTotals->Sobrante,2),round($balanceTotals->Sobrante,2)), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::format(Reportes::defineTotals($sobranteacumulado_total,$sobranteacumulado_total), $type).'</td>      
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
                   WHERE b.id IN ($ids) 
                   order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
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