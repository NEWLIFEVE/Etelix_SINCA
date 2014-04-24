<?php
/**
 * @package reportes
 */
class matrizNovedadSemana extends Reportes
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

            $sql="SELECT * FROM cabina WHERE status = 1  AND Id !=18 AND Id !=19 ORDER BY nombre";
            $model = Cabina::model()->findAllBySql($sql);
            
            
            $dia_array = Array();
            for($i=6;$i>=0;$i--){
                $dia_array[$i] = date('Y-m-j',strtotime("-$i day",strtotime($mes)));
            } 
            
            $row="<tr >
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
                            </th>";
                            for($i=6;$i>=0;$i--){ 
                                if(date("w", strtotime($dia_array[$i])) != 5)
                                    $tr.= "<th style='background-color: #ff9900;$borde'>
                                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$dia_array[$i]</h3>
                                           </th>";
                                else
                                    $tr.= "<th style='background-color: #00992B;$borde'>
                                                <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$dia_array[$i]</h3>
                                           </th>";
                            }
                        $tr.="<th style='background-color: #ff9900;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total por Cabina</h3></th></thead>
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
                            </tr>";
                foreach($model as $key => $gasto)
                {
                    $content="";

                    $content.="<td style='width: 80px; background: #1967B2;$borde'><h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>$gasto->Nombre</h3></td>";

                    for($i=6;$i>=0;$i--){ 

                      $Total_Fallas = Novedad::getLocutorioTotalesCabinas($gasto->Id,$dia_array[$i]);  

                      $content.="<td style='width: 80px;text-align:center; font-size:10px;$borde'>".$Total_Fallas."</td>";
                    }
                    $Total_Cabinas = Novedad::getTotalesCabina($gasto->Id,$dia_array[6],$dia_array[0]); 
                    
                     $tr.="<tr id='ordenPago'> 

                         $content     
                         <td style='width: 80px;text-align:center; font-size:10px;background-color: #DADFE4;$borde'>".$Total_Cabinas."</td>     

                     </tr>";
            
                }
                
                //$tr.= $row;

                $tr.= "<tr id='TotalesNovedad'> 
                <td rowspan='1' style='color: #FFF;width: 120px; background: #ff9900;font-size:10px;$borde'>
                            <h3 style='font-size:10px; color:#FFFFFF; background: none; text-align: center;'>Total por Dia</h3>
                </td>";
                $TotalTotales = 0;
                for($i=6;$i>=0;$i--){ 

                   $Totales =  Novedad::getTotalesDias($dia_array[$i]);
                   $TotalTotales = $TotalTotales + $Totales;
                   $tr.= "<td style='width: 80px;background-color: #DADFE4; font-size:10px;text-align:center;$borde'>".$Totales."</td>";
                }    
                 
                $tr.= "<td style='color: #FFFFFF; height: em; background-color: #1967B2;font-size:10px;text-align:center;$borde'>".$TotalTotales."</td></tr></tbody></table>"; 

                return $tr;
            }

        }
    }
  
}
?>