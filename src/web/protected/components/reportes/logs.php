 <?php

    /**
     * @package reportes
     */
    class logs extends Reportes 
    {
        public static function reporte($ids,$name) 
        {

            $nominaEmpleado = logs::get_Model($ids);
            if($nominaEmpleado != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("log")
                        .'<tbody>';
                foreach ($nominaEmpleado as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Hora.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaEsp.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Accion.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Usuario.'</td>  
                                    <td '.Reportes::defineStyleTd($key+2).'>'.  Cabina::getNombreCabina3($registro->Cabina).'</td>  
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
            $sql = "SELECT l.Id as Id, l.Fecha as Fecha, l.Hora as Hora, l.FechaEsp as FechaEsp, a.Nombre as Accion, u.username as Usuario, u.CABINA_Id as Cabina
                    FROM log as l
                    INNER JOIN accionlog as a ON a.Id = l.ACCIONLOG_Id
                    INNER JOIN users as u ON u.id = l.USERS_Id
                    WHERE l.Id IN ($ids) 
                    order by l.Fecha DESC, l.Hora ASC;";
            
              return Log::model()->findAllBySql($sql); 
         
        }
        
    }
    ?>