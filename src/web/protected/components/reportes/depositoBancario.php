 <?php

    /**
     * @package reportes
     */
    class depositoBancario extends Reportes 
    {
        public static function reporte($ids,$type) 
        {
//            $acumuladoSaldoApMov = 0;
//            $acumuladoSaldoApClaro = 0;
//            $acumuladoTrafico = 0;
//            $acumuladoRecargasMov = 0;
//            $acumuladoRecargasClaro = 0;
//            $acumuladoDepositos = 0;
            
            $balance = depositoBancario::get_Model($ids);
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("depositos")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->TotalVentas), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MontoDeposito), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->NumRefDeposito).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MontoBanco), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DiferencialBancario,$registro->DiferencialBancario), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->ConciliacionBancaria,$registro->ConciliacionBancaria), $type).'</td>    
                                    
                                </tr>
                                ';

                }
                
                 $balanceTotals = depositoBancario::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("depositos")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($balanceTotals->TotalVentas), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->MontoDeposito), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalOtrosServicios">'.Reportes::format(Reportes::defineTotals($balanceTotals->MontoBanco), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($balanceTotals->DiferencialBancario,$balanceTotals->DiferencialBancario), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($balanceTotals->ConciliacionBancaria,$balanceTotals->ConciliacionBancaria), $type).'</td>     
                                      </tr>
                                    </tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            return $table;
        }
            
         
        public static function get_Model($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                   (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) as TotalVentas,  
                    b.MontoDeposito as MontoDeposito,
                    b.NumRefDeposito as NumRefDeposito, 
                    b.MontoBanco as MontoBanco, 
                    (IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as DiferencialBancario,
                    (IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)) as ConciliacionBancaria
                    FROM balance as b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                    sum((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))) as TotalVentas,  
                    sum(b.MontoDeposito) as MontoDeposito,
                    sum(b.NumRefDeposito) as NumRefDeposito, 
                    sum(b.MontoBanco) as MontoBanco, 
                    sum((IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)))) as DiferencialBancario,
                    sum((IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0))) as ConciliacionBancaria
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>