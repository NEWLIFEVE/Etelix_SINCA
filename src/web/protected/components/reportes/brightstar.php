<?php

    class brightstar extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {
            $acumuladoDifMovistar = 0;
            $acumuladoDifClaro= 0;
            $acumuladoDifDirectv = 0;
            $acumuladoDifNextel = 0;
            
            $balance = brightstar::get_Model($ids);
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("brightstar")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {
                    
                    $DifMov = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 1);
                    $DifClaro = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 2);
                    $DifDirectv = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 4);
                    $DifNextel = CicloIngresoModelo::getDifFullCarga($registro->Fecha, $registro->CABINA_Id, 3);

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($DifMov,$DifMov), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($DifClaro,$DifClaro), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($DifDirectv,$DifDirectv), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($DifNextel,$DifNextel), $type).'</td>
                                </tr>
                                ';
                    
                    $acumuladoDifMovistar = $acumuladoDifMovistar + $DifMov;
                    $acumuladoDifClaro= $acumuladoDifClaro + $DifClaro;
                    $acumuladoDifDirectv = $acumuladoDifDirectv + $DifDirectv;
                    $acumuladoDifNextel = $acumuladoDifNextel + $DifNextel;
                    
                    

                }
                
//                 $balanceTotals = brightstar::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("brightstar")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$registro->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals($acumuladoDifMovistar,$acumuladoDifMovistar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals($acumuladoDifClaro,$acumuladoDifClaro), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">'.Reportes::format(Reportes::defineTotals($acumuladoDifDirectv,$acumuladoDifDirectv), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($acumuladoDifNextel,$acumuladoDifNextel), $type).'</td>
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
            $sql = "SELECT s.Id, s.Fecha, s.CABINA_Id, c.Nombre as Cabina
                    FROM saldo_cabina as s
                    INNER JOIN cabina as c ON c.id = s.CABINA_Id
                    WHERE s.Id IN ($ids) 
                    order by s.Fecha DESC, c.Nombre ASC;";
            
              return SaldoCabina::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina,
                    sum(b.RecargaVentasMov) as RecargaMovistar,
                    sum((IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)))) as DifMov,
                    sum(b.RecargaVentasClaro) as RecargaClaro, 
                    sum((IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)))) as DifClaro
                    FROM balance b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
                    WHERE b.id IN ($ids) ";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>