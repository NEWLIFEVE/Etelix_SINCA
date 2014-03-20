 <?php

    /**
     * @package reportes
     */
    class pabrightstarReport extends Reportes 
    {
        public static function reporte($ids,$name,$type) 
        {

            $pabrightstar = pabrightstarReport::get_Model($ids);
            if($pabrightstar != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("pabrightstar")
                        .'<tbody>';
                foreach ($pabrightstar as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->Fecha, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->Compania, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->SaldoAperturaPA, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->TransferenciaPA, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->ComisionPA, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->RecargaPA, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->SubtotalPA, $type).'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->SaldoCierrePA, $type).'</td>    
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
            $sql = "SELECT p.Id, p.Fecha, c.nombre as Compania, p.SaldoAperturaPA, p.TransferenciaPA, p.ComisionPA, 
                    (IFNULL(p.TransferenciaPA,0)+IFNULL(p.ComisionPA,0)) as RecargaPA, (IFNULL(p.SaldoAperturaPA,0)+IFNULL(p.TransferenciaPA,0)+IFNULL(p.ComisionPA,0)) as SubtotalPA, p.SaldoCierrePA 
                    FROM pabrightstar as p
                    INNER JOIN compania as c ON c.id = p.Compania
                    WHERE p.Id IN ($ids) 
                    order by p.Fecha DESC;";
            
              return Pabrightstar::model()->findAllBySql($sql); 
         
        }
        
    }
    ?>