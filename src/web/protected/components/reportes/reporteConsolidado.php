<?php

class reporteConsolidado extends Reportes 
{
     public static function reporte($day,$name,$dir) 
     {

            $objPHPExcel = new PHPExcel();
            $sheet = new reporteConsolidado(); 

            $objPHPExcel->
                    getProperties()
                            ->setCreator("SINCA")
                            ->setLastModifiedBy("SINCA")
                            ->setTitle($name)
                            ->setSubject($name)
                            ->setDescription("Reportes Consolidados de Fallas")
                            ->setKeywords("SINCA Reportes Consolidado Falla")
                            ->setCategory($name);


            //PRIMERA HOJA (MATRIZ DE FALLAS POR SEMANA)
            $sheet->_genSheetOne($objPHPExcel,$day); 

            //SEGUNDA HOJA (MATRIZ GENERAL DE FALLAS POR DIA)
            $sheet->_genSheetTwo($objPHPExcel,$day);
            
            //TERCERA HOJA (ESTADO DE FALLAS POR DIA)
            $cantidad_dias = date('j', strtotime($day));
            for($i=1;$i<($cantidad_dias+1);$i++){
                $diass = date('Y-m-j',strtotime("-".($cantidad_dias-$i)." day",strtotime($day)));
                $sheet->_genSheetThree($objPHPExcel,$diass,$i);
            }
            
            //IMPRIMIENDO LOS RESULTADOS
            
            //TITULOS DE LAS HOJAS
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('Total Cabinas');
            $objPHPExcel->setActiveSheetIndex(1)->setTitle('Fallas por Locutorio');

            //HOJA A MOSTRAR POR DEFECTO (MATRIZ DE FALLAS POR SEMANA)
            $objPHPExcel->setActiveSheetIndex(0);
            
            //MECANISMO QUE GENERA EL EXCEL
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename='{$name}.xlsx'");
            header("Cache-Control: max-age=0");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            if($dir!=NULL){
                $objWriter->save($dir);
            }    
            elseif($dir==NULL){
                $objWriter->save('php://output');
                exit;
            }

    }
    
    //ASIGNA COLOR A UNA CELDA ESPECIFICADA
    public static function cellColor($cells,$color,$objPHPExcel){
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => $color),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),'rgb' => $color)
        ));
    }
    
    //ASIGNA COLOR AL BORDE DE UNA CELDA ESPECIFICADA
    public static function borderColor($cells,$color,$objPHPExcel){
        $styleArray = array(
               'borders' => array(
                     'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => $color),
                     ),
               ),
        );
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
    }
    
    //ASIGNA LOS VALORES DE COLOR Y TAMAÑO A LA CELDA ESPECIFICADA
    public static function font($cells,$color,$size,$objPHPExcel){
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => $color),
                'size'  => $size,
                'name'  => 'Calibri'
        ));
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    
    //GENERA LA 1ERA HOJA DEL REPORTE (MATRIZ TOTAL DE TT POR CABINA)
    private function _genSheetOne($objPHPExcel,$day){
            $sql="SELECT * FROM cabina WHERE status = 1  AND Id !=18 AND Id !=19 ORDER BY nombre";
            $model = Cabina::model()->findAllBySql($sql);
            $cantidad_cabinas = count($model);
            
            $ultimo_dia = date('Y-m-j',strtotime("-6 day",strtotime($day)));
            $dia_array = Array();
            for($i=6;$i>=0;$i--){
                $dia_array[$i] = date('Y-m-j',strtotime("-$i day",strtotime($day)));
            }
            $cols_asrray = Array('H','G','F','E','D','C','B');
            
            //ANCHO DE CELDAS
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            for($i=6;$i>=0;$i--){
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[$i])->setAutoSize(true);
            }
            
            //TITULO
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'SINCA Matriz Total de TTs por Cabina ('.$ultimo_dia.'/'.$day.')');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1")->getFont()->setSize(16);
            
            //ENCABEZADO
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Cabinas/Fechas');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', 'Total por Cabina');
            self::cellColor('A3', 'ff9900',$objPHPExcel);
            self::cellColor('I3', 'ff9900',$objPHPExcel);
            self::borderColor('A3','E9E0E0',$objPHPExcel);
            self::borderColor('I3','E9E0E0',$objPHPExcel);
            self::font('A3','FFFFFF','10',$objPHPExcel);
            self::font('I3','FFFFFF','10',$objPHPExcel);
            
            for($i=6;$i>=0;$i--){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'3', $dia_array[$i]);
                self::borderColor($cols_asrray[$i].'3','E9E0E0',$objPHPExcel);
                self::font($cols_asrray[$i].'3','FFFFFF','10',$objPHPExcel);
                if(date("w", strtotime($dia_array[$i])) != 5)
                    self::cellColor($cols_asrray[$i].'3', 'ff9900',$objPHPExcel);
                else
                    self::cellColor($cols_asrray[$i].'3', '00992B',$objPHPExcel);
            }

            //CONTENIDO DE LA MATRIZ (CANTIDAD DE FALLAS POR DIA Y CABINA)
            foreach($model as $key => $gasto)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($key+4), $gasto->Nombre);
                self::cellColor('A'.($key+4), '1967B2',$objPHPExcel);
                self::borderColor('A'.($key+4),'E9E0E0',$objPHPExcel);
                self::font('A'.($key+4),'FFFFFF','10',$objPHPExcel);
                
                for($i=6;$i>=0;$i--){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].($key+4), Novedad::getLocutorioTotalesCabinas($gasto->Id,$dia_array[$i]));
                    self::font($cols_asrray[$i].($key+4),'000000','10',$objPHPExcel); 
                }
                
                //TOTALES POR CABINA
                $Total_Cabinas = Novedad::getTotalesCabina($gasto->Id,$dia_array[6],$dia_array[0]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($key+4), $Total_Cabinas);
                self::cellColor('I'.($key+4), 'DADFE4',$objPHPExcel);
                self::borderColor('I'.($key+4),'E9E0E0',$objPHPExcel);
                self::font('I'.($key+4),'000000','10',$objPHPExcel); 
            }
            
            //TOTALES POR DIA
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($cantidad_cabinas+4), 'Total por Dia');
            self::cellColor('A'.($cantidad_cabinas+4), 'ff9900',$objPHPExcel);
            self::borderColor('A'.($cantidad_cabinas+4),'E9E0E0',$objPHPExcel);
            self::font('A'.($cantidad_cabinas+4),'FFFFFF','10',$objPHPExcel);
            
            $Gran_Totales = 0;
            for($i=6;$i>=0;$i--){
                $Totales =  Novedad::getTotalesDias($dia_array[$i]);
                $Gran_Totales = ($Gran_Totales + $Totales);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].($cantidad_cabinas+4), $Totales);
                self::cellColor($cols_asrray[$i].($cantidad_cabinas+4), 'DADFE4',$objPHPExcel);
                self::borderColor($cols_asrray[$i].($cantidad_cabinas+4),'E9E0E0',$objPHPExcel);
                self::font($cols_asrray[$i].($cantidad_cabinas+4),'000000','10',$objPHPExcel);
            }
            
            //GRAN TOTALES
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($cantidad_cabinas+4), $Gran_Totales);
            self::cellColor('I'.($cantidad_cabinas+4), '1967B2',$objPHPExcel);
            self::borderColor('I'.($cantidad_cabinas+4),'E9E0E0',$objPHPExcel);
            self::font('I'.($cantidad_cabinas+4),'FFFFFF','10',$objPHPExcel);  

    }
    
    //GENERA LA 2DA HOJA DEL REPORTE (MATRIZ GENERAL POR DIA)
    private function _genSheetTwo($objPHPExcel,$day){
            //TITULO
            $objPHPExcel->createSheet(1)->setCellValue('A1', 'SINCA Matriz General de Fallas '.$day);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle("A1")->getFont()->setSize(16);
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:F1');
            
            $cols_asrray = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
                                 'R','S','T','U','V','W','X','Y','Z');

            //ANCHO DE CELDAS
            $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setAutoSize(true);
            for($i=1;$i<16;$i++){
                $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension($cols_asrray[$i])->setAutoSize(true);
            }

            //ENCABEZADO
            $nombre_cabinas = Cabina::model()->findAllBySQL("SELECT Nombre FROM cabina 
                                      WHERE status=1 AND Nombre!='ZPRUEBA' AND Nombre != 'COMUN CABINA'
                                      ORDER BY Nombre;");
            
            foreach ($nombre_cabinas as $key => $value) {
                $nombre_cabinass[$key] = $value->Nombre;
            }
            
            $cantidad_cabinas = count($nombre_cabinas);
                
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', 'Fallas/Cabinas');
            self::cellColor('A3', 'ff9900',$objPHPExcel);
            self::borderColor('A3','E9E0E0',$objPHPExcel);
            self::font('A3','FFFFFF','10',$objPHPExcel);
            
            for($i=0;$i<$cantidad_cabinas;$i++){
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cols_asrray[($i+1)].'3', $nombre_cabinass[$i]);
                self::cellColor($cols_asrray[($i+1)].'3', 'ff9900',$objPHPExcel);
                self::borderColor($cols_asrray[($i+1)].'3','E9E0E0',$objPHPExcel);
                self::font($cols_asrray[($i+1)].'3','FFFFFF','10',$objPHPExcel);
            }

            //CONTENIDO DE LA MATRIZ (FALLAS POR EL DIA SELECCIONADO)
            $tipos_novedad="SELECT t.Nombre as TipoNovedad
                  FROM novedad as n
                  INNER JOIN tiponovedad as t ON t.Id = n.TIPONOVEDAD_Id
                  WHERE n.Fecha = '$day'
                  GROUP BY t.Nombre
                  ORDER BY t.Nombre;";
            $novedades = Novedad::model()->findAllBySql($tipos_novedad);
            if($novedades!=NULL){
                foreach ($novedades as $key => $value) {      

                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.($key+4), $value->TipoNovedad);
                    self::cellColor('A'.($key+4), '1967B2',$objPHPExcel);
                    self::borderColor('A'.($key+4),'E9E0E0',$objPHPExcel);
                    self::font('A'.($key+4),'FFFFFF','10',$objPHPExcel);

                    //CONTENIDO DE LA MATRIZ (LOCUTORIOS POR CABINAS Y FALLAS)
                    $sqlCabinas = "SELECT * FROM cabina WHERE status = 1  AND Id !=18 And Id !=19 ORDER BY nombre;";
                    $cabinas = Cabina::model()->findAllBySql($sqlCabinas);
                    foreach ($cabinas as $ke => $cabina) {

                            $locutorios = Novedad::getLocutorioOldTable($cabina->Id,$value->TipoNovedad,$day);
                            if($locutorios == false)
                                $locutorios = Novedad::getLocutorioNewTable($cabina->Id,$value->TipoNovedad,$day);

                            if ($locutorios!=NULL){
                                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cols_asrray[($ke+1)].($key+4), $locutorios);
                                self::borderColor($cols_asrray[($ke+1)].($key+4),'E9E0E0',$objPHPExcel);
                                self::font($cols_asrray[($ke+1)].($key+4),'000000','10',$objPHPExcel);
                            }
                    }

                }
            }else{
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A5', 'No se Reportaron Fallas por el Sistema SINCA para esta Fecha');
                self::font('A5','000000','12',$objPHPExcel);
                $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A5:M5');
            }
    }
    
    //GENERA LA 3ERA HOJA DEL REPORTE (ESTADO DE FALLAS POR RANGO)
    private function _genSheetThree($objPHPExcel,$day,$sheets){
        
            $sheet = $sheets+1;
            $timeTicket = '';
            //TITULO
            $objPHPExcel->createSheet($sheet)->setCellValue('A1', 'SINCA Estado de Fallas '.$day);
            $objPHPExcel->setActiveSheetIndex($sheet)->getStyle("A1")->getFont()->setSize(16);
            $objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A1:F1');
            
            //NOMBRE DE LA HOJA
            $objPHPExcel->setActiveSheetIndex($sheet)->setTitle(''.($sheet-1).'');
            

            //CONTENIDO DE LA TABLA (ESTADO DE FALLAS)
            $cols_asrray = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
                                 'R','S','T','U','V','W','X','Y','Z');
            
            $header = Array('Cabina','Falla','Locutorio(s)','Destino','Observaciones','Estatus','Fecha Apertura','Fecha Cierre','Tiempo de Vida');
            
            $sql="SELECT * FROM novedad WHERE Fecha = '$day' ORDER BY Fecha DESC, STATUS_ID ASC";
            $model = Novedad::model()->findAllBySql($sql);
            
            if($model!=NULL)
            {
                for($i=0;$i<9;$i++){
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[$i].'3', $header[$i]);
                    $objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension($cols_asrray[$i])->setAutoSize(true);
                    self::cellColor($cols_asrray[$i].'3', '1967B2',$objPHPExcel);
                    self::borderColor($cols_asrray[$i].'3','E9E0E0',$objPHPExcel);
                    self::font($cols_asrray[$i].'3','FFFFFF','10',$objPHPExcel);
                }

                foreach ($model as $key => $registro)
                {
                    if($registro->STATUS_Id == 2){
                        $timeTicket = Utility::getTime($registro->Fecha, $registro->Hora, $registro->FechaCierre, $registro->HoraCierre);
                    }else{
                        $timeTicket = Utility::getTime($registro->Fecha, $registro->Hora, date('Y-m-d',time()), date('H:i:s',time()));
                    }
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[0].($key+4), Cabina::getNombreCabina($registro->users->CABINA_Id));
                    self::font($cols_asrray[0].($key+4),'000000','10',$objPHPExcel);
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[1].($key+4), $registro->tIPONOVEDAD->Nombre);
                    self::font($cols_asrray[1].($key+4),'000000','10',$objPHPExcel);
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[2].($key+4), NovedadLocutorio::getLocutorioRow($registro->Id));
                    self::font($cols_asrray[2].($key+4),'000000','10',$objPHPExcel);
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[3].($key+4), DestinationInt::getNombre($registro->DESTINO_Id));
                    self::font($cols_asrray[3].($key+4),'000000','10',$objPHPExcel);
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[4].($key+4), $registro->Observaciones);
                    self::font($cols_asrray[4].($key+4),'000000','10',$objPHPExcel);
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[5].($key+4), Novedad::getStatus($registro->STATUS_Id));
                    self::font($cols_asrray[5].($key+4),'000000','10',$objPHPExcel);
                    
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[6].($key+4), $registro->Fecha.'/'.date('H:i',strtotime($registro->Hora)));
                    self::font($cols_asrray[6].($key+4),'000000','10',$objPHPExcel);
                    
                    if($registro->STATUS_Id == 2){
                        $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[7].($key+4), $registro->FechaCierre.'/'.Utility::timeNull($registro->HoraCierre));
                        self::font($cols_asrray[7].($key+4),'000000','10',$objPHPExcel);
                        
                        $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[8].($key+4), Utility::restarHoras($registro->Hora, $registro->HoraCierre, floor($timeTicket/(60*60*24))));
                        self::font($cols_asrray[8].($key+4),'000000','10',$objPHPExcel);
                        
                    }else{
                        $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[7].($key+4), '');
                        self::font($cols_asrray[7].($key+4),'000000','10',$objPHPExcel);
                        
                        $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[8].($key+4), Utility::restarHoras($registro->Hora, date('H:i:s',time()), floor($timeTicket/(60*60*24))));
                        self::font($cols_asrray[8].($key+4),'000000','10',$objPHPExcel);
                    }    
                    
                    
                }

            }
            else
            {
                for($i=0;$i<9;$i++){
                    $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($cols_asrray[$i].'3', $header[$i]);
                    $objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension($cols_asrray[$i])->setAutoSize(true);
                    self::cellColor($cols_asrray[$i].'3', '1967B2',$objPHPExcel);
                    self::borderColor($cols_asrray[$i].'3','E9E0E0',$objPHPExcel);
                    self::font($cols_asrray[$i].'3','FFFFFF','10',$objPHPExcel);
                }
                
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A5', 'No se Reportaron Fallas por el Sistema SINCA para esta Fecha');
                self::font('A5','000000','12',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A5:G5');
            }

    }
    
}
?>