<?php

class estadoResultado extends Reportes 
{
     public static function reporte($day,$name,$dir) 
     {

            $objPHPExcel = new PHPExcel();
            $sheet = new estadoResultado(); 

            $objPHPExcel->
                    getProperties()
                            ->setCreator("SINCA")
                            ->setLastModifiedBy("SINCA")
                            ->setTitle($name)
                            ->setSubject($name)
                            ->setDescription("Estado Resultados Cabinas")
                            ->setKeywords("SINCA Estado Resultados Cabinas")
                            ->setCategory($name);


            //PRIMERA HOJA (MATRIZ GENERAL DE FALLAS POR DIA)
            $sheet->_genSheetOne($objPHPExcel,$day); 

            
            //IMPRIMIENDO LOS RESULTADOS
            
            //TITULOS DE LAS HOJAS
            $mes = Utility::monthName($day.'-01');
            $año = date("Y", strtotime($day.'-01')); 
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('ER Cabinas '.$mes.' '.$año);

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
    
    //ASIGNA COLOR AL LADO DEL BORDE DE UNA CELDA ESPECIFICADA
    public static function borderSiteColor($cells,$color,$site,$objPHPExcel){
        $styleArray = array('font' => array('italic' => true, 'bold'=> true,    ),
            'borders' => array(
                $site => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => $color)),
        ),);
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
    
    //ASIGNA LOS VALORES DE COLOR Y TAMAÑO A LA CELDA ESPECIFICADA
    public static function fontSite($cells,$color,$size,$align,$objPHPExcel){
        
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => $color),
                'size'  => $size,
                'name'  => 'Calibri'
        ));
        
        if($align == 'center')
            $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        if($align == 'left')
            $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        if($align == 'right')
            $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    }
    

    //GENERA LA 2DA HOJA DEL REPORTE (MATRIZ GENERAL POR DIA)
    private function _genSheetOne($objPHPExcel,$day){
        
            $mes = Utility::monthName($day.'-01');
        
            //TITULO
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'SINCA Estado de Resultados Cabinas Peru');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $mes);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1")->getFont()->setSize(16);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle("A2")->getFont()->setSize(16);
            
            self::borderColor('A1','FFFFFF',$objPHPExcel);
            self::borderColor('A2','FFFFFF',$objPHPExcel);
            self::borderColor('A3','FFFFFF',$objPHPExcel);


            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(70);
            
            $cols_asrray = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
                                 'R','S','T','U','V','W','X','Y','Z');
            
            
            $nombreCabinas = Cabina::model()->findAllBySql("SELECT Id, Nombre FROM cabina WHERE status = 1 AND Id !=18 AND Id != 19 ORDER BY Nombre;");
            
            $paridad = Paridad::model()->findBySql("SELECT Valor FROM paridad ORDER BY Fecha DESC LIMIT 1;");
            $i = 1;
            
            //SCROLL ESTATICO VERTICAL
            $objPHPExcel->getActiveSheet()->freezePane('A1');
            $objPHPExcel->getActiveSheet()->freezePane('B1');
            
            //SCROLL ESTATICO HORIZONTAL
            $objPHPExcel->getActiveSheet()->freezePane('B4');
            
            //ENCABEZADO DE CABINAS
            foreach ($nombreCabinas as $key => $value){
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'1', $value->Nombre);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle($cols_asrray[$i].'1')->getFont()->setSize(16);
                
                
                
                self::font($cols_asrray[$i].'1','000000','14',$objPHPExcel);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($cols_asrray[$i].'1:'.$cols_asrray[($i+1)].'3');
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'5', $paridad->Valor);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'7', 'Soles');
                self::font($cols_asrray[$i].'7','000000','10',$objPHPExcel);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'7', '$');
                self::font($cols_asrray[($i+1)].'7','000000','10',$objPHPExcel);
                
                
                self::borderColor($cols_asrray[$i].'1','000000',$objPHPExcel);
                self::borderColor($cols_asrray[$i].'2','000000',$objPHPExcel);
                self::borderColor($cols_asrray[$i].'3','000000',$objPHPExcel);
                
                
                for($j=4;$j<100;$j++){
                    self::borderColor('A'.$j,'FFFFFF',$objPHPExcel);
                    self::borderColor($cols_asrray[$i].$j,'FFFFFF',$objPHPExcel);
                    self::borderColor($cols_asrray[($i+1)].$j,'FFFFFF',$objPHPExcel);
                    self::borderSiteColor($cols_asrray[($i+1)].$j,'000000','right',$objPHPExcel);
                }
                
                

                
                $i = $i + 2;
                
            }
            
            //COLUMNA DE GRAN TOTALES
//            $cellGranTotales = (count($nombreCabinas)*2)+1;
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'1', 'GRAN TOTAL');
//            $objPHPExcel->setActiveSheetIndex(0)->getStyle($cols_asrray[$cellGranTotales].'1')->getFont()->setSize(16);
//            self::font($cols_asrray[$cellGranTotales].'1','000000','14',$objPHPExcel);
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($cols_asrray[$cellGranTotales].'1:'.$cols_asrray[($cellGranTotales+1)].'3');
            
            //VALORES
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Paridad Cambiaria');
            self::fontSite('A5','000000','10','left',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', 'INGRESOS');
            self::font('A7','000000','10',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', 'Ingresos Llamadas');
            self::fontSite('A8','000000','10','left',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9', 'Ingresos Servicios Movistar');
            self::fontSite('A9','000000','10','left',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', 'Ingresos Servicios Claro');
            self::fontSite('A10','000000','10','left',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A11', 'Ingresos Servicios DirecTv');
            self::fontSite('A11','000000','10','left',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A12', 'Ingresos Servicios Nextel');
            self::fontSite('A12','000000','10','left',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A13', 'Ingresos Varios');
            self::fontSite('A13','000000','10','left',$objPHPExcel);
            
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A14', 'Sub Total');
            self::fontSite('A14','000000','11','right',$objPHPExcel);


            
    }
    
}
?>