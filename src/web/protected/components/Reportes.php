<?php
/**
 * @package components
 */
class Reportes extends CApplicationComponent
{
    public function init() 
    {
       
    }

    /**
     * busca el reporte en componente "balanceAdmin" hace la consulta y extrae 
     * los atributos necesarios para luego formar el html y enviarlo por correo y/o exportarlo a excel
     * @param array $ids
     * @return string
     */
    
    public function reporteConsolidado($day,$name,$dir)
    {
        $var=  reporteConsolidado::reporte($day,$name,$dir);
        return $var;
    }
    
    public function reporteConsolidadoResumido($day,$name,$dir)
    {
        $var=  reporteConsolidadoResumido::reporte($day,$name,$dir);
        return $var;
    }
    
    public function estadoResultado($day,$name,$dir)
    {
        $var=  estadoResultado::reporte($day,$name,$dir);
        return $var;
    }
    
    public function estadoResultadoRemo($day,$name,$dir)
    {
        $var=  estadoResultadoRemo::reporte($day,$name,$dir);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */
    
    public function balanceAdmin($fecha,$cabina,$name,$type)
    {
        $var=  balanceAdmin::reporte($fecha,$cabina,$name,$type);
        return $var;
    }

    public function libroVenta($fecha,$cabina,$name,$type)

    {
        $var= libroVenta::reporte($fecha,$cabina,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function depositoBancario($ids,$name,$type)

    {
        $var= depositoBancario::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function brightstar($ids,$name,$type)

    {
        $var= brightstar::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function captura($ids,$name,$type)

    {
        $var= captura::reporte($ids,$name,$type);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function cicloIngreso($ids,$name,$complete,$type,$report)

    {
        $var= cicloIngreso::reporte($ids,$name,$complete,$type,$report);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function cicloIngresoTotal($ids,$name,$complete,$type,$report)

    {
        $var= cicloIngresoTotal::reporte($ids,$name,$complete,$type,$report);
        return $var;
    }
    
    /**
     * Documentacion va aqui
     */

    public function estadoNovedades($ids,$name)
    {
        $var= estadoNovedades::reporte($ids,$name);
        return $var;
    }
    
    public function estadoGasto($ids,$name,$type)
    {
        $var= estadoGasto::reporte($ids,$name,$type);
        return $var;
    }
    
    public function adminIngreso($ids,$name,$type)
    {
        $var= adminIngreso::reporte($ids,$name,$type);
        return $var;
    }
    
    public function matrizGastos($ids,$nombre,$type)
    {
        $var= matrizGastos::reporte($ids,$nombre,$type);    
        return $var;
    }
    
    public function matrizIngresos($ids,$nombre,$type)
    {
        $var= matrizIngresos::reporte($ids,$nombre,$type);    
        return $var;
    }
    
    public function matrizNomina($mes,$nombre,$type)
    {
        $var= matrizNomina::reporte($mes,$nombre,$type);    
        return $var;
    }
    
    public function matrizNovedad($mes,$nombre)
    {
        $var= matrizNovedad::reporte($mes,$nombre);    
        return $var;
    }
    
    public function matrizNovedadSemana($mes,$nombre)
    {
        $var= matrizNovedadSemana::reporte($mes,$nombre);    
        return $var;
    }
    
    public function matrizGastosEvolucion($mes,$cabina,$nombre,$type)
    {
        $var= matrizGastosEvolucion::reporte($mes,$cabina,$nombre,$type);    
        return $var;
    }
    
    public function tableroControl($date,$name)
    {
        $var= tableroControl::reporte($date,$name);    
        return $var;
    }
    
    public function novedadFalla($ids,$name)
    {
        $var= novedadFalla::reporte($ids,$name);    
        return $var;
    }
    
    public function logs($ids,$name)
    {
        $var= logs::reporte($ids,$name);    
        return $var;
    }
    
    public function horarioCabina($ids,$name)
    {
        $var= horarioCabina::reporte($ids,$name);    
        return $var;
    }
    
    public function adminBanco($ids,$name,$type)
    {
        $var= adminBanco::reporte($ids,$name,$type);    
        return $var;
    }
    
    public function nominaEmpleado($ids,$name)
    {
        $var= nominaEmpleado::reporte($ids,$name);    
        return $var;
    }
    
    public function retesoMovimiento($id,$name,$type)
    {
        $var= retesoMovimiento::reporte($id,$name,$type);    
        return $var;
    }
    
    public function pabrightstarReport($ids,$name,$type)
    {
        $var= pabrightstarReport::reporte($ids,$name,$type);    
        return $var;
    }

    /**
     * Documentacion va aqui
     */
    public static function defineStyleTd($type)
    {
        switch ($type)
        {
            case ($type%2==0):
                $style="style ='background: #E5F1F4; font-size: 12px; text-align: center; background-position: initial initial; background-repeat: initial initial;font-size: 11px;'";
                break;
            case ($type%2!=0):
                $style="style ='background: #F8F8F8; font-size: 12px; text-align: center; background-position: initial initial; background-repeat: initial initial;font-size: 11px;'";
                break;
        }
        return $style;
    }

    /**
     * Documentacion va aqui
     */
    public static function defineStyleHeader($type)
    {
        switch ($type){
            case "balance":
                $style="style='background:#00992B;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "libroV":
                $style="style='background:#FFBB00;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "depositos":
                $style="style='background:#1967B2;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "captura":
                $style="style='background:#cc99cc;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "brightstar":
                $style="style='background:#FF9933;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
            case "sobrante":
                $style="style='background:#5E99F2;color:#FFF;border:0px solid black; font-size: 12px;'";
                break;
        }
        return $style;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function defineHeader($type)
    {
        switch ($type) {
            case "balance":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2" width="80">Cabina</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c3">Saldo Apertura (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c5">Trafico (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c6">Servicios Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Servicios Claro (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Servicios DirecTv (S/.)</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Servicios Nextel (S/.)</th>    
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Monto Deposito (S/.)</th>
                            </tr>
                        </thead>';
                break;
            case "libroV":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("libroV").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c2" width="80">Cabina</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c5">Trafico (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c6">Servicios Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Servicios Claro (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Servicios DirecTv (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Servicios Nextel (S/.)</th>    
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Otros Servicios FullCarga (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Otros Servicios (S/.)</th>    
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Total Ventas (S/.)</th>    
                            </tr>
                        </thead>';
                break;
            case "depositos":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("depositos").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c2" width="80">Cabina</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Total  Ventas (S/.) "A"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Monto Deposito (S/.) "B"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Numero de Ref Deposito</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Monto Banco (S/.) "C"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Diferencial Bancario (S/.) "C-A"</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">'.htmlentities('Conciliación Bancaria (S/.) "C-B"', ENT_QUOTES,'UTF-8').'</th>    
                            </tr>
                        </thead>';
                break;
            case "captura":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("captura").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c2" width="80">Cabina</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c6">Trafico Captura (USD $)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c7">Paridad Cambiaria (S/.|$)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Capt Soles</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Soles (S/.)</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Dollar (USD $)</th>       
                            </tr>
                        </thead>';
                break;
            case "brightstar":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("brightstar").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c2" width="80">Cabina</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Servicios Movistar (S/.)</th>    
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Diferencial Movistar (S/.)</th>
                                
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Servicios Claro (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c6">Diferencial Claro (S/.)</th>

                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Servicios DirecTv (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c7">Diferencial DirecTv (S/.))</th>

                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Servicios Nextel (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Nextel (S/.)</th>   
                            </tr>
                        </thead>';
                break;
            case "cicloI":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2" width="80">Cabina</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c5">Total de Ventas (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Diferencial Bancario (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">'.htmlentities('Conciliación Bancaria (S/.)', ENT_QUOTES,'UTF-8').'</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Movistar (S/.)</th>  
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Claro (S/.)</th> 
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial DirecTv (S/.)</th>  
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Nextel (S/.)</th>     
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c7">Paridad Cambiaria (S/.|$)</th> 
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Soles (S/.)</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Dollar (USD $)</th> 
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Acumulado Dif. Captura (USD $)</th>   
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante (USD $)</th> 
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante Acumulado (USD $)</th>    
                            </tr>
                        </thead>';
                break;
            case "cicloIC":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas" width="70">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2" width="80">Cabina</th>
                                    
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c5">Trafico (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c6">Servicios Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Servicios Claro (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Servicios DirecTv (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Servicios Nextel (S/.)</th>    
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Otros Servicios FullCarga (S/.)</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Otros Servicios (S/.)</th>    
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c8">Total Ventas (S/.)</th>
                                    
                                <th '.self::defineStyleHeader("depositos").' id="b alance-grid_c6">Fecha del Deposito</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Hora del Deposito</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Monto Deposito (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Monto Banco (S/.)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Diferencial Bancario (S/.) </th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">'.htmlentities('Conciliación Bancaria (S/.)', ENT_QUOTES,'UTF-8').'</th>
                                
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c5">Diferencial Movistar (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c6">Diferencial Claro (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c7">Diferencial DirecTv (S/.)</th>
                                <th '.self::defineStyleHeader("brightstar").' id="balance-grid_c8">Diferencial Nextel (S/.)</th> 
                                
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c6">Trafico Captura (USD $)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c7">Paridad Cambiaria (S/.|$)</th>
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Capt Soles</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Soles (S/.)</th>   
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Diferencial Captura Dollar (USD $)</th> 
                                
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Acumulado Dif. Captura (USD $)</th>   
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante (USD $)</th> 
                                <th '.self::defineStyleHeader("sobrante").' id="balance-grid_c8">Sobrante Acumulado (USD $)</th>    
                            </tr>
                        </thead>';
                break;
            case "matriz":
                $header='<thead>
                            <th '.self::defineStyleHeader("matriz").'><img style="padding-left: 5px; width: 17px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/mattskitchen/img/Monitor.png" /></td>
                            <th '.self::defineStyleHeader("matriz").'><h3>Chimbote</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Etelix-Peru</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Huancayo</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Iquitos 01</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Iquitos 03</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Piura</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Pucallpa</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Resto</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Surquillo</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Tarapoto</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Trujillo 01</h3></th>
                            <th '.self::defineStyleHeader("matriz").'><h3>Trujillo 03</h3></th>
                        </thead>';

                break;
            case "estadoGasto":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Mes</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Categoria</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Tipo Gasto</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">'.htmlentities('Descripción', ENT_QUOTES,'UTF-8').'</th>    
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Fecha de Vencimiento</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Mes Anterior</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Monto</th>    
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Moneda</th>  
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Beneficiario</th>  
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Estatus</th> 
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Numero de Transferencia</th>   
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Fecha de Transferencia</th> 
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Cuenta</th>     
                            </tr>
                        </thead>';

                break;
            case "estadoNovedades":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Falla</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Locutorio(s)</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Destino</th> 
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Observaciones</th>   
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Estatus</th>
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Fecha Apertura</th>   
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Fecha Cierre</th> 
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Tiempo de Vida</th>     
                            </tr>
                        </thead>';

                break;
            case "adminIngreso":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Mes</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c2">Cabina</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Tipo de Ingreso</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Monto</th>    
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Moneda</th>      
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">'.htmlentities('Descripción', ENT_QUOTES,'UTF-8').'</th>    
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Numero de Transferencia</th>   
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Fecha de Transferencia</th> 
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c8">Cuenta</th>     
                            </tr>
                        </thead>';

                break;
            case "novedadFalla":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Hora</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c5">Tipo de Novedad</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c6">Usuario</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Descripcion</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Numero Telefonico</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Puesto de la Cabina</th>    
                            </tr>
                        </thead>';
                break;
            case "nominaEmpleado":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Codigo</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Nombre</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c5">Apellido</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c6">Identificacion</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Cabina</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Cargo</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Remuneracion</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Moneda</th> 
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Cuenta Bancaria</th>     
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Supervisor</th> 
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Fecha de Ingreso</th> 
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Estatus</th>     
                            </tr>
                        </thead>';
                break;
            case "log":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Hora</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c5">Fecha Esp</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c6">Accionlog</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Usuario</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Cabina</th>    
                            </tr>
                        </thead>';
                break;
            case "pabrightstar":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Compañia</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Saldo Apertura P.A.</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c6">Transferencia P.A.</th>
                                <th '.self::defineStyleHeader("libroV").' id="balance-grid_c7">Comision P.A.</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c8">Recarga P.A.</th> 
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Sub Total P.A.</th> 
                                <th '.self::defineStyleHeader("captura").' id="balance-grid_c8">Saldo Cierre P.A.</th>     
                            </tr>
                        </thead>';
                break;
            case "adminBanco":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("depositos").' id="Fechas">Fecha</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c2">Cuenta</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c5">Saldo Apertura</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c6">Ingresos</th>
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Egresos</th>  
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Saldo Libro</th>  
                                <th '.self::defineStyleHeader("depositos").' id="balance-grid_c7">Saldo Cierre</th>      
                            </tr>
                        </thead>';
                break;
            case "horarioCabina":
                $header='<thead>
                            <tr >
                                <th '.self::defineStyleHeader("balance").' id="Fechas">Nombre</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c2">Hora Inicio</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c5">Hora Fin</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c6">Hora Inicio Domingo</th>
                                <th '.self::defineStyleHeader("balance").' id="balance-grid_c7">Hora Fin Domingo</th>
                            </tr>
                        </thead>';
                break;
        }
        return $header;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function defineMonto($type,$number=null)
    {
        if($type == null)
        {
            $field = '0.00';
        }
        else
        {
            if((float)$number<0)
            {
                $field = '<font color="red">'.$type.'</font>';
            }
            else
            {
                if((float)$number>0)
                {
                    $field = '<font color="green">'.$type.'</font>';
                }
                else
                {
                    $field = $type;
                }    
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui, cambiar nombre a esta funcion
     */
    public static function defineMonto2($type,$number=null)
    {
        if($type == '-1')
        {
            $field = 'No Declarado';
        }
        else
        {
            if($type == null)
            {
                $field = '0.00';
            }
            else
            {
                if((float)$number<0)
                {
                    $field = '<font color="red">'.$type.'</font>';
                }
                else
                {
                    if((float)$number>0)
                    {
                        $field = '<font color="green">'.$type.'</font>';
                    }
                    else
                    {
                        $field = $type;
                    }    
                }
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function defineTotals($type,$number=null)
    {
        if($type == null)
        {
            $field = '0.00';
        }
        else
        {
            if((float)$number<0)
            {
                $field = '<font color="red">'.$type.'</font>';
            }
            else
            {
                if((float)$number>0)
                {
                    $field = '<font color="green">'.$type.'</font>';
                }
                else
                {
                    $field = $type;
                }    
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui, cambiar nombre a esta funcion
     */
    public static function defineTotals2($type,$number=null)
    {
        if($type == '-1')
        {
            $field = 'No Declarado';
        }
        else
        {
            if($type == null)
            {
                $field = '0.00';
            }
            else
            {
                if((float)$number<0)
                {
                    $field = '<font color="red">'.$type.'</font>';
                }
                else
                {
                    if((float)$number>0)
                    {
                        $field = '<font color="green">'.$type.'</font>';
                    }
                    else
                    {
                        $field = $type;
                    }    
                }
            }
        }
        return $field;
    }
    
    /**
     * Documentacion va aqui
     */
    public static function definePago($type,$number=null)
    {
        if($number == 'Pagada')
        {
            $field = $type;
        }
        else
        {
            $field = 'N/A';
        }
        return $field;
    }
    
    public static function format($monto,$type)
    {
        if($type == true)
        {
            $field = Utility::PuntoPorComa($monto);
        }
        else
        {
            $field = $monto;
        }
        return $field;
    }
    
    
}
?>