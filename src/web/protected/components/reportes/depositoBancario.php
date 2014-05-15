 <?php

    /**
     * @package reportes
     */
    class depositoBancario extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {
            $ventasTotal = 0;
            $montoDepTotal = 0;
            $montoBancoTotal = 0;
            $diferencialTotal = 0;
            $consiliacionTotal = 0;
            
            $balance = depositoBancario::get_Model($ids);
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("depositos")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $diferencial = Deposito::valueNull(round(($registro->MontoBanco-Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $registro->FechaCorrespondiente, $registro->CABINA_Id)),2));
                    $consiliacion = Deposito::valueNull(round(($registro->MontoBanco-$registro->MontoDep),2));
                    $totalVentas = Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $registro->FechaCorrespondiente, $registro->CABINA_Id);
                    
                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaCorrespondiente.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($totalVentas), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MontoDep), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->NumRef).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MontoBanco), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($diferencial,$diferencial), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($consiliacion,$consiliacion), $type).'</td>    
                                    
                                </tr>
                                ';
                    $ventasTotal = $ventasTotal + $totalVentas;
                    $montoDepTotal = $montoDepTotal + $registro->MontoDep;
                    $montoBancoTotal = $montoBancoTotal + $registro->MontoBanco;
                    $diferencialTotal = $diferencialTotal + $diferencial;
                    $consiliacionTotal = $consiliacionTotal + $consiliacion;        

                }
                
                 $balanceTotals = depositoBancario::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("depositos")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$registro->FechaCorrespondiente.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($ventasTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($montoDepTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalOtrosServicios">'.Reportes::format(Reportes::defineTotals($montoBancoTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($diferencialTotal,$diferencialTotal), $type).'</td> 
                                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($consiliacionTotal,$consiliacionTotal), $type).'</td>     
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
            $sql = "SELECT d.id, d.Fecha, d.FechaCorrespondiente, d.Hora, d.MontoDep, d.MontoBanco, 
                    d.NumRef, d.Depositante, d.CUENTA_Id, d.CABINA_Id, c.Nombre as Cabina
                    FROM deposito as d
                    INNER JOIN cabina as c ON c.id = d.CABINA_Id
                    WHERE d.id IN ($ids) 
                    order by d.FechaCorrespondiente desc, c.nombre asc;";
            
              return Deposito::model()->findAllBySql($sql); 
         
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