 <?php

    /**
     * @package reportes
     */
    class balanceAdmin extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {
//            $acumuladoSaldoApMov = 0;
//            $acumuladoSaldoApClaro = 0;
//            $acumuladoTrafico = 0;
//            $acumuladoRecargasMov = 0;
//            $acumuladoRecargasClaro = 0;
//            $acumuladoDepositos = 0;
            
            $balance = balanceAdmin::get_Model($ids);
            if($balance != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("balance")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->SaldoApMov), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->SaldoApClaro), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->Trafico), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->RecargaMovistar), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->RecargaClaro), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->MontoDeposito), $type).'</td>
                                </tr>
                                ';

                }
                
                 $balanceTotals = balanceAdmin::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("balance")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals2($balanceTotals->SaldoApMov), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals2($balanceTotals->SaldoApClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals2($balanceTotals->Trafico), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals2($balanceTotals->RecargaMovistar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals2($balanceTotals->RecargaClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals2($balanceTotals->MontoDeposito), $type).'</td>
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
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, b.SaldoApMov as SaldoApMov, b.SaldoApClaro as SaldoApClaro, 
                    (b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI) as Trafico, 
                    (b.RecargaCelularMov+b.RecargaFonoYaMov) as RecargaMovistar,
                    (b.RecargaCelularClaro+b.RecargaFonoClaro) as RecargaClaro,
                    b.MontoDeposito as MontoDeposito   
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina,
                    IF(sum(b.SaldoApMov)<0, -1 , sum(IF(b.SaldoApMov<0,0,b.SaldoApMov))) as SaldoApMov, 
                    IF(sum(b.SaldoApClaro)<0, -1 , sum(IF(b.SaldoApClaro<0,0,b.SaldoApClaro))) as SaldoApClaro, 
                    sum((b.FijoLocal+b.FijoProvincia+b.FijoLima+b.Rural+b.Celular+b.LDI)) as Trafico, 
                    sum((b.RecargaCelularMov+b.RecargaFonoYaMov)) as RecargaMovistar,
                    sum((b.RecargaCelularClaro+b.RecargaFonoClaro)) as RecargaClaro,
                    sum(b.MontoDeposito) as MontoDeposito   
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids)";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>