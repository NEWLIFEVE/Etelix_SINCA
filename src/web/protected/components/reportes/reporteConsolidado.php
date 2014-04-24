<?php

class reporteConsolidado extends Reportes 
{
     public static function reporte($day,$name) 
     {

            $objPHPExcel = new PHPExcel();

            $objPHPExcel->
                    getProperties()
                            ->setCreator("SINCA")
                            ->setLastModifiedBy("SINCA")
                            ->setTitle($name)
                            ->setSubject($name)
                            ->setDescription("Reportes Consolidados de Fallas")
                            ->setKeywords("SINCA Reportes Consolidado Falla")
                            ->setCategory($name);


//------------------------------------------------------------------------------------PRIMERA HOJA (MATRIZ DE FALLAS POR SEMANA)
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
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[$i])->setWidth(15);
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

//------------------------------------------------------------------------------------SEGUNDA HOJA (MATRIZ DE FALLAS POR DIA)
            
            //TITULO
            $objPHPExcel->createSheet(1)->setCellValue('A1', 'SINCA Matriz General de Fallas '.$day);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle("A1")->getFont()->setSize(16);
            
            $cols_asrray = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
                                 'R','S','T','U','V','W','X','Y','Z');

            //ANCHO DE CELDAS
            $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(30);
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
            foreach ($novedades as $key => $value) {
                $novedadess[$key] = $value->TipoNovedad;               
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.($key+4), $novedadess[$key]);
                self::cellColor('A'.($key+4), '1967B2',$objPHPExcel);
                self::borderColor('A'.($key+4),'E9E0E0',$objPHPExcel);
                self::font('A'.($key+4),'FFFFFF','10',$objPHPExcel);
            }
            
            
            
            
            
            
            
//----------------------------------------IMPRIMIENDO LOS RESULTADOS
            
            //TITULOS DE LAS HOJAS
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('Total Cabinas');
            $objPHPExcel->setActiveSheetIndex(1)->setTitle('Fallas por Locutorio');
            
            //HOJA A MOSTRAR POR DEFECTO
            $objPHPExcel->setActiveSheetIndex(1);
            
            //MECANISMO QUE GENERA EL EXCEL
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename='{$name}.xlsx'");
            header("Cache-Control: max-age=0");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;

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
    
    public static function font($cells,$color,$size,$objPHPExcel){
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => $color),
                'size'  => $size,
                'name'  => 'Calibri'
        ));
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
    }
    
}
?>