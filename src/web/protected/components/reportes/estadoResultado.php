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


            //PRIMERA HOJA (ESTADO DE RESULTADOS)
            $sheet->_genSheetOne($objPHPExcel,$day); 

            
            //IMPRIMIENDO LOS RESULTADOS
            
            //TITULOS DE LAS HOJAS
            $mes = Utility::monthName($day.'-01');
            $año = date("Y", strtotime($day.'-01')); 
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('EEFF CABINAS');

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
        'startcolor' => array('rgb' => $color),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),'rgb' => $color)
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
    
    //ASIGNA COLOR AL BORDE DE UNA CELDA ESPECIFICADA
    public static function borderColorNone($cells,$color,$objPHPExcel){

        $styleArray = array(
               'borders' => array(
                     'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_NONE,
                            'color' => array('rgb' => $color),
                     ),
               ),
        );
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
    }
    
    //ASIGNA COLOR AL LADO DEL BORDE DE UNA CELDA ESPECIFICADA
    public static function borderSiteColor($cells,$color,$site,$objPHPExcel){
        $styleArray = array('font' => array('italic' => false, 'bold'=> true,    ),
            'borders' => array(
                $site => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => $color)),
        ),);
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
    }
    
    //ASIGNA LOS VALORES DE COLOR Y TAMAÑO A LA CELDA ESPECIFICADA
    public static function font($cells,$color,$size,$objPHPExcel){
        $styleArray = array(
            'font'  => array(
                'bold'   => true,
                'italic' => false,
                'strike' => false,
                'color'  => array('rgb' => $color),
                'size'   => $size,
                'name'   => 'Calibri'
        ));
        
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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
    
    //ASIGNAR MONEDA A CELDA
    public static function setCurrency($cells,$currency,$objPHPExcel) {
        
        if($currency == 'USD$'){
            $objPHPExcel->getActiveSheet()->getStyle($cells)->getNumberFormat()->setFormatCode('$#,##0.00;[Red]($#,##0.00)');
        }
        
    }


    //DATA DE LOS SERVICIOS DE  FULLCARGA
    public static function getDataFullCarga($fecha,$cabina,$compania){
        
        if($compania == 'SubArriendos'){
            
            $sql="SELECT SUM(d.Monto) as Monto
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id = 1 AND t.Clase = 1;";
            
        }elseif($compania != 'SubArriendos'){
            
            $sql="SELECT SUM(d.Monto) as Monto
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.COMPANIA_Id = $compania AND t.Clase = 1;";
            
        }
        

        $servicios = Detalleingreso::model()->findBySql($sql);
        
        if($servicios == NULL){
            
            return '0,00';
            
        }else{
            
            if($servicios->Monto == NULL){
                return '0,00';
            }else{
                return  $servicios->Monto;
            }
            
        }

    }
    
    //DATA DE LOS EGRESOS
    public static function getDataEgresos($fecha,$cabina,$paridad,$egreso){
        
        $montoAcomulado = 0;
        
        if($egreso == 'Generales'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id IN(1,6,14,29);";
        }elseif($egreso == 'Otros'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id IN(5,24,33,34,61);";
        }elseif($egreso != 'Generales'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id = $egreso;";
        }

        $gasto = Detallegasto::model()->findAllBySql($sql);
        
        if($gasto == NULL){
            
            return 0.00;
            
        }else{
            
            foreach ($gasto as $key => $value) {
                
                if($value->moneda == 1){
                    $montoAcomulado = $montoAcomulado + ($value->Monto);
                }elseif($value->moneda == 2){
                    $montoAcomulado = $montoAcomulado + ($value->Monto/$paridad);
                }
                
            }
            
            if($montoAcomulado == NULL || $montoAcomulado == 0){
                return 0.00;
            }else{
                return $montoAcomulado;
            }
            
        }

    }
    
    //DATA DE LOS IMPUESTOS
    public static function getDataImpuestos($fecha,$cabina,$paridad,$egreso){
        
        $montoAcomulado = 0;
        
        if($egreso == 'Arbitiros'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id IN(7);";
        }elseif($egreso == 'Sunat'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id IN(54);";
        }elseif($egreso == 'Otros'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Id IN(41);";
        }

        $gasto = Detallegasto::model()->findAllBySql($sql);
        
        if($gasto == NULL){
            
            return 0.00;
            
        }else{
            
            foreach ($gasto as $key => $value) {
                
                if($value->moneda == 1){
                    $montoAcomulado = $montoAcomulado + ($value->Monto);
                }elseif($value->moneda == 2){
                    $montoAcomulado = $montoAcomulado + ($value->Monto/$paridad);
                }
                
            }
            
            if($montoAcomulado == NULL || $montoAcomulado == 0){
                return 0.00;
            }else{
                return $montoAcomulado;
            }
            
        }

    }
    

    //GENERA LA 2DA HOJA DEL REPORTE (MATRIZ GENERAL POR DIA)
    private function _genSheetOne($objPHPExcel,$day){
        
            $mes = Utility::monthName($day.'-01');
        
            //TITULO
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'EEFF CABINAS');
            self::font('A1','FFFFFF','16',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $mes);
            self::font('A2','FFFFFF','16',$objPHPExcel);
            
            self::borderColor('A1','ff9900',$objPHPExcel);
            self::borderColor('A2','ff9900',$objPHPExcel);
            self::cellColor('A1', 'ff9900',$objPHPExcel);
            self::cellColor('A2', 'ff9900',$objPHPExcel);


            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            
            //QUITA EL ESPACIO EN BLANCO
            $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(0);   
            $objPHPExcel->getActiveSheet()->getRowDimension('20')->setRowHeight(0);   
            $objPHPExcel->getActiveSheet()->getRowDimension('26')->setRowHeight(0);   
            $objPHPExcel->getActiveSheet()->getRowDimension('28')->setRowHeight(0);   
            $objPHPExcel->getActiveSheet()->getRowDimension('37')->setRowHeight(0);  
            $objPHPExcel->getActiveSheet()->getRowDimension('39')->setRowHeight(0);  
            $objPHPExcel->getActiveSheet()->getRowDimension('41')->setRowHeight(0);  
            
            
            $cols_asrray = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
                                 'R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH',
                                 'AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW',
                                 'AX','AY','AZ');
            
            $arrayFechas = Array('-01','-02','-03','-04','-05','-06','-07','-08','-09','-10','-11','-12','-13',
                                 '-14','-15','-16','-17','-18','-19','-20',
                                 '-21','-22','-23','-24','-25','-26','-27','-28','-29','-30','-31');
            
            
            $nombreCabinas = Cabina::model()->findAllBySql("SELECT Id, Nombre FROM cabina WHERE status = 1 AND Id !=18 AND Id != 19 ORDER BY Nombre;");
            $cellGranTotales = (count($nombreCabinas)*2)+1;
            
            $paridad = Paridad::model()->findBySql("SELECT Valor FROM paridad WHERE Fecha <= '$day-31' ORDER BY Fecha DESC LIMIT 1;")->Valor;
            
            
            
            $i = 1;
            $traficoSoles = 0;
            $traficoDollar = 0;
            $traficoTotal = 0;
            $traficoTotalDollar = 0;
            
            $servMov = 0;
            $servClaro = 0;
            $servDirecTv = 0;
            $servNextel = 0;
            $otrosServ = 0;
            $ventas = 0;
            $subArriendo = 0;
            
            $servMovTotal = 0;
            $servClaroTotal = 0;
            $servDirecTvTotal = 0;
            $servNextelTotal = 0;
            $otrosServTotal = 0;
            $ventasTotal = 0;
            
            $alquiler = 0;
            $nomina = 0;
            $servGenerales = 0;
            $otrosGastos = 0;

            $totalGastos = 0;
            
            
            $sunat = 0;
            $arbitrios = 0;
            $otrosImpuestos = 0;
                
            $totalImpuestos = 0;

            
            //SCROLL ESTATICO VERTICAL
            $objPHPExcel->getActiveSheet()->freezePane('A1');
            $objPHPExcel->getActiveSheet()->freezePane('B1');
            
            //SCROLL ESTATICO HORIZONTAL
            $objPHPExcel->getActiveSheet()->freezePane('B3');
            
            //ENCABEZADO DE CABINAS
            foreach ($nombreCabinas as $key => $value){
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'1', $value->Nombre);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle($cols_asrray[$i].'1')->getFont()->setSize(16);
                self::cellColor($cols_asrray[$i].'1', 'ff9900',$objPHPExcel);
                
                
                
                self::font($cols_asrray[$i].'1','FFFFFF','14',$objPHPExcel);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($cols_asrray[$i].'1:'.$cols_asrray[($i+1)].'2');

                //VALORES DEL CONTENIDO (INGRESOS)
                $trafico = self::getDataFullCarga($day,$value->Id,5);
                $traficoSoles = $trafico;
                $traficoTotal = $traficoTotal + $trafico;
                $traficoDollar = round(($traficoSoles/$paridad),2);
                $traficoTotalDollar = $traficoTotalDollar + round(($trafico/$paridad),2);
                
                $servMov = self::getDataFullCarga($day,$value->Id,1);
                $servClaro = self::getDataFullCarga($day,$value->Id,2);
                $servDirecTv = self::getDataFullCarga($day,$value->Id,4);
                $servNextel = self::getDataFullCarga($day,$value->Id,3);
                $subArriendo = self::getDataFullCarga($day,$value->Id,'SubArriendos');

                $servMovDollar = round(($servMov/$paridad),2);
                $servClaroDollar = round(($servClaro/$paridad),2);
                $servDirecTvDollar = round(($servDirecTv/$paridad),2);
                $servNextelDollar = round(($servNextel/$paridad),2);
                $subArriendoDollar = round(($subArriendo/$paridad),2);

                $servMovTotal = $servMovTotal + $servMov;
                $servClaroTotal = $servClaroTotal + $servClaro;
                $servDirecTvTotal = $servDirecTvTotal + $servDirecTv;
                $servNextelTotal = $servNextelTotal + $servNextel;

                $ventas = round(($servMovDollar + $servClaroDollar + $servDirecTvDollar + $servNextelDollar),2);
                $ingresosTotal = ($traficoDollar+$ventas+$subArriendoDollar);
                
                //VALORES DEL CONTENIDO (EGRESOS)
                $alquiler = self::getDataEgresos($day, $value->Id, $paridad, 39);
                $nomina = self::getDataEgresos($day, $value->Id, $paridad, 75);
                $servGenerales = self::getDataEgresos($day, $value->Id, $paridad, 'Generales');
                $otrosGastos = self::getDataEgresos($day, $value->Id, $paridad, 'Otros');
                
                $totalGastos = $alquiler+$nomina+$servGenerales+$otrosGastos;
                
                //VALORES DEL CONTENIDO (IMPUESTOS)
                $sunat = self::getDataImpuestos($day, $value->Id, $paridad, 'Sunat');
                $arbitrios = self::getDataImpuestos($day, $value->Id, $paridad, 'Arbitiros');
                $otrosImpuestos = self::getDataImpuestos($day, $value->Id, $paridad, 'Otros');
                
                $totalImpuestos = $sunat+$arbitrios+$otrosImpuestos+($traficoDollar*0.5/100)+($traficoDollar*0.5/100)+($traficoDollar*1/100)+($ingresosTotal*1.5/100);
                
                
                //TOTAL DE LLAMADAS EN SOLES POR CABINA
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'4', '');
                self::fontSite($cols_asrray[$i].'4','000000','10','right',$objPHPExcel);
                
                //TOTAL DE LLAMADAS EN DOLARES POR CABINA
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'4', $traficoDollar);
                self::fontSite($cols_asrray[($i+1)].'4','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'4','USD$',$objPHPExcel);
                
                //TOTAL DE VENTAS EN LOS SERVICIOS 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'5', $ventas);
                self::fontSite($cols_asrray[($i+1)].'5','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'5','USD$',$objPHPExcel);
                
                //TOTAL DE SERVICIOS NEXTEL  EN DOLARES
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'10', $subArriendoDollar);
                self::fontSite($cols_asrray[($i+1)].'10','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'10','USD$',$objPHPExcel);
                
                
                
                
                

                //TOTAL DE SERVICIOS MOVISTAR  EN DOLARES
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'6', $servMovDollar);
                self::fontSite($cols_asrray[$i].'6','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'6','USD$',$objPHPExcel);

                //TOTAL DE SERVICIOS CLARO  EN DOLARES
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'7', $servClaroDollar);
                self::fontSite($cols_asrray[$i].'7','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'7','USD$',$objPHPExcel);
                
                //TOTAL DE SERVICIOS DIRECTV  EN DOLARES
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'8', $servDirecTvDollar);
                self::fontSite($cols_asrray[$i].'8','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'8','USD$',$objPHPExcel);
                
                //TOTAL DE SERVICIOS NEXTEL  EN DOLARES
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'9', $servNextelDollar);
                self::fontSite($cols_asrray[$i].'9','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'9','USD$',$objPHPExcel);
                
                //TOTAL DE INGRESOS
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'3', $ingresosTotal);
                self::fontSite($cols_asrray[($i+1)].'3','000000','11','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'3','USD$',$objPHPExcel);
                
                
                //EGRESOS
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'21', $totalGastos);
                self::fontSite($cols_asrray[($i+1)].'21','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'21','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'22', $alquiler);
                self::fontSite($cols_asrray[($i+1)].'22','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'22','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'23', $nomina);
                self::fontSite($cols_asrray[($i+1)].'23','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'23','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'24', $servGenerales);
                self::fontSite($cols_asrray[($i+1)].'24','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'24','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'25', $otrosGastos);
                self::fontSite($cols_asrray[($i+1)].'25','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'25','USD$',$objPHPExcel);
                
                //MARGEN
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'19', $subArriendoDollar);
                self::fontSite($cols_asrray[($i+1)].'19','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'19','USD$',$objPHPExcel);
                
                
                //IMPUESTOS
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'29', $totalImpuestos);
                self::fontSite($cols_asrray[($i+1)].'29','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'29','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'30', ($traficoDollar*0.5/100));
                self::fontSite($cols_asrray[($i+1)].'30','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'30','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'31', ($traficoDollar*1/100));
                self::fontSite($cols_asrray[($i+1)].'31','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'31','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'32', ($traficoDollar*0.5/100));
                self::fontSite($cols_asrray[($i+1)].'32','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'32','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'33', $sunat);
                self::fontSite($cols_asrray[($i+1)].'33','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'33','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'34', ($ingresosTotal*1.5/100));
                self::fontSite($cols_asrray[($i+1)].'34','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'34','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'35', $arbitrios);
                self::fontSite($cols_asrray[($i+1)].'35','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'35','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'36', $otrosImpuestos);
                self::fontSite($cols_asrray[($i+1)].'36','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'36','USD$',$objPHPExcel);
                
                
                //CONFIGURACION DEL ESTILO
                self::borderColor($cols_asrray[$i].'1','000000',$objPHPExcel);
                self::borderColor($cols_asrray[$i].'2','000000',$objPHPExcel);
                
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[$i])->setWidth(13);
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[($i+1)])->setWidth(13);
                
                //TITULOS EN GRIS
                self::cellColor($cols_asrray[$i].'3', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'3', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'12', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'12', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'21', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'21', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'27', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'27', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'29', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'29', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'38', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'38', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'40', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'40', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[$i].'42', 'AAAAAA',$objPHPExcel);
                self::cellColor($cols_asrray[($i+1)].'42', 'AAAAAA',$objPHPExcel);
                
                for($j=1;$j<43;$j++){
                    self::borderColor('A'.$j,'FFFFFF',$objPHPExcel);
                    self::borderColor($cols_asrray[$i].$j,'FFFFFF',$objPHPExcel);
                    self::borderColor($cols_asrray[($i+1)].$j,'FFFFFF',$objPHPExcel);
                    
                    if($j == 3 || $j == 12 || $j == 21 || $j == 27 || $j == 29 || $j == 38 || $j == 40 || $j == 42){
                        self::borderSiteColor($cols_asrray[$i].$j,'AAAAAA','right',$objPHPExcel);
                        self::borderSiteColor($cols_asrray[$i].$j,'000000','left',$objPHPExcel);
                        self::borderSiteColor($cols_asrray[($i+1)].$j,'000000','right',$objPHPExcel);
                    }else{
                        self::borderSiteColor($cols_asrray[($i+1)].$j,'000000','right',$objPHPExcel);
                    }    
                }
                
                

                
                $i = $i + 2;
                
            }
            
            //COLUMNA DE GRAN TOTALES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'1', 'GRAN TOTAL');
//            $objPHPExcel->setActiveSheetIndex(0)->getStyle($cols_asrray[$cellGranTotales].'1')->getFont()->setSize(16);
//            self::font($cols_asrray[$cellGranTotales].'1','000000','14',$objPHPExcel);
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($cols_asrray[$cellGranTotales].'1:'.$cols_asrray[($cellGranTotales+1)].'2');
//            
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'5', $paridad);
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'7', 'Soles');
//            self::font($cols_asrray[$cellGranTotales].'7','000000','10',$objPHPExcel);
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'7', '$');
//            self::font($cols_asrray[($cellGranTotales+1)].'7','000000','10',$objPHPExcel);
//            
//            $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[$cellGranTotales])->setWidth(15);
//            $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[($cellGranTotales+1)])->setWidth(15);
//            
//            
//            
//            
//            
//            //BORDES DEL HEADER - GRAN TOTAL
//            for($i=1;$i<4;$i++){
//                self::borderColor($cols_asrray[$cellGranTotales].$i,'000000',$objPHPExcel);
//                self::borderSiteColor($cols_asrray[($cellGranTotales+1)].$i,'000000','right',$objPHPExcel);
//            }
//            
//            //BORDES DE LA CELDA COMPLETA - GRAN TOTAL
//            for($j=4;$j<70;$j++){
//                self::borderColor($cols_asrray[$cellGranTotales].$j,'FFFFFF',$objPHPExcel);
//                self::borderColor($cols_asrray[($cellGranTotales+1)].$j,'FFFFFF',$objPHPExcel);
//                self::borderSiteColor($cols_asrray[($cellGranTotales+1)].$j,'000000','right',$objPHPExcel);
//            }
//            
//            //TOTAL DE LLAMADAS EN SOLES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'8', 'S/. '.str_replace('.',',',(round($traficoTotal,2))));
//            self::fontSite($cols_asrray[$cellGranTotales].'8','000000','10','right',$objPHPExcel);
//            self::cellColor($cols_asrray[$cellGranTotales].'8', 'AAAAAA',$objPHPExcel);
//
//            //TOTAL DE LLAMADAS EN DOLARES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'8', '$ '.str_replace('.',',',(round($traficoTotalDollar,2))));
//            self::fontSite($cols_asrray[($cellGranTotales+1)].'8','000000','10','right',$objPHPExcel);
//            
//            
//            //TOTAL DE SERVICIOS MOVISTAR EN SOLES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'9', 'S/. '.$servMovTotal);
//            self::fontSite($cols_asrray[$cellGranTotales].'9','000000','10','right',$objPHPExcel);
//            //TOTAL DE SERVICIOS MOVISTAR  EN DOLARES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'9', '$ '.round(($servMovTotal/$paridad),2));
//            self::fontSite($cols_asrray[($cellGranTotales+1)].'9','000000','10','right',$objPHPExcel);
//
//            //TOTAL DE SERVICIOS CLARO EN SOLES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'10', 'S/. '.$servClaroTotal);
//            self::fontSite($cols_asrray[$cellGranTotales].'10','000000','10','right',$objPHPExcel);
//            //TOTAL DE SERVICIOS CLARO  EN DOLARES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'10', '$ '.round(($servClaroTotal/$paridad),2));
//            self::fontSite($cols_asrray[($cellGranTotales+1)].'10','000000','10','right',$objPHPExcel);
//
//            //TOTAL DE SERVICIOS DIRECTV EN SOLES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'11', 'S/. '.$servDirecTvTotal);
//            self::fontSite($cols_asrray[$cellGranTotales].'11','000000','10','right',$objPHPExcel);
//            //TOTAL DE SERVICIOS DIRECTV  EN DOLARES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'11', '$ '.round(($servDirecTvTotal/$paridad),2));
//            self::fontSite($cols_asrray[($cellGranTotales+1)].'11','000000','10','right',$objPHPExcel);
//
//            //TOTAL DE SERVICIOS NEXTEL EN SOLES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'12', 'S/. '.$servNextelTotal);
//            self::fontSite($cols_asrray[$cellGranTotales].'12','000000','10','right',$objPHPExcel);
//            //TOTAL DE SERVICIOS NEXTEL  EN DOLARES
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'12', '$ '.round(($servNextelTotal/$paridad),2));
//            self::fontSite($cols_asrray[($cellGranTotales+1)].'12','000000','10','right',$objPHPExcel);
//            
//            
//            
//            
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Paridad Cambiaria');
//            self::fontSite('A5','000000','10','left',$objPHPExcel);
//            
            //VALORES DE LA CELDA DE TITULOS (CELDA A)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'INGRESOS');
            $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);      
            self::fontSite('A3','000000','11','right',$objPHPExcel);
            self::cellColor('A3', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A12', 'MARGEN OPERATIVO BRUTO');
            $objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);      
            self::fontSite('A12','000000','11','right',$objPHPExcel);
            self::cellColor('A12', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A21', 'EGRESOS');
            $objPHPExcel->getActiveSheet()->getRowDimension('21')->setRowHeight(20);      
            self::fontSite('A21','000000','11','right',$objPHPExcel);
            self::cellColor('A21', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A27', 'TOTAL EBITDA');
            $objPHPExcel->getActiveSheet()->getRowDimension('27')->setRowHeight(20);      
            self::fontSite('A27','000000','11','right',$objPHPExcel);
            self::cellColor('A27', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A29', 'IMPUESTOS (Alicuota sobre las ventas)');
            $objPHPExcel->getActiveSheet()->getRowDimension('29')->setRowHeight(20);      
            self::fontSite('A29','000000','11','right',$objPHPExcel);
            self::cellColor('A29', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A38', 'Ganancia Neta (Sin Merma Ciclo de Ingreso)');
            $objPHPExcel->getActiveSheet()->getRowDimension('38')->setRowHeight(20);      
            self::fontSite('A38','000000','11','right',$objPHPExcel);
            self::cellColor('A38', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A40', 'AJUSTE POR CICLO DE INGRESOS');
            $objPHPExcel->getActiveSheet()->getRowDimension('40')->setRowHeight(20);      
            self::fontSite('A40','000000','11','right',$objPHPExcel);
            self::cellColor('A40', 'AAAAAA',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A42', 'GANANCIA TOTAL NETA');
            $objPHPExcel->getActiveSheet()->getRowDimension('42')->setRowHeight(20);      
            self::fontSite('A42','000000','11','right',$objPHPExcel);
            self::cellColor('A42', 'AAAAAA',$objPHPExcel);
            
            //INGRESOS
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Ingresos Llamadas');
            self::fontSite('A4','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A4', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Ingresos Por Servicios');
            self::fontSite('A5','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A5', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Ingresos Servicios Movistar');
            self::fontSite('A6','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A6', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', 'Ingresos Servicios Claro');
            self::fontSite('A7','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A7', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', 'Ingresos Servicios DirecTv');
            self::fontSite('A8','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A8', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9', 'Ingresos Servicios Nextel');
            self::fontSite('A9','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A9', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', 'Ingresos Varios (Subarriendos)');
            self::fontSite('A10','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A10', '1967B2',$objPHPExcel);
            
            //MARGEN OPERATIVO BRUTO
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A13', 'Ingresos Llamadas');
            self::fontSite('A13','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A13', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A14', 'Ingresos Por Servicios');
            self::fontSite('A14','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A14', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A15', 'Ingresos Servicios Movistar');
            self::fontSite('A15','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A15', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A16', 'Ingresos Servicios Claro');
            self::fontSite('A16','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A16', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A17', 'Ingresos Servicios DirecTv');
            self::fontSite('A17','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A17', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A18', 'Ingresos Servicios Nextel');
            self::fontSite('A18','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A18', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A19', 'Ingresos Varios (Subarriendos)');
            self::fontSite('A19','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A19', '1967B2',$objPHPExcel);
            
            //EGRESOS 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A22', 'Alquiler Local');
            self::fontSite('A22','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A22', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A23', 'Nomina');
            self::fontSite('A23','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A23', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A24', 'Servicios Generales');
            self::fontSite('A24','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A24', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A25', 'Otros Gastos (Rep, Mto., Reemplazo Eq.)');
            self::fontSite('A25','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A25', '1967B2',$objPHPExcel);
            
            //IMPUESTOS (Alicuota sobre las ventas)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A30', 'Osiptel (0.5% de las Vts Llamadas)');
            self::fontSite('A30','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A30', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A31', 'Fitel (1% de las Vts Llamadas)');
            self::fontSite('A31','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A31', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A32', 'MTC (0.5% de las Vts Llamadas)');
            self::fontSite('A32','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A32', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A33', 'Sunat (IGV)');
            self::fontSite('A33','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A33', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A34', 'Sunat (Renta 3era) (1.5% de las Vtas TOTALES)');
            self::fontSite('A34','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A34', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A35', 'Arbitrios');
            self::fontSite('A35','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A35', '1967B2',$objPHPExcel);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A36', 'Otros Impuestos');
            self::fontSite('A36','FFFFFF','10','left',$objPHPExcel);
            self::cellColor('A36', '1967B2',$objPHPExcel);
            
            
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A15', 'Sub Total');
//            self::fontSite('A15','000000','11','right',$objPHPExcel);


            
    }
    
}
?>