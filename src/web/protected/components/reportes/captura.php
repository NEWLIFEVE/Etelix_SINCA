<?php

    class captura extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {
            $acumuladoTraficoCaptura = 0;
            $acumuladoCapturaSoles = 0;
            $acumuladoDifCapturaSoles = 0;
            $acumuladoDifCapturaDollar = 0;
            
            $balance = captura::get_Model($ids);
            if($balance != NULL){
                
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("captura")
                        .'<tbody>';
                foreach ($balance as $key => $registro) {
                    
                    $traficoCarptura = Detalleingreso::TraficoCapturaDollar($registro->Fecha,$registro->CABINA_Id);
                    $paridad = Paridad::getParidad($registro->Fecha);
                    $capturaSoles = round((Detalleingreso::TraficoCapturaDollar($registro->Fecha,$registro->CABINA_Id)*Paridad::getParidad($registro->Fecha)),2);
                    $difCapturaSoles = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,2);
                    $difCapturaDollar = CicloIngresoModelo::getDifCaptura($registro->Fecha,$registro->CABINA_Id,1);

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($traficoCarptura), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::defineMonto($paridad).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($capturaSoles), $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($difCapturaSoles,$difCapturaSoles), $type).'</td>   
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format(Reportes::defineMonto($difCapturaDollar,$difCapturaDollar), $type).'</td>       
                                </tr>
                                ';
                    
                    $acumuladoTraficoCaptura = $acumuladoTraficoCaptura + $traficoCarptura;
                    $acumuladoCapturaSoles = $acumuladoCapturaSoles + $capturaSoles;
                    $acumuladoDifCapturaSoles = $acumuladoDifCapturaSoles + $difCapturaSoles;
                    $acumuladoDifCapturaDollar = $acumuladoDifCapturaDollar + $difCapturaDollar;

                }
                
//                 $balanceTotals = captura::get_ModelTotal($ids);
                 $table.=  Reportes::defineHeader("captura")
                                .'<tr >
                                        <td '.Reportes::defineStyleTd(2).' id="totalFecha">'.$registro->Fecha.'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="todas">Todas</td>
                                        <td '.Reportes::defineStyleTd(2).' id="vistaAdmin2">'.Reportes::format(Reportes::defineTotals($acumuladoTraficoCaptura), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalTrafico">N/A</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($acumuladoCapturaSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($acumuladoDifCapturaSoles,$acumuladoDifCapturaSoles), $type).'</td>
                                        <td '.Reportes::defineStyleTd(2).' id="totalRecargaMov">'.Reportes::format(Reportes::defineTotals($acumuladoDifCapturaDollar,$acumuladoDifCapturaDollar), $type).'</td>      
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