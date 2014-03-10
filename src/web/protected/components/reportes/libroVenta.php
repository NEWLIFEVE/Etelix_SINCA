 <?php

    /**
     * @package reportes
     */
    class libroVenta extends Reportes 
    {
        public static function reporte($ids,$type) 
        {
//            $acumuladoSaldoApMov = 0;
//            $acumuladoSaldoApClaro = 0;
//            $acumuladoTrafico = 0;
//            $acumuladoRecargasMov = 0;
//            $acumuladoRecargasClaro = 0;
//            $acumuladoDepositos = 0;
            
            $balance = libroVenta::get_Model($ids);
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("libroV")
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
                                </tr>
                                ';

                }
                
                 $balanceTotals = libroVenta::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("libroV")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($balanceTotals->Trafico), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaMovistar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals($balanceTotals->RecargaClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalOtrosServicios">'.Reportes::format(Reportes::defineTotals($balanceTotals->OtrosServicios), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTotalVentas">'.Reportes::format(Reportes::defineTotals($balanceTotals->TotalVentas), $type).'</td>    
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
                    (b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI) as Trafico, 
                    (b.RecargaCelularMov+b.RecargaFonoYaMov) as RecargaMovistar,
                    (b.RecargaCelularClaro+b.RecargaFonoClaro) as RecargaClaro,
                    b.OtrosServicios as OtrosServicios,  
                    (IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)) as TotalVentas  
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
                    sum((b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI)) as Trafico, 
                    sum((b.RecargaCelularMov+b.RecargaFonoYaMov)) as RecargaMovistar,
                    sum((b.RecargaCelularClaro+b.RecargaFonoClaro)) as RecargaClaro,
                    sum(b.OtrosServicios) as OtrosServicios,  
                    sum((b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI+b.RecargaCelularMov+b.RecargaFonoYaMov+b.RecargaCelularClaro+b.RecargaFonoClaro+b.OtrosServicios)) as TotalVentas  
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>