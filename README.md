Etelix_SINCA
============

Sistema para control de Cabinas Telefonicas

Realese 2.0

- Corrección en Modulo de Fallas: Se pueden Generar los Reportes Consolidados de Fallas a Partir de Cualquier Fecha. 
- Creación del Reporte de Estado de Resultados y REMO. 
- Agregada Carga de Trafico de Sori y Costo en Llamadas.
- Agregada Carga de Archivo FullCarga. 
- Cambio en el Formulario para Delcarar los nuevos Servicios por los Operadores por Compañia.
- Migracion de Data de la Tabla Balance a Ciclo de Ingreso, Deposito, Saldo Cabinas y Detalleingreso.
- Agragadas las Nuevas Compañias de FullCarga. 
- Cambio en la Tabla de Comisiones para Generarlas por Tipo de Ingreso.
- Creacion de Tablas de Ciclo de Ingreso, Deposito, Saldo Cabinas y Tipo de Comision. 


Realese 1.8.3.1
- Fix en Ciclo de Ingresos, se estaba descartando valores de la cabina COMAS en funciones de ACUMULADO.
    
Realese 1.8.3
    - Agregadas Funciones para Acumulado, Sobrante y Sobrante Acumulado en Ciclo de Ingresos, corregios valores.
    - Reportes Consolidados de Fallas, Resumido y Completo con sus exportables sin Imprimir.
    - Agregdao tiempo de Cerrado para las fallas y tiempo de vida en los reportes de estado de fallas.

Realese 1.8.2
    - Modificar el Horario de las Cabinas
    - El Panel de Control ahora indica “Dia No Laborable”, para aquellas cabinas que no trabajen los domingos.
    - Nueva interfaz para reportar Fallas
    - Reporte de Estado de Fallas, permite Cerrar el TT, agregar una observación e indicar el destino relacionado a la falla. 
    - Reporte de Matriz General de Fallas, por dia.
    - Reporte de Matriz de Total de TT’s por Cabina.
    - Exportablñes para todos los reportes de Fallas.
    - Eliminada pantalla de bienvenida, después de autenticarse el usuario es llevado a una pantalla dependiendo de su ROL. (Ej: un usuario tipo Socio es llevado directamente a la pantalla del Tablero de Control, mientras que un operador de Cabina va directamente a la pantalla de Declarar Inicio de Jornada Laboral).

Realese 1.8.1
    - Nuevo MVC Ingresos
    - Nuevo tipo de UYsuario NOC, solo ve Novedades/Fallas

Release 1.8
    - Se migraron a yiiconsole los reportes automaticos.
    - Cambios menores en el estilo del tablero de actividades, ademas de corregir acentos en las palabras.

Realese 1.7.2
    - Validacion de Horarios de Cabina en Tablero de Control.
    - Orden por Categoria en Matriz Evolucion.
    - Filtro por Cargo en Empleado.
    - Ordenamiento en Admin Nomina por Cabina y Cargo (PENDIENTE ORDEN POR CARGO REAL)
    - Exportables para admin de Banco y Reteso Bancario
    - Agregado nombre de dia en movimientos de ingresos en el Reteso Bancario.
    - Se excluyo Transferencias entre cuentas de Gastos en Matriz de Gastos.


Realese 1.7.1
    - Exportar para Log,Novedades, Nomina.
    - Agregados mes anterior, categoria y moneda a Estados de Gastos exportar.
    - Agregados Numero de Cuenta a Empleado.
    - Cambio de interfaz a EstadoDeGastos.
    - Nueva vista de Horarios de Cabinas.
    - Corregido error de tablas para cabinas inactivas, donde se pierde la tabla al pasar de página.
    - Validación en Empleado para no registrar empleados con misma Cedula.
    - Nuevo Reporte Matriz de Nomina con sus versiones exportables.
    - Reportes exportables para PABrightstar 


Realese 1.7
    - Asignacion de Categoria de Gatos (Declaracion de Gasto y Matriz).
    - Carga Automatica de los Datos de Nomina por Empleado (Declaracion de Gasto).
    - Creacion del Modulo de Nomina.
    - Creacion de la Matriz de Gastos Evolucion.

Release 1.6.4
    - Agregada a matriz de gastos las categorias
    - Agregada las categorias de los gastos
Release 1.6.3.1
    - Correciones: Generar excel, enviar mail, imprimir de matriz de gastos.
    - Correciones: Generar excel, enviar mail, imprimir de matriz de gastos evolucion.
    - Eliminado simbolos de moneda de archivos excel.
Release 1.6.3
    - Agregada matriz de gastos evolucion.(pendiente generar excel, mail e imprimir)
    - Agregados totales en matriz de gastos, ademas solo incluyen gastos aprobados.
Release 1.6.2
    - Correccion de urlManager, ya los usuarios pueden actualizar sus contrasenas y gii no se ve afectado
    - Corregido error en estado de gastos, no permitia declarar las aprobados y cuentas y fechas
    - Corregido error en estado de gastos

Release 1.6.1
    - Correccion de envio de correo de novedades

Release 1.6
    - Cambio de look and feel de la interfaz en general.
    - Mejora en el proceso de Exportacion a Excel (Balances).
    - Mejora en el proceso de Visualizacion para Impresion (Balances).
    - Mejora en el envio de del Reporte al Correo Electronico (Balances).
    - Creacion de la Matriz de Gastos (Gastos). 
Realese 1.5.3
    -Cambio en update para saldo de apertura banco.
    -Agregado fecha de deposito en update balance.
    -Se actualiza la cuenta de igual forma cuando se declara depositos o actualizas balance.
    -Descripcion de referencia para los ingresos, indica la fecha de las ventas que corresponde el deposito
Realese 1.5.2
    -Formulario para cabina Etelix/Perú ahora posee CLARO y MOVISTAR para declarar las ventas.
    -Campo de Fecha en Formulario Declarar Saldo Apertura Banco.
