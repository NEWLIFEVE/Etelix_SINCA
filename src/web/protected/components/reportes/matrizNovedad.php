<?php
/**
 * @package reportes
 */
class matrizNovedad extends Reportes
{
    public static function reporte($mes,$nombre)
    {
        if($mes==NULL)
        {
            $tr='Hubo un Error';
        }
        else
        {
            $borde = 'border:1px;border-style:solid;border-color: #E9E0E0;';

            $sql="SELECT t.Nombre as TipoNovedad
                  FROM novedad as n
                  INNER JOIN tiponovedad as t ON t.Id = n.TIPONOVEDAD_Id
                  WHERE n.Fecha = '$mes'
                  GROUP BY t.Nombre
                  ORDER BY t.Nombre;";
            $model = Novedad::model()->findAllBySql($sql);
            
            
            $row="<tr >
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
                <td style='height: em; background-color: #DADFE4;'></td>
              </tr>";
            
            if($model!=false)
            {
                $tr="<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$nombre}</h2>
                    <br>
                     <table id='tabla' class='matrizGastos' border='0' style='border-collapse:collapse;width:auto;border-color: #DADFE4;'>
                        <thead>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <center>
                                    <img style='padding-left: 5px; width: 17px;' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Monitor.png' />
                                </center>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Chimbote</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Etelix-Peru</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Huancayo</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 01</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Iquitos 03</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Piura</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Pucallpa</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Surquillo</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Tarapoto</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 01</h3>
                            </th>
                            <th style='width: 80px;background: #ff9900;text-align: center;$borde'>
                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Trujillo 03</h3>
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                                <td style='height: em; background-color: #DADFE4;'></td>
                            </tr>";
                foreach ($model as $key => $gasto) {

                $content="";


                    $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND Id !=18  ORDER BY nombre";
                    $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
                    $count = 0;
                    foreach ($cabinas as $key => $cabina) {

                        $MontoGasto = Novedad::getLocutorioOldTable($cabina->Id,$gasto->TipoNovedad,$mes);
                        if($MontoGasto == false)
                            $MontoGasto = Novedad::getLocutorioNewTable($cabina->Id,$gasto->TipoNovedad,$mes);

                        if ($MontoGasto!=NULL){
                                        $fondo = '';

                                    if ($count>0){

                                        $content.="<td style='width: 80px; $fondo; font-size:12px;text-align: center;$borde'>$MontoGasto</td>";

                                    }else{

                                        $content.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->TipoNovedad</h3></td>";
                                        $content.="<td style='width: 80px; $fondo; font-size:12px;text-align: center;$borde'>$MontoGasto</td>";
                                    }
                        }  else {
                            if ($count>0){
                                $content.="<td style='$borde'></td>";
                            }else{
                                $content.="<td style='width: 200px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->TipoNovedad</h3></td>";
                            }
                        }
                        $count++;
                    }


             $tr.="<tr id='ordenPago'> 

                     $content     

                   </tr>";

            }    
                 
                $tr.= "</tbody></table>"; 

                return $tr;
            }

        }
    }
  
}
?>