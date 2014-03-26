Etelix_SINCA
============

Sistema para control de Cabinas Telefonicas

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
