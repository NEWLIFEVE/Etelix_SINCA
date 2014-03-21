 <?php

    /**
     * @package reportes
     */
    class tableroControl extends Reportes 
    {
        public static function reporte($date,$name) 
        {

            date_default_timezone_set('America/Caracas');

            $horaMostrarCaracas = "Hora Actual: ".date("h:i:s A",time())." Caracas / Venezuela.";

            date_default_timezone_set('America/Lima');

            /* BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA PARA VALIDAR QUE NO EXISTA */
            $sql = "SELECT id,Nombre FROM cabina WHERE status = 1 AND Id NOT IN  (18,19) ORDER BY Nombre";
            $connection0 = Yii::app()->db;
            $command0 = $connection0->createCommand($sql);
            $cabinas = $command0->query(); // execute a query SQL

            $dias = array('Sun' => 'Domingo', 'Mon' => 'Lunes','Tue' => 'Martes','Wed' => 'Miercoles','Thu' => 'Jueves','Fri' => 'Viernes','Sat' => 'Sabado');

            //$connection01 = Yii::app()->db;
            $command01 = $connection0->createCommand($sql);
            $cabinas1 = $command01->query(); // execute a query SQL

            //$connection02 = Yii::app()->db;
            $command02 = $connection0->createCommand($sql);
            $cabinas2 = $command02->query(); // execute a query SQL
            
            $codigo = array();
            $nombre = array();
            for ($i = 1; $i <= $cabinas1->count(); $i++) {
                $codigo[$i]  = $cabinas1->readColumn(0);
                $nombre[$i]  = $cabinas2->readColumn(1);
            }
            $model=new Balance();
            
            if($date == null)
                list($year, $mon, $day) = explode('-', date("Y-m-d", time()));
            else
                list($year, $mon, $day) = explode('-', $date);
                
            $dias = array('Sun' => 'Domingo', 'Mon' => 'Lunes','Tue' => 'Martes','Wed' => 'Miercoles','Thu' => 'Jueves','Fri' => 'Viernes','Sat' => 'Sabado');
            $diaMostrar = $dias[date('D',mktime(0, 0, 0,$mon , $day, $year))];
            $fechaActual = date('Y-m-d', mktime(0, 0, 0,$mon, $day, $year));
            $fechaAyer = date('Y-m-d', mktime(0, 0, 0,$mon, $day-1, $year));
            
            
                $table = "<h2 style='font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;'>{$name}</h2>
                        <br>
                        <table id='tabla' class='tabla2 items' border='1' style='background-color:#F2F4F2; border-collapse:collapse;width:auto;'>
                        <tr>
                            <td style='font-weight:bold; background: #1967B2' ><span style='background: url('http://sinca.sacet.com.ve/themes/mattskitchen/img/footer_bg.gif&quot;) repeat scroll 0 0 #2D2D2D;'><div align='center' style='width:80px;'><img align='center' src='http://sinca.sacet.com.ve/themes/mattskitchen/img/Activity-w.png' /></div></span></td>
                            <td style='width: 120px; background: #1967B2;' ><h3 align='center' style='font-size:13px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Inicio Jornada</h3></td>
                            <td style='width: 120px; background: #1967B2' ><h3 align='center' style='font-size:13px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Saldo Apertura</h3></td>
                            <td style='width: 120px; background: #1967B2' ><h3 align='center' style='font-size:13px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Ventas Llamadas</h3></td>
                            <td style='width: 120px; background: #1967B2' ><h3 align='center' style='font-size:13px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Depositos</h3></td>
                            <td style='width: 120px; background: #1967B2' ><h3 align='center' style='font-size:13px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Saldo Cierre</h3></td>
                            <td style='width: 120px; background: #1967B2' ><h3 align='center' style='font-size:13px; color:#FFFFFF; background: url(../img/line_hor.gif) repeat-x 0 100%;'>Fin Jornada</h3></td>
                        </tr> ";
                        for ($i = 1; $i <= $cabinas->count(); $i++) {
                                        $sqlCP1 = 'SELECT DISTINCT(DATE_FORMAT(l.Hora, "%H:%i")) as HORA FROM log l, users u 
                        WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina ORDER BY HORA ASC';

                                        $sqlCP = 'SELECT DISTINCT(DATE_FORMAT(l.Hora, "%H:%i")) as HORA FROM log l, users u 
                        WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.FechaEsp = :fechaesp and l.USERS_Id = u.Id and u.CABINA_Id = :cabina ORDER BY HORA ASC';

                                        $sqlCP2 = 'SELECT DISTINCT(DATE_FORMAT(l.Hora, "%H:%i")) as HORA FROM log l, users u 
                        WHERE l.ACCIONLOG_Id = :accion and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina and l.hora > "19:00:00"';
                                        
                                        $sqlCP3 = Cabina::model()->findBySql("SELECT * FROM cabina WHERE Id = $codigo[$i]");

                            $post = $model->find("CABINA_Id = :id and Fecha = :fecha", array(":id" => $i, ":fecha" => $fechaActual));
                            $table .= "<tr>
                                <td style='font-size:10px; font-weight:bold; color:#FFFFFF; background: #1967B2' >
                                    <div align='center' style='width:80px;'>$nombre[$i]</div>
                                </td>
        
                            <td>";
/********************************INICIO JORNADA*******************************************************/
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP1);
                $command->bindValue(':cabina', $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(':accion', 9); // bind de parametro cabina del user
                $command->bindValue(':fecha', $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    
                    //COMPARA LA HORA DE INICIO DE JORDADA CON LA HORA DE INICIO NORMAL DE LA CABINA
                     $hora = $id->readColumn(0); 
                          if(($diaMostrar != 'Domingo' && $hora <= $sqlCP3->HoraIni) || ($diaMostrar == 'Domingo' && $hora <= $sqlCP3->HoraIniDom)){                               
                                $table .="<div align='center' style='color:#36C; font-family:'Trebuchet MS', cursive; font-size:20px;'> $hora</div>";
                     }else{  
                                $table .="<div align='center' style='color:#ff9900; font-family:'Trebuchet MS', cursive; font-size:20px;'><img src='".Yii::app()->request->baseUrl."/themes/mattskitchen/img/warning.png' style='width:16px;height: 16px;'/>  $hora </div>";
                     }  
            
                } else {
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/no.png'></div>";
                }
            $table .= "</td>
            <td style='height: 35px;'>"; 
/********************************SALDO APERTURA*******************************************************/            
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP1);
                $command->bindValue(':cabina', $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(':accion', 2); // bind de parametro cabina del user
                $command->bindValue(':fecha', $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                //$command->bindValue(':fechaesp', $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/si.png'></div>";
            
                 } else { 
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/no.png'></div>";
                    
                }
            $table .= "</td>
            <td style='height: 35px;'>"; 
/********************************LLAMADAS*******************************************************/
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP);
                $command->bindValue(':cabina', $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(':accion', 3); // bind de parametro cabina del user
                $command->bindValue(':fecha', $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario 
                $command->bindValue(':fechaesp', $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/si.png'></div>";
            
                 } else { 
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/no.png'></div>";
                }
            $table .= "</td>
            <td style='height: 35px;'>"; 
/********************************DEPOSITOS*******************************************************/
            
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP);
                $command->bindValue(':cabina', $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(':accion', 4); // bind de parametro cabina del user
                $command->bindValue(':fecha', $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario  
                $command->bindValue(':fechaesp', $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/si.png'></div>";
            
                 } else { 
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/no.png'></div>";
                    
                }
            $table .= "</td>
            <td style='height: 35px;'>"; 
/********************************SALDO CIERRE*******************************************************/
           
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sqlCP1);
                $command->bindValue(':cabina', $codigo[$i]); // bind de parametro cabina del user
                $command->bindValue(':accion', 8); // bind de parametro cabina del user
                $command->bindValue(':fecha', $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario   
                //$command->bindValue(':fechaesp', $fechaAyer, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario
                $id = $command->query(); // execute a query SQL
                if ($id->count()) {
                    
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/si.png'></div>";
            
                 } else { 
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/no.png'></div>";
                    
                }
            $table .= "</td>
            <td style='height: 35px;'>"; 
/********************************FIN JORNADA*******************************************************/
         
                $connection2 = Yii::app()->db;
                $command2 = $connection2->createCommand($sqlCP2);
                $command2->bindValue(':cabina', $codigo[$i]); // bind de parametro cabina del user
                $command2->bindValue(':accion', 10); // bind de parametro cabina del user
                $command2->bindValue(':fecha', $fechaActual, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                $id2 = $command2->query(); // execute a query SQL
                if ($id2->count()) {
                    
                    // COMPARA LA HORA DE FIN DE JORDADA CON LA HORA DE FIN NORMAL DE LA CABINA 
                     $hora2 = $id2->readColumn(0); 
                    if(($diaMostrar != 'Domingo' && $hora2.':00' < $sqlCP3->HoraFin) || ($diaMostrar == 'Domingo' && $hora2.':00' < $sqlCP3->HoraFinDom)){  
                                $table .= "<div align='center' style='color:#ff9900; font-family:'Trebuchet MS', cursive; font-size:20px;'><img src='".Yii::app()->request->baseUrl." /themes/mattskitchen/img/warning.png' style='width:16px;height: 16px;'/> $hora2 </div>";
                    }else{  
                                $table .= "<div align='center' style='color:#36C; font-family:'Trebuchet MS', cursive; font-size:20px;'> $hora2 </div>";
                     }   

                 } else { 
                    $table .= "<div align='center'><img src='http://sinca.sacet.com.ve/themes/mattskitchen/img/no.png'></div>";
                    
                }             
            $table .= "</td>
        </tr>";

        } 
        $table .= "</table>";

            return $table;
        }

    }
    ?>