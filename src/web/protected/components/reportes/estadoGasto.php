<?php
/**
 * @package reportes
 */
class estadoGasto extends Reportes
{
    /**
     * @access public
     * @static
     * @return string $table
     */
    public static function reporte($ids,$type)
    {
        $balance=estadoGasto::get_Model($ids);
        if($balance!=NULL)
        {
            $table='<table class="items">'.
                        Reportes::defineHeader("estadoGasto")
                        .'<tbody>';
            foreach ($balance as $key => $registro)
            {
                $table.='<tr>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Utility::monthName($registro->FechaMes).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Tipogasto, ENT_QUOTES,'UTF-8').'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->Descripcion, ENT_QUOTES,'UTF-8').'</td>    
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->FechaVenc.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::format($registro->Monto, $type).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->moneda.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.htmlentities($registro->beneficiario, ENT_QUOTES,'UTF-8').'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.$registro->status.'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::definePago($registro->TransferenciaPago,$registro->status).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::definePago($registro->FechaTransf,$registro->status).'</td>
                            <td '.Reportes::defineStyleTd($key+2).'>'.Reportes::definePago($registro->Cuenta,$registro->status).'</td>
                        </tr>';
            }

            $balanceTotals=estadoGasto::get_ModelTotal($ids);
            $table.='<thead>
                        <tr>
                            <th '.self::defineStyleHeader("brightstar").' id="Fechas">Total Monto</th>
                            <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c2">Soles</th>
                            <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Dolares</th>
                        </tr>
                        <tr>
                            <td '.Reportes::defineStyleTd(2).'>------</td>
                            <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineMonto($balanceTotals->Cuenta).'</td>
                            <td '.Reportes::defineStyleTd(2).'>'.Reportes::defineMonto($balanceTotals->Cabina).'</td>  
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
        $sql="SELECT d.id AS id, t.nombre AS Tipogasto, d.FechaMes AS FechaMes, d.FechaVenc AS FechaVenc, d.Descripcion AS Descripcion, CASE d.status WHEN 1 THEN 'Orden de Pago' WHEN 2 THEN 'Aprovada' WHEN 3 THEN 'Pagada' END AS status,
                     d.Monto AS Monto, CASE d.moneda WHEN 1 THEN 'USD$' WHEN 2 THEN 'S/.' END AS moneda, d.beneficiario AS beneficiario, d.TransferenciaPago AS TransferenciaPago, d.FechaTransf AS FechaTransf, c.nombre AS Cabina, cu.Nombre AS Cuenta
              FROM detallegasto AS d INNER JOIN cabina AS c ON c.id=d.CABINA_Id INNER JOIN tipogasto AS t ON t.id=d.TIPOGASTO_Id INNER JOIN cuenta AS cu ON cu.id=d.CUENTA_Id
              WHERE d.id IN ($ids)
              ORDER BY d.id ASC, d.status ASC";
        return Detallegasto::model()->findAllBySql($sql);
    }

    /**
     * @access public
     * @static
     * @return object
     */
    public static function get_ModelTotal($ids)
    {
        $sql="SELECT (SELECT SUM(d.monto) 
                      FROM detallegasto AS d 
                      WHERE d.id IN ($ids) AND d.moneda=1) AS Cabina,
                     (SELECT SUM(d.monto) 
                      FROM detallegasto AS d 
                      WHERE d.id IN ($ids) AND d.moneda=2) AS Cuenta
              FROM detallegasto AS d";
        return Detallegasto::model()->findBySql($sql);
    }
}
?>