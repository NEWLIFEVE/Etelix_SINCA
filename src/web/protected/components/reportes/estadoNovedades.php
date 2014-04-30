<?php
/**
 * @package reportes
 */
class estadoNovedades extends Reportes
{
    /**
     * @access public
     * @static
     * @return string $table
     */
    public static function reporte($ids,$name)
    {
        $timeTicket = '';
        $balance=estadoNovedades::get_Model($ids);
        if($balance!=NULL)
        {
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items' style='width:100%;'>".
                        Reportes::defineHeader("estadoNovedades")
                        .'<tbody>';
            foreach ($balance as $key => $registro)
            {
                if($registro->STATUS_Id == 2)
                    $timeTicket = Utility::getTime($registro->Fecha, $registro->Hora, $registro->FechaCierre, $registro->HoraCierre);
                else
                    $timeTicket = Utility::getTime($registro->Fecha, $registro->Hora, date('Y-m-d',time()), date('H:i:s',time()));
                $table.='<tr>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Cabina::getNombreCabina(Yii::app()->getModule("user")->user($registro->users_id)->CABINA_Id).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->tIPONOVEDAD->Nombre.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.NovedadLocutorio::getLocutorioRow($registro->Id).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.DestinationInt::getNombre($registro->DESTINO_Id).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Observaciones.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Novedad::getStatus($registro->STATUS_Id).'</td>  
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'/'.date('H:i',strtotime($registro->Hora)).'</td>';
                            if($registro->STATUS_Id == 2){
                                $table.= '<td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaCierre.'/'. Utility::timeNull($registro->HoraCierre).'</td>'
                                        . '<td '.Reportes::defineStyleTd($key+2).'>'.Utility::restarHoras($registro->Hora, $registro->HoraCierre, floor($timeTicket/(60*60*24))).'</td>';    
                            }else{
                                $table.='<td '.Reportes::defineStyleTd($key+2).'></td><td '.Reportes::defineStyleTd($key+2).'>'.Utility::restarHoras($registro->Hora, date('H:i:s',time()), floor($timeTicket/(60*60*24))).'</td>';
                            }            
                        $table.='</tr>';
            }

        }
        else
        {
            $table='Hubo un error';
        }
        return $table;
    }

    /**
     * @access public
     * @static
     * @return array
     */
    public static function get_Model($ids)
    {
        $sql="SELECT * 
              FROM novedad 
              WHERE Id IN ($ids)
              ORDER BY Fecha DESC, STATUS_ID ASC";
        return Novedad::model()->findAllBySql($sql);
    }

}
?>