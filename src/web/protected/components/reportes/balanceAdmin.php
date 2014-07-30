 <?php

    /**
     * @package reportes
     */
    class balanceAdmin extends Reportes 
    {
        public static function reporte($fecha,$cabina,$name,$type) 
        {
            $fechas = explode(",", $fecha);
            $cabinas = explode(",", $cabina);
            
            $traficoTotal = 0;
            $recargaMovTotal = 0;
            $recargaClaroTotal = 0;
            $servDirecTvTotal = 0;
            $servNextelTotal = 0;
            $saldoApertura = 0;
            $montoDeposito = 0;
            
            $balance = balanceAdmin::get_Model($fechas,$cabinas);
            if($balance != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("balance")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$fechas[$key].'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Cabina::getNombreCabina($cabinas[$key]).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->SaldoAp), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->Trafico), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->ServMov), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->ServClaro), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->ServDirecTv), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->ServNextel), $type).'</td>    
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto2($registro->MontoDeposito), $type).'</td>
                                </tr>
                                ';
                    
                    $traficoTotal = $traficoTotal +$registro->Trafico;
                    $recargaMovTotal = $recargaMovTotal + $registro->ServMov;
                    $recargaClaroTotal = $recargaClaroTotal + $registro->ServClaro;
                    $servDirecTvTotal = $servDirecTvTotal + $registro->ServDirecTv;
                    $servNextelTotal = $servNextelTotal + $registro->ServNextel;        
                    $saldoApertura = $saldoApertura + $registro->SaldoAp;
                    $montoDeposito = $montoDeposito + $registro->MontoDeposito;

                }
                
                 //$balanceTotals = balanceAdmin::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("balance")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.end($fechas).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals2($saldoApertura), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals2($traficoTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals2($recargaMovTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals2($recargaClaroTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaClaro">'.Reportes::format(Reportes::defineTotals2($servDirecTvTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals2($servNextelTotal), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalMontoDeposito">'.Reportes::format(Reportes::defineTotals2($montoDeposito), $type).'</td>    
                                      </tr>
                                    </tbody>
                           </table>';
            }else{
                $table='Hubo un error';
            }
            return $table;
        }
            
         
        public static function get_Model($fechas,$cabinas)
    {
        $model = Array();
        
        for($i=0;$i<count($fechas);$i++){
            $sql="SELECT

                 (SELECT SUM(SaldoAp) 
                 FROM saldo_cabina 
                 WHERE Fecha = '$fechas[$i]' 
                 AND CABINA_Id = $cabinas[$i]) as SaldoAp,
                  
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 5 AND t.Clase = 1) as Trafico,

                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 1 AND t.Clase = 1) as ServMov,

                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 2 AND t.Clase = 1) as ServClaro,
                  
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 3 AND t.Clase = 1) as ServNextel,
                  
                 (SELECT SUM(d.Monto) 
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes = '$fechas[$i]' 
                  AND d.CABINA_Id = $cabinas[$i] 
                  AND t.COMPANIA_Id = 4 AND t.Clase) as ServDirecTv,

                 (SELECT SUM(MontoDep) as MontoDep
                  FROM deposito 
                  WHERE FechaCorrespondiente = '$fechas[$i]' 
                  AND CABINA_Id = $cabinas[$i]) as MontoDeposito";
            
            $model[$i] = Detalleingreso::model()->findBySql($sql);
        }
        
        return $model;
        
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