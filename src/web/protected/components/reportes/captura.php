<?php

    class captura extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {
//            $acumuladoSaldoApMov = 0;
//            $acumuladoSaldoApClaro = 0;
//            $acumuladoTrafico = 0;
//            $acumuladoRecargasMov = 0;
//            $acumuladoRecargasClaro = 0;
//            $acumuladoDepositos = 0;
            
            $balance = captura::get_Model($ids);
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("captura")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->MinutosCaptura), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->TraficoCapturaDollar), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($registro->Paridad).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->CaptSoles), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DifSoles,$registro->DifSoles), $type).'</td>   
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($registro->DifDollar,$registro->DifDollar), $type).'</td>       
                                </tr>
                                ';

                }
                
                 $balanceTotals = captura::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("captura")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$balanceTotals->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin1">'.Reportes::format(Reportes::defineTotals($balanceTotals->MinutosCaptura), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals($balanceTotals->TraficoCapturaDollar), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->CaptSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->DifSoles,$balanceTotals->DifSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($balanceTotals->DifDollar,$balanceTotals->DifDollar), $type).'</td>      
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
		    b.MinutosCaptura as MinutosCaptura,
		    b.TraficoCapturaDollar as TraficoCapturaDollar,
		    TRUNCATE(IFNULL(p.Valor,0),2) AS Paridad,
		    TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2) as CaptSoles,
		    TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2) as DifSoles,
                    TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2) as DifDollar
                    FROM balance as b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
		    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids) 
                    order by b.fecha desc, c.nombre asc;";
            
              return Balance::model()->findAllBySql($sql); 
         
        }
        
        public static function get_ModelTotal($ids) 
        {
            $sql = "SELECT b.id as id, b.fecha as Fecha, c.nombre as cabina, 
		    sum(b.MinutosCaptura) as MinutosCaptura,
		    sum(b.TraficoCapturaDollar) as TraficoCapturaDollar,
		    sum(p.Valor) as Valor,
		   sum(TRUNCATE((IFNULL(b.TraficoCapturaDollar,0)*p.Valor),2)) as CaptSoles,
		   sum(TRUNCATE(((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor)),2)) as DifSoles,
                   sum(TRUNCATE((((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*p.Valor))/p.Valor),2)) as DifDollar
                    FROM balance as b
                    INNER JOIN cabina as c ON c.id = b.CABINA_Id
		    INNER JOIN paridad as p ON p.id = b.PARIDAD_Id
                    WHERE b.id IN ($ids) ";
            
              return Balance::model()->findBySql($sql); 
         
        }
    }
    ?>