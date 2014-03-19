 <?php

    /**
     * @package reportes
     */
    class nominaEmpleado extends Reportes 
    {
        public static function reporte($ids,$name) 
        {

            $nominaEmpleado = nominaEmpleado::get_Model($ids);
            if($nominaEmpleado != NULL){
                
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table class='items'>".
                        Reportes::defineHeader("nominaEmpleado")
                        .'<tbody>';
                foreach ($nominaEmpleado as $key => $registro) {

                    $table.=   '<tr >
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->code_employee.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->name.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->lastname.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->identification_number.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cabina.'</td>  
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Cargo.'</td>  
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->salary.'</td>
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->Moneda.'</td>  
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->bank_account.'</td>      
                                    <td '.Reportes::defineStyleTd($key+2).'>'.Employee::getName($registro->immediate_supervisor).'</td> 
                                    <td '.Reportes::defineStyleTd($key+2).'>'.$registro->admission_date.'</td> 
                                    <td '.Reportes::defineStyleTd($key+2).'>'.(($registro->status == 1)? 'Activo' : 'Inactivo').'</td>  

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
            $sql = "SELECT e.id as Id, e.code_employee as code_employee, e.name as name, e.lastname as lastname, e.identification_number as identification_number, 
                    c.Nombre as Cabina, p.name as Cargo, e.salary as salary, cu.name as Moneda, e.bank_account as bank_account, e.immediate_supervisor as immediate_supervisor, e.admission_date as admission_date,
                    e.status as status
                    FROM employee as e
                    INNER JOIN cabina as c ON c.Id = e.CABINA_Id
                    INNER JOIN position as p ON p.id = e.position_id
                    INNER JOIN currency as cu ON cu.id = e.currency_id
                    WHERE e.id IN ($ids) 
                    order by e.status ASC, e.code_employee ASC;";
            
              return Employee::model()->findAllBySql($sql); 
         
        }
        
    }
    ?>