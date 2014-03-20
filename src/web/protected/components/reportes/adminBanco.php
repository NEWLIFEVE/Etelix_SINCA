 <?php

    /**
     * @package reportes
     */
    class adminBanco extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {

            $adminBanco = adminBanco::get_Model($ids);
            if($adminBanco != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items' width='100%'>".
                        Reportes::defineHeader("adminBanco")
                        .'<tbody>';
                foreach ($adminBanco as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Nombre.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->SaldoApBanco, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Balance::sumMontoBanco($registro->Fecha,$registro->CUENTA_Id), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Detallegasto::sumGastosBanco($registro->Fecha,$registro->CUENTA_Id), $type).'</td>  
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(($registro->SaldoApBanco+Balance::sumMontoBanco($registro->Fecha,$registro->CUENTA_Id)-Detallegasto::sumGastosBanco($registro->Fecha,$registro->CUENTA_Id)), $type).'</td>  
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->SaldoCierreBanco, $type).'</td>    

                                </tr>
                                ';

                }

                 $table.=  '</tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            return $table;
        }
            
         
        public static function get_Model($ids) 
        {
            $sql = "SELECT b.Id, b.Fecha, b.SaldoApBanco, IFNULL(b.SaldoCierreBanco,0) as SaldoCierreBanco, b.CUENTA_Id, c.Nombre 
                    FROM banco as b
                    INNER JOIN cuenta as c ON c.Id = b.CUENTA_Id
                    WHERE b.Id IN ($ids) 
                    ORDER BY b.Fecha DESC;";
            
              return Banco::model()->findAllBySql($sql); 
         
        }
        
    }
    ?>