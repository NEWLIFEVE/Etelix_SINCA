 <?php

    /**
     * @package reportes
     */
    class cicloIngresoTotal extends Reportes 
    {
        public static function reporte($ids,$complete) 
        {

            if($complete==false){
                
            $balance = cicloIngresoTotal::get_Model($ids);
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("cicloI")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>Todas</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin1">'.Reportes::defineMonto($registro->TotalVentas).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="vistaAdmin2">'.Reportes::defineMonto($registro->DiferencialBancario,$registro->DiferencialBancario).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalTrafico">'.Reportes::defineMonto($registro->ConciliacionBancaria,$registro->ConciliacionBancaria).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaMov">'.Reportes::defineMonto($registro->DifMov,$registro->DifMov).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalRecargaClaro">'.Reportes::defineMonto($registro->DifClaro,$registro->DifClaro).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->Paridad).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->DifSoles,$registro->DifSoles).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->DifDollar,$registro->DifDollar).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->Acumulado,$registro->Acumulado).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->Sobrante,$registro->Sobrante).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' id="totalMontoDeposito">'.Reportes::defineMonto($registro->SobranteAcum,$registro->SobranteAcum).'</td>    
                                </tr>
                                ';

                }
                
                 //$balanceTotals = cicloIngresoTotal::get_ModelTotal($ids);
                 //$table.=  Reportes::defineHeader("cicloI")
//                                .'<tr style="display:none;">
//                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::defineTotals($balanceTotals->TotalVentas).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::defineTotals($balanceTotals->DiferencialBancario,$balanceTotals->DiferencialBancario).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::defineTotals($balanceTotals->ConciliacionBancaria,$balanceTotals->ConciliacionBancaria).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::defineTotals($balanceTotals->DifMov,$balanceTotals->DifMov).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::defineTotals($balanceTotals->DifClaro,$balanceTotals->DifClaro).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">N/A</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::defineTotals($balanceTotals->DifSoles,$balanceTotals->DifSoles).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::defineTotals($balanceTotals->DifDollar,$balanceTotals->DifDollar).'</td> 
//                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::defineTotals($balanceTotals->Acumulado,$balanceTotals->Acumulado).'</td> 
//                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::defineTotals($balanceTotals->Sobrante,$balanceTotals->Sobrante).'</td>
//                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::defineTotals($balanceTotals->SobranteAcum,$balanceTotals->SobranteAcum).'</td>   
//                                      </tr>
                                      $table.=   '</tbody>
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
                                        
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->Trafico).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->RecargaMovistar).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->RecargaClaro).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->OtrosServicios).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->TotalVentas).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->FechaDep).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->HoraDep).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->MontoDeposito).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->MontoBanco).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->DiferencialBancario,$registro->DiferencialBancario).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->ConciliacionBancaria,$registro->ConciliacionBancaria).'</td>
                                            
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->RecargaVentasMov).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->DifMov,$registro->DifMov).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->RecargaVentasClaro).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->DifClaro,$registro->DifClaro).'</td>

                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->TraficoCapturaDollar).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->Paridad).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->CaptSoles).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->DifSoles,$registro->DifSoles).'</td>   
                                        <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->DifDollar,$registro->DifDollar).'</td>      

                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::defineMonto($registro->Acumulado,$registro->Acumulado).'</td> 
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::defineMonto($registro->Sobrante,$registro->Sobrante).'</td>
                                        <td '.Reportes::defineStyleTd($key+2).' >'.Reportes::defineMonto($registro->SobranteAcum,$registro->SobranteAcum).'</td>    
                                </tr>
                                ';

                }
                
                 $balanceTotals = cicloIngreso::get_ModelTotalComplete($ids);
                 $table.=  Reportes::defineHeader("cicloIC")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->Trafico).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->RecargaMovistar).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->RecargaClaro).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->OtrosServicios).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->TotalVentas).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->MontoDeposito).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->MontoBanco).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->DiferencialBancario,$registro->DiferencialBancario).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->ConciliacionBancaria,$registro->ConciliacionBancaria).'</td>
                                            
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->RecargaVentasMov).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->DifMov,$registro->DifMov).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->RecargaVentasClaro).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->DifClaro,$registro->DifClaro).'</td>

                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->TraficoCapturaDollar).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>N/A</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->CaptSoles).'</td>
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->DifSoles,$registro->DifSoles).'</td>   
                                        <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineTotals($balanceTotals->DifDollar,$registro->DifDollar).'</td>      

                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::defineMonto($balanceTotals->Acumulado,$registro->Acumulado).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::defineMonto($balanceTotals->Sobrante,$registro->Sobrante).'</td>
                                        <td '.Reportes::defineStyleTd(2).' >'.Reportes::defineMonto($balanceTotals->SobranteAcum,$registro->SobranteAcum).'</td>      
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
            $sql = "SELECT b.id as id, b.fecha as Fecha,
	           SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
                   SUM((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                   SUM((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
                   SUM((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                   SUM((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
                   TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
		   SUM(TRUNCATE((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as DifSoles,
                   SUM(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
                   SUM(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
                   SUM(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
                   SUM(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum

                   FROM balance b
                   INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
		   WHERE b.fecha In ($ids)
	           group by b.fecha
                   order by b.fecha desc;";
            
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
            $sql = "SELECT b.id as id, b.fecha as Fecha,
                    SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
                   SUM((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                   SUM((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria,
                   SUM((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                   SUM((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro,
                   TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
		   SUM(TRUNCATE((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as DifSoles,
                   SUM(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar,
                   SUM(TRUNCATE(IFNULL(b.Acumulado,0),2)) AS Acumulado,
                   SUM(TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2)) AS Sobrante,
                   SUM(TRUNCATE(IFNULL(b.SobranteAcum,0),2)) AS SobranteAcum


                    FROM balance as b
                    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.fecha IN ($ids)";
            
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