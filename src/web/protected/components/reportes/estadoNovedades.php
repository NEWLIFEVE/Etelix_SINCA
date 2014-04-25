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
                $table.='<tr>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Fecha.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Cabina::getNombreCabina(Yii::app()->getModule("user")->user($registro->users_id)->CABINA_Id).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->tIPONOVEDAD->Nombre.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.NovedadLocutorio::getLocutorioRow($registro->Id).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.DestinationInt::getNombre($registro->DESTINO_Id).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Observaciones.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Novedad::getStatus($registro->STATUS_Id).'</td>    
                        </tr>';
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