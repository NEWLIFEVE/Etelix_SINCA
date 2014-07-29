<?php

    /**
     * @package reportes
     */
    class novedadFalla extends Reportes 
    {
        public static function reporte($ids,$name) 
        {

            
            $novedadFalla = novedadFalla::get_Model($ids);
            if($novedadFalla != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("novedadFalla")
                        .'<tbody>';
                foreach ($novedadFalla as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Hora.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->TipoNovedad.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->User.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Descripcion, ENT_QUOTES,'UTF-8').'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Num.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.NovedadLocutorio::getLocutorioRow($registro->Id).'</td>
                                </tr>';

                }
                
                    $table.=   '</tbody>
                           </table>';

            }else{
                $table='Hubo un error';
            }
            return $table;
        }
            
         
        public static function get_Model($ids) 
        {
            $sql = "SELECT n.Id, n.Fecha, n.Hora, n.Descripcion, n.Num, n.Puesto, t.Nombre as TipoNovedad, u.username as User
                    FROM novedad as n
                    INNER JOIN tiponovedad as t ON t.Id = n.TIPONOVEDAD_Id
                    INNER JOIN users as u ON u.id = n.users_id
                    WHERE n.Id IN ($ids)
                    ORDER BY n.Fecha DESC, n.Hora DESC;";
            
              return Novedad::model()->findAllBySql($sql); 
         
        }
        
    }
