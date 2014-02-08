 <?php

    /**
     * @package reportes
     */
    class balanceAdmin extends Reportes 
    {
        public static function reporte($ids) 
        {
            $acumuladoSaldoApMov = 0;
            $acumuladoSaldoApClaro = 0;
            $acumuladoTrafico = 0;
            $acumuladoRecargasMov = 0;
            $acumuladoRecargasClaro = 0;
            $acumuladoDepositos = 0;
            
            $balance = balanceAdmin::get_Model($ids);
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("balance")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr '.Reportes::defineStyleTr("odd").'>
                                    <td style = "text-align: center;">'.$registro->Fecha.'</td>
                                    <td style = "text-align: center;">'.$registro->cabina.'</td>
                                    <td style = "text-align: center;">'.$registro->SaldoApMov.'</td>
                                    <td style = "text-align: center;">'.$registro->SaldoApClaro.'</td>
                                    <td style = "text-align: center;">'.$registro->Trafico.'</td>
                                    <td style = "text-align: center;">'.$registro->RecargaMovistar.'</td>
                                    <td style = "text-align: center;">'.$registro->RecargaClaro.'</td>
                                    <td style = "text-align: center;">'.$registro->MontoDeposito.'</td>
                                </tr>
                                ';

                }
                 $table.=  Reportes::defineHeader("balance")
                                .'<tr class="odd" style="background-color: rgb(234, 248, 225); text-align: center; background-position: initial initial; background-repeat: initial initial;">
                                        <td id="totalFecha">Septiembre</td>
                                        <td id="todas">Todas</td>
                                        <td id="vistaAdmin1">29186</td>
                                        <td id="vistaAdmin2">9155</td>
                                        <td id="totalTrafico">35110</td>
                                        <td id="totalRecargaMov">215856</td>
                                        <td id="totalRecargaClaro">7169</td>
                                        <td id="totalMontoDeposito">1340</td>
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
                    order by b.fecha desc;
                    ";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
    }
    ?>