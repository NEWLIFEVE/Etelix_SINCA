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
                $objWriter->setPreCalculateFormulas(true);
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
                  AND t.Nombre = 'Subarriendo';";
            
        }elseif($compania == 'TraficoCaptura'){
            
            $sql="SELECT SUM(d.Monto) as Monto
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Nombre = 'TraficoCapturaDollar';";
            
        }elseif($compania != 'SubArriendos' && $compania != 'TraficoCaptura'){
            
            $sql="SELECT SUM(d.Monto) as Monto
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.COMPANIA_Id = $compania AND u.tipo = 4;";
            
        }
        

        $servicios = Detalleingreso::model()->findBySql($sql);
        
        if($servicios == NULL){
            
            return 0.00;
            
        }else{
            
            if($servicios->Monto == NULL){
                return 0.00;
            }else{
                return  $servicios->Monto;
            }
            
        }

    }
    
    //DATA DE LOS COSTOS Y LAS COMISIONES DE FULLCARGA
    public static function getDataComisionFullCarga($fecha,$cabina,$compania){
        
        if($compania == 'llamadas'){
            
            $sql="SELECT SUM(d.Costo_Comision) as Monto
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.Nombre = 'TraficoCapturaDollar';";
            
        }elseif($compania != 'llamadas'){
            
            $sql="SELECT SUM(d.Costo_Comision) as Monto
                  FROM detalleingreso as d
                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND t.COMPANIA_Id = $compania AND u.tipo = 4;";
            
        }
        

        $servicios = Detalleingreso::model()->findBySql($sql);
        
        if($servicios == NULL){
            
            return 0.00;
            
        }else{
            
            if($servicios->Monto == NULL){
                return 0.00;
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
                  INNER JOIN category as ca ON ca.id = t.category_id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND d.status IN(2,3)     
                  AND ca.id = 1 AND t.Id != 39;";
        }elseif($egreso == 'Otros'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN category as ca ON ca.id = t.category_id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND d.status IN(2,3)      
                  AND ca.id IN(2,4,5,7,8);";
        }elseif($egreso != 'Generales' || $egreso != 'Otros'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND d.status IN(2,3)      
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
                  AND t.Id IN(12);";
        }elseif($egreso == 'Otros'){
            $sql="SELECT d.Monto as Monto, moneda
                  FROM detallegasto as d
                  INNER JOIN tipogasto as t ON t.Id = d.TIPOGASTO_Id
                  INNER JOIN category as ca ON ca.id = t.category_id
                  INNER JOIN users as u ON u.id = d.USERS_Id
                  WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                  AND d.CABINA_Id = $cabina 
                  AND ca.id IN(6) AND t.Id != 6;";
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
    
    //DATA DE CICLO DE INGRESO
    public static function getDataCicloIngreso($fecha,$cabina,$paridad){
        
        $montoAcomulado = 0;
        
        $año = date("Y", strtotime($fecha));
        $mes = date("m", strtotime($fecha));

        $sql = "SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario,
                SUM(IFNULL(DiferencialMovistar,0)) as DiferencialMovistar,
                SUM(IFNULL(DiferencialClaro,0)) as DiferencialClaro,
                SUM(IFNULL(DiferencialNextel,0)) as DiferencialNextel,
                SUM(IFNULL(DiferencialDirectv,0)) as DiferencialDirectv,
                SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura
                FROM ciclo_ingreso 
                WHERE EXTRACT(YEAR FROM Fecha) = '$año' 
                AND EXTRACT(MONTH FROM Fecha) = '$mes'
                AND CABINA_Id = $cabina;";

        $modelAcum = CicloIngresoModelo::model()->findBySql($sql);
        
        if($modelAcum == NULL){
            $montoAcomulado = 0.00;
        }else{
            $montoAcomulado = round((($modelAcum->DiferencialBancario+$modelAcum->DiferencialMovistar+$modelAcum->DiferencialClaro+$modelAcum->DiferencialNextel+$modelAcum->DiferencialDirectv+($modelAcum->DiferencialCaptura*$paridad))/$paridad),2);
        }
        
        return $montoAcomulado;

    }
    
    //DATA DE SORI - COSTO DE LAS LLAMADAS
    public static function getCostoLlamada($fecha,$cabina)
    {
        
        $arrayCarriers = Array();
        $arrayCa = Array();
        $cabinaNombre = Cabina::getNombreCabina2($cabina);
        

        if($cabinaNombre != 'ETELIX - PERU'){
            $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%$cabinaNombre%';");
        }else{
            $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%ETELIX.COM%';");
        }

        foreach ($cabinasSori as $key2 => $value) {
            $arrayCa[0][$key2] = $value->id;
            $arrayCarriers[0] = implode(',', $arrayCa[0]);
        }

        $model = BalanceSori::model()->findBySql("SELECT SUM(b.cost) as cost
                                                  FROM balance as b
                                                  WHERE b.date_balance >= '$fecha-01' 
                                                  AND b.date_balance <= '$fecha-31'
                                                  AND b.id_carrier_customer IN($arrayCarriers[0])
                                                  AND id_destination is NULL;");

        if($model != NULL){

            if($model->cost != NULL){
                return round($model->cost,2);
            }else{
                return 0.00;
            }    

        }else{
            return 0.00;
        }
            
        
    }
    
    public static function generateTotal($cols_asrray,$cellGranTotales,$objPHPExcel) {
        
            //COLUMNA DE GRAN TOTALES
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$cellGranTotales].'1', 'GRAN TOTAL');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle($cols_asrray[$cellGranTotales].'1')->getFont()->setSize(16);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($cols_asrray[$cellGranTotales].'1:'.$cols_asrray[($cellGranTotales+1)].'2');
            
            
            self::cellColor($cols_asrray[$cellGranTotales].'1', 'ff9900',$objPHPExcel);
            self::font($cols_asrray[$cellGranTotales].'1','FFFFFF','14',$objPHPExcel);
            
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[$cellGranTotales])->setWidth(16);
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[($cellGranTotales+1)])->setWidth(16);
            
     
            //BORDES DEL HEADER - GRAN TOTAL
            for($i=1;$i<3;$i++){
                self::borderColor($cols_asrray[$cellGranTotales].$i,'000000',$objPHPExcel);
                self::borderSiteColor($cols_asrray[($cellGranTotales+1)].$i,'000000','right',$objPHPExcel);
            }
//            
            //BORDES DE LA CELDA COMPLETA - GRAN TOTAL
            for($j=1;$j<43;$j++){
                self::borderColor($cols_asrray[$cellGranTotales].$j,'FFFFFF',$objPHPExcel);
                self::borderColor($cols_asrray[($cellGranTotales+1)].$j,'FFFFFF',$objPHPExcel);
                self::borderSiteColor($cols_asrray[($cellGranTotales+1)].$j,'000000','right',$objPHPExcel);
                
                if($j == 3 || $j == 12 || $j == 21 || $j == 27 || $j == 29 || $j == 38 || $j == 40 || $j == 42){
                    self::cellColor($cols_asrray[$cellGranTotales].$j, 'AAAAAA',$objPHPExcel);
                    self::cellColor($cols_asrray[($cellGranTotales+1)].$j, 'AAAAAA',$objPHPExcel);
                    
                    self::borderSiteColor($cols_asrray[$cellGranTotales].$j,'AAAAAA','right',$objPHPExcel);
                    self::borderSiteColor($cols_asrray[$cellGranTotales].$j,'000000','left',$objPHPExcel);
                    self::borderSiteColor($cols_asrray[($cellGranTotales+1)].$j,'000000','right',$objPHPExcel);
                }else{
                    self::borderSiteColor($cols_asrray[($cellGranTotales+1)].$j,'000000','right',$objPHPExcel);
                } 
                
            }
//            
            //TOTAL DE INGRESOS
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'3', "=SUM(".$cols_asrray[(2)].'3'.":".$cols_asrray[($cellGranTotales-1)].'3'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'3','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'3','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'4', "=SUM(".$cols_asrray[(2)].'4'.":".$cols_asrray[($cellGranTotales-1)].'4'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'4','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'4','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'5', "=SUM(".$cols_asrray[(2)].'5'.":".$cols_asrray[($cellGranTotales-1)].'5'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'5','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'5','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'6', "=SUM(".$cols_asrray[(1)].'6'.":".$cols_asrray[($cellGranTotales-2)].'6'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'6','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'6','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'7', "=SUM(".$cols_asrray[(1)].'7'.":".$cols_asrray[($cellGranTotales-2)].'7'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'7','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'7','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'8', "=SUM(".$cols_asrray[(1)].'8'.":".$cols_asrray[($cellGranTotales-2)].'8'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'8','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'8','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'9', "=SUM(".$cols_asrray[(1)].'9'.":".$cols_asrray[($cellGranTotales-2)].'9'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'9','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'9','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'10', "=SUM(".$cols_asrray[(2)].'10'.":".$cols_asrray[($cellGranTotales-1)].'10'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'10','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'10','USD$',$objPHPExcel);

            //TOTAL DE MARGEN
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'12', "=SUM(".$cols_asrray[(2)].'12'.":".$cols_asrray[($cellGranTotales-1)].'12'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'12','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'12','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'13', "=SUM(".$cols_asrray[(2)].'13'.":".$cols_asrray[($cellGranTotales-1)].'13'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'13','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'13','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'14', "=SUM(".$cols_asrray[(2)].'14'.":".$cols_asrray[($cellGranTotales-1)].'14'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'14','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'14','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'15', "=SUM(".$cols_asrray[(1)].'15'.":".$cols_asrray[($cellGranTotales-2)].'15'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'15','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'15','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'16', "=SUM(".$cols_asrray[(1)].'16'.":".$cols_asrray[($cellGranTotales-2)].'16'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'16','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'16','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'17', "=SUM(".$cols_asrray[(1)].'17'.":".$cols_asrray[($cellGranTotales-2)].'17'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'17','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'17','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales)].'18', "=SUM(".$cols_asrray[(1)].'18'.":".$cols_asrray[($cellGranTotales-2)].'18'.")");
            self::fontSite($cols_asrray[($cellGranTotales)].'18','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales)].'18','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'19', "=SUM(".$cols_asrray[(2)].'19'.":".$cols_asrray[($cellGranTotales-1)].'19'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'19','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'19','USD$',$objPHPExcel);
            
            //TOTAL DE EGRESOS
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'21', "=SUM(".$cols_asrray[(2)].'21'.":".$cols_asrray[($cellGranTotales-1)].'21'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'21','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'21','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'22', "=SUM(".$cols_asrray[(2)].'22'.":".$cols_asrray[($cellGranTotales-1)].'22'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'22','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'22','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'23', "=SUM(".$cols_asrray[(2)].'23'.":".$cols_asrray[($cellGranTotales-1)].'23'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'23','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'23','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'24', "=SUM(".$cols_asrray[(2)].'24'.":".$cols_asrray[($cellGranTotales-1)].'24'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'24','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'24','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'25', "=SUM(".$cols_asrray[(2)].'25'.":".$cols_asrray[($cellGranTotales-1)].'25'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'25','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'25','USD$',$objPHPExcel);
            
            //TOTAL DE TOTAL EBITDA
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'27', "=SUM(".$cols_asrray[(2)].'27'.":".$cols_asrray[($cellGranTotales-1)].'27'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'27','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'27','USD$',$objPHPExcel);
            
            //TOTAL DE IMPUESTOS
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'29', "=SUM(".$cols_asrray[(2)].'29'.":".$cols_asrray[($cellGranTotales-1)].'29'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'29','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'29','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'30', "=SUM(".$cols_asrray[(2)].'30'.":".$cols_asrray[($cellGranTotales-1)].'30'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'30','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'30','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'31', "=SUM(".$cols_asrray[(2)].'31'.":".$cols_asrray[($cellGranTotales-1)].'31'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'31','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'31','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'32', "=SUM(".$cols_asrray[(2)].'32'.":".$cols_asrray[($cellGranTotales-1)].'32'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'32','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'32','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'33', "=SUM(".$cols_asrray[(2)].'33'.":".$cols_asrray[($cellGranTotales-1)].'33'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'33','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'33','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'34', "=SUM(".$cols_asrray[(2)].'34'.":".$cols_asrray[($cellGranTotales-1)].'34'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'34','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'34','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'35', "=SUM(".$cols_asrray[(2)].'35'.":".$cols_asrray[($cellGranTotales-1)].'35'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'35','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'35','USD$',$objPHPExcel);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'36', "=SUM(".$cols_asrray[(2)].'36'.":".$cols_asrray[($cellGranTotales-1)].'36'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'36','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'36','USD$',$objPHPExcel);
            
            //TOTAL DE Ganancia Neta
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'38', "=SUM(".$cols_asrray[(2)].'38'.":".$cols_asrray[($cellGranTotales-1)].'38'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'38','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'38','USD$',$objPHPExcel);
            
            //TOTAL DE CICLO DE INGRESOS
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'40', "=SUM(".$cols_asrray[(2)].'40'.":".$cols_asrray[($cellGranTotales-1)].'40'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'40','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'40','USD$',$objPHPExcel);
            
            //TOTAL DE GANANCIA TOTAL NETA
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($cellGranTotales+1)].'42', "=SUM(".$cols_asrray[(2)].'42'.":".$cols_asrray[($cellGranTotales-1)].'42'.")");
            self::fontSite($cols_asrray[($cellGranTotales+1)].'42','000000','10','right',$objPHPExcel);
            self::setCurrency($cols_asrray[($cellGranTotales+1)].'42','USD$',$objPHPExcel);
        
    }
    
    public static function generateTitles($objPHPExcel) {
        
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
//            $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(0);   
//            $objPHPExcel->getActiveSheet()->getRowDimension('20')->setRowHeight(0);   
//            $objPHPExcel->getActiveSheet()->getRowDimension('26')->setRowHeight(0);   
//            $objPHPExcel->getActiveSheet()->getRowDimension('28')->setRowHeight(0);   
//            $objPHPExcel->getActiveSheet()->getRowDimension('37')->setRowHeight(0);  
//            $objPHPExcel->getActiveSheet()->getRowDimension('39')->setRowHeight(0);  
//            $objPHPExcel->getActiveSheet()->getRowDimension('41')->setRowHeight(0);  
            
            
            $cols_asrray = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
                                 'R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH',
                                 'AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW',
                                 'AX','AY','AZ');
            
            $arrayFechas = Array('-01','-02','-03','-04','-05','-06','-07','-08','-09','-10','-11','-12','-13',
                                 '-14','-15','-16','-17','-18','-19','-20',
                                 '-21','-22','-23','-24','-25','-26','-27','-28','-29','-30','-31');
            
            
            $nombreCabinas = Cabina::model()->findAllBySql("SELECT Id, Nombre FROM cabina WHERE status = 1 AND Id !=18 AND Id != 19 ORDER BY Nombre;");
            $cellGranTotales = (count($nombreCabinas)*2)+1;
            
            $paridad = Paridad::model()->findBySql("SELECT Valor FROM paridad WHERE Fecha <= '$day-01' ORDER BY Fecha DESC LIMIT 1;")->Valor;
            
            
            
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
            
            $traficoDollarMargen = 0;
            $servMovDollarMargen = 0;
            $servClaroDollarMargen = 0;
            $servDirecTvDollarMargen = 0;
            $servNextelDollarMargen = 0;
            $subArriendoMargen = 0;
            $totalVentasMargen = 0;
            $totalMargen = 0;
            
            $costoLlamadas = 0;
            $comisionMov = 0;
            $comisionClaro = 0;
            $comisionDiecTv = 0;
            $comisionNextel = 0;
            
            $alquiler = 0;
            $nomina = 0;
            $servGenerales = 0;
            $otrosGastos = 0;

            $totalGastos = 0;
            
            
            $sunat = 0;
            $arbitrios = 0;
            $otrosImpuestos = 0;
                
            $totalImpuestos = 0;
            
            
            $TOTALEBITDA = 0;
            $GANANCIANETA = 0;
            $AJUSTECICLOINGRESO = 0;
            $GANANCIATOTALNETA = 0;

            
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
                $trafico = self::getDataFullCarga($day,$value->Id,'TraficoCaptura');
                $traficoDollar = $trafico;
                
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
                
                //VALORES DEL CONTENIDO (MARGEN)
                $costoLlamadas = self::getDataComisionFullCarga($day,$value->Id,'llamadas')/$paridad;
                $comisionMov = self::getDataComisionFullCarga($day,$value->Id,1)/$paridad;
                $comisionClaro = self::getDataComisionFullCarga($day,$value->Id,2)/$paridad;
                $comisionDiecTv = self::getDataComisionFullCarga($day,$value->Id,4)/$paridad;
                $comisionNextel = self::getDataComisionFullCarga($day,$value->Id,3)/$paridad;

                $traficoDollarMargen = $traficoDollar-$costoLlamadas;
                $servMovDollarMargen = $servMovDollar-$comisionMov;
                $servClaroDollarMargen = $servClaroDollar-$comisionClaro;
                $servDirecTvDollarMargen = $servDirecTvDollar-$comisionDiecTv;
                $servNextelDollarMargen = $servNextelDollar-$comisionNextel;
                $subArriendoMargen = $subArriendoDollar;
                $totalVentasMargen = $servMovDollarMargen+$servClaroDollarMargen+$servDirecTvDollarMargen+$servNextelDollarMargen;
                $totalMargen = $traficoDollarMargen+$totalVentasMargen+$subArriendoMargen;
                
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
                $totalImpuestos = $sunat+$arbitrios+$otrosImpuestos+($traficoDollar*0.5/100)+($traficoDollar*0.5/100)+($traficoDollar*1/100)+($traficoDollar*1.5/100);
                
                //VALORES DE CONTENIDO (TOTALES)
                $TOTALEBITDA = $totalMargen-$totalGastos;
                $GANANCIANETA = $TOTALEBITDA - $totalImpuestos;
                $AJUSTECICLOINGRESO = self::getDataCicloIngreso($day, $value->Id, $paridad);
                $GANANCIATOTALNETA = $GANANCIANETA + $AJUSTECICLOINGRESO;
                
                
                
                
                
                
                
                
                
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
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'12', $totalMargen);
                self::fontSite($cols_asrray[($i+1)].'12','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'12','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'13', $traficoDollarMargen);
                self::fontSite($cols_asrray[($i+1)].'13','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'13','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'14', $totalVentasMargen);
                self::fontSite($cols_asrray[($i+1)].'14','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'14','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'15', $servMovDollarMargen);
                self::fontSite($cols_asrray[$i].'15','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'15','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'16', $servClaroDollarMargen);
                self::fontSite($cols_asrray[$i].'16','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'16','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'17', $servDirecTvDollarMargen);
                self::fontSite($cols_asrray[$i].'17','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'17','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[$i].'18', $servNextelDollarMargen);
                self::fontSite($cols_asrray[$i].'18','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[$i].'18','USD$',$objPHPExcel);
                
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
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'34', ($traficoDollar*1.5/100));
                self::fontSite($cols_asrray[($i+1)].'34','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'34','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'35', $arbitrios);
                self::fontSite($cols_asrray[($i+1)].'35','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'35','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'36', $otrosImpuestos);
                self::fontSite($cols_asrray[($i+1)].'36','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'36','USD$',$objPHPExcel);
                
                
                //TOTALES
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'27', $TOTALEBITDA);
                self::fontSite($cols_asrray[($i+1)].'27','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'27','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'38', $GANANCIANETA);
                self::fontSite($cols_asrray[($i+1)].'38','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'38','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'40', $AJUSTECICLOINGRESO);
                self::fontSite($cols_asrray[($i+1)].'40','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'40','USD$',$objPHPExcel);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cols_asrray[($i+1)].'42', "=SUM(".$cols_asrray[($i+1)].'38'.":".$cols_asrray[($i+1)].'40'.")");
                self::fontSite($cols_asrray[($i+1)].'42','000000','10','right',$objPHPExcel);
                self::setCurrency($cols_asrray[($i+1)].'42','USD$',$objPHPExcel);

                
                
                //CONFIGURACION DEL ESTILO
                self::borderColor($cols_asrray[$i].'1','000000',$objPHPExcel);
                self::borderColor($cols_asrray[$i].'2','000000',$objPHPExcel);
                
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[$i])->setWidth(16);
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols_asrray[($i+1)])->setWidth(16);
                
                
                for($j=1;$j<43;$j++){
                    self::borderColor('A'.$j,'FFFFFF',$objPHPExcel);
                    self::borderColor($cols_asrray[$i].$j,'FFFFFF',$objPHPExcel);
                    self::borderColor($cols_asrray[($i+1)].$j,'FFFFFF',$objPHPExcel);
                    
                    if($j == 3 || $j == 12 || $j == 21 || $j == 27 || $j == 29 || $j == 38 || $j == 40 || $j == 42){
                        self::cellColor($cols_asrray[$i].$j, 'AAAAAA',$objPHPExcel);
                        self::cellColor($cols_asrray[($i+1)].$j, 'AAAAAA',$objPHPExcel);
                        
                        self::borderSiteColor($cols_asrray[$i].$j,'AAAAAA','right',$objPHPExcel);
                        self::borderSiteColor($cols_asrray[$i].$j,'000000','left',$objPHPExcel);
                        self::borderSiteColor($cols_asrray[($i+1)].$j,'000000','right',$objPHPExcel);
                    }else{
                        self::borderSiteColor($cols_asrray[($i+1)].$j,'000000','right',$objPHPExcel);
                    }    
                }
                
                

                
                $i = $i + 2;
                
            }
            
            //GENERA LA COLUMNA TOTALES CON SUS VALORES
            self::generateTotal($cols_asrray,$cellGranTotales,$objPHPExcel);
            
            //GENERA LOS TITULOS DE LA COLUMNA 'A'
            self::generateTitles($objPHPExcel);

            
    }
    
}
?>