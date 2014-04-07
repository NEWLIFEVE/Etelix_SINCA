<?php
/**
 * @package reportes
 */
class adminIngreso extends Reportes
{
    /**
     * @access public
     * @static
     * @return string $table
     */
    public static function reporte($ids,$name,$type)
    {
        $balance=adminIngreso::get_Model($ids);
        if($balance!=NULL)
        {
                    $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("adminIngreso")
                        .'<tbody>';
            foreach ($balance as $key => $registro)
            {
                $table.='<tr>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Utility::monthName($registro->FechaMes).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Tipoingreso, ENT_QUOTES,'UTF-8').'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->Monto, $type).'</td>    
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->moneda.'</td>     
                            <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Descripcion, ENT_QUOTES,'UTF-8').'</td>    
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->TransferenciaPago.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaTransf.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cuenta.'</td>
                        </tr>';
            }

            $balanceTotals=adminIngreso::get_ModelTotal($ids);
            $table.='<thead>
                        <tr>
                            <th '.self::defineStyleHeader("brightstar").' id="Fechas">Total Monto</th>
                            <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c2">Soles</th>
                            <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Dolares</th>
                        </tr>
                        <tr>
                            <td '.Reportes::defineStyleTd(2).'>------</td>
                            <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineMonto($balanceTotals->Cuenta), $type).'</td>
                            <td '.Reportes::defineStyleTd(2).'>'.Reportes::format(Reportes::defineMonto($balanceTotals->Cabina), $type).'</td>  
                        </tr>
                    </thead>
                    </tbody>
                    </table>';
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
        $sql="SELECT d.id AS Id, t.Nombre AS Tipoingreso, d.FechaMes AS FechaMes, d.Monto AS Monto, CASE d.moneda WHEN 1 THEN 'USD$' WHEN 2 THEN 'S/.' END AS moneda, d.Descripcion AS Descripcion,
                d.TransferenciaPago AS TransferenciaPago, DATE_FORMAT(d.FechaTransf, '%d/%m/%y') AS FechaTransf, c.nombre AS Cabina, cu.Nombre AS Cuenta
                FROM detalleingreso AS d 
                INNER JOIN cabina AS c ON c.id=d.CABINA_Id 
                INNER JOIN tipo_ingresos AS t ON t.id=d.TIPOINGRESO_Id 
                INNER JOIN cuenta AS cu ON cu.id=d.CUENTA_Id
                WHERE d.id IN ($ids)
                ORDER BY d.id ASC";
    return Detalleingreso::model()->findAllBySql($sql);
    }

    /**
     * @access public
     * @static
     * @return object
     */
    public static function get_ModelTotal($ids)
    {
        $sql="SELECT (SELECT SUM(d.Monto) 
                      FROM detalleingreso AS d 
                      WHERE d.Id IN ($ids) AND d.moneda=1) AS Cabina,
                     (SELECT SUM(d.Monto) 
                      FROM detalleingreso AS d 
                      WHERE d.id IN ($ids) AND d.moneda=2) AS Cuenta
              FROM detalleingreso AS d";
        return Detalleingreso::model()->findBySql($sql);
    }
}
?>