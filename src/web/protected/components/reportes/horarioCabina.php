 <?php

    /**
     * @package reportes
     */
    class horarioCabina extends Reportes 
    {
        public static function reporte($ids,$name) 
        {
            
            $horarioCabina = horarioCabina::get_Model($ids);
            if($horarioCabina != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("horarioCabina")
                        .'<tbody>';
                foreach ($horarioCabina as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Nombre.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->HoraIni.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->HoraFin.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->HoraIniDom.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->HoraFinDom.'</td>    
                                </tr>
                                ';

                }

            }else{
                $table='Hubo un error';
            }
            return $table;
        }
            
         
        public static function get_Model($ids) 
        {
            $sql = "SELECT Id, Nombre, Codigo, status, HoraIni, HoraFin, HoraIniDom, HoraFinDom 
                    FROM cabina
                    WHERE Id IN ($ids) 
                    order by Nombre;";
            
              return Cabina::model()->findAllBySql($sql); 
         
        }
        
    }
    ?>