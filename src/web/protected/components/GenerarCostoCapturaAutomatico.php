<?php
/**
 * @package components
 * @version 1.0
 */
class GenerarCostoCapturaAutomatico extends CApplicationComponent
{

    public function init() 
    {
       
    }
    
    /**
     * Ejecuta el comando de ciclo de ingreso total automatico
     * @access public
     * @param date $dateSet
     * @author Ramon Ramirez
     */
    public function run($dateSet=NULL)
    {
            $fecha = date( "Y-m-d", strtotime( "-1 day", strtotime( date('Y-m-d', time()) ) ) );
            $arrayCarriers = Array();
            $arrayCa = Array();
            $i = 0;
            
            $cabinasActivas = Cabina::model()->findAll('Id != 18 AND Id != 19 AND status = 1');
            $paridad = Paridad::getParidad($fecha);
            $logSori = LogSori::getLogSori($fecha);

            if(count($logSori) > 1){

                foreach ($cabinasActivas as $key => $cabinas) {

                    $cabinaId = $cabinas->Id;

                    if($cabinas->Nombre != 'ETELIX - PERU'){
                        $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%$cabinas->Nombre%';");
                    }else{
                        $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%ETELIX.COM%';");
                    }

                    foreach ($cabinasSori as $key2 => $value) {
                        $arrayCa[$key][$key2] = $value->id;
                        $arrayCarriers[$key] = implode(',', $arrayCa[$key]);
                    }

                    $montoSoriRevenue = BalanceSori::getTraficoCaptura($fecha,$arrayCarriers[$key]);
                    $montoSoriCosto = BalanceSori::getCostoLlamadas($fecha,$arrayCarriers[$key]);

                    $verificaIngreso = Detalleingreso::model()->find("FechaMes = '$fecha' AND CABINA_Id = $cabinaId AND TIPOINGRESO_Id = 16");

                    if($verificaIngreso == NULL){
                        $modelIngreso = new Detalleingreso;
                        $modelIngreso->Monto = $montoSoriRevenue;
                        $modelIngreso->FechaMes = $fecha;        
                        $modelIngreso->CABINA_Id = $cabinaId;
                        $modelIngreso->USERS_Id=  58;
                        $modelIngreso->TIPOINGRESO_Id = 16;
                        $modelIngreso->moneda = 1;
                        if($cabinaId == 17){
                            $modelIngreso->CUENTA_Id = 2; 
                        }else{
                            $modelIngreso->CUENTA_Id = 4; 
                        }    
                        $modelIngreso->Costo_Comision = $montoSoriCosto;

                        if($modelIngreso->save()){ 
                            $i++; 

                            CicloIngresoModelo::saveDifCaptura($fecha,$cabinaId,$montoSoriRevenue,$paridad);

                        }elseif($modelIngreso->save(false)){
                            $i++; 
                            
                            CicloIngresoModelo::saveDifCaptura($fecha,$cabinaId,$montoSoriRevenue,$paridad);
                        }
                    }    

                }

            }
            
//            echo $fecha;
  
    }
}

