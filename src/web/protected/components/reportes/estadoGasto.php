 <?php

    /**
     * @package reportes
     */
    class estadoGasto extends Reportes 
    {
        public static function reporte($ids,$type) 
        {
//            $acumuladoSaldoApMov = 0;
//            $acumuladoSaldoApClaro = 0;
//            $acumuladoTrafico = 0;
//            $acumuladoRecargasMov = 0;
//            $acumuladoRecargasClaro = 0;
//            $acumuladoDepositos = 0;
            
            $balance = estadoGasto::get_Model($ids);
            if($balance != NULL){
                
                $table = '<table class="items">'.
                        Reportes::defineHeader("estadoGasto")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Utility::monthName($registro->FechaMes).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Tipogasto, ENT_QUOTES,'UTF-8').'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Descripcion, ENT_QUOTES,'UTF-8').'</td>    
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaVenc.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->Monto, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->moneda.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->beneficiario, ENT_QUOTES,'UTF-8').'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->status.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::definePago($registro->TransferenciaPago,$registro->status).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::definePago($registro->FechaTransf,$registro->status).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::definePago($registro->Cuenta,$registro->status).'</td>
                                </tr>
                                ';

                }
                
                 $balanceTotals = estadoGasto::get_ModelTotal($ids);
                        $table.=  '<thead>
                                   <tr >
                                       <th '.self::defineStyleHeader("brightstar").' id="Fechas">Total Monto</th>
                                       <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c2">Soles</th>
                                       <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Dolares</th>  
                                   </tr>
                                        <tr >
                                            <td '.Reportes::defineStyleTd(2).'>------</td>
                                            <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineMonto($balanceTotals->Cuenta).'</td>
                                            <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineMonto($balanceTotals->Cabina).'</td>  
                                       </tr>
                                   </thead>
                                    </tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            return $table;
        }
            
         
        public static function get_Model($ids) 
        {
            $sql = "SELECT d.id as id, t.nombre as Tipogasto, d.FechaMes as FechaMes, d.FechaVenc as FechaVenc, d.Descripcion as Descripcion,
                    case d.status when 1 then 'Orden de Pago' when 2 then 'Aprovada' when 3 then 'Pagada' end as status,
                    d.Monto as Monto, case d.moneda when 1 then 'USD$' when 2 then 'S/.' end as moneda,
                    d.beneficiario as beneficiario, d.TransferenciaPago as TransferenciaPago, 
                    d.FechaTransf as FechaTransf, c.nombre as Cabina, cu.Nombre as Cuenta
                      
                    FROM detallegasto as d
                    INNER JOIN cabina as c ON c.id = d.CABINA_Id
                    INNER JOIN tipogasto as t ON t.id = d.TIPOGASTO_Id
                    INNER JOIN cuenta as cu ON cu.id = d.CUENTA_Id
                    WHERE d.id IN ($ids) 
                    order by d.id asc, d.status asc;";
            
              return Detallegasto::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT (SELECT sum(d.monto) FROM detallegasto as d WHERE d.id IN ($ids) AND d.moneda = 1)  AS Cabina, 
                           (SELECT sum(d.monto) FROM detallegasto as d WHERE d.id IN ($ids) AND d.moneda = 2)  AS Cuenta
                    FROM detallegasto as d
                    LIMIT 1";
            
              return Detallegasto::model()->findBySql($sql); 
         
        }
    }
    ?>